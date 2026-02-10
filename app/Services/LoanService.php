<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Copy;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class LoanService
{
    /**
     * Create a new loan with transaction and validation
     *
     * @param array $data
     * @return Loan
     * @throws Exception
     */
    public function createLoan(array $data): Loan
    {
        return DB::transaction(function () use ($data) {
            // Validation des données
            $this->validateLoanData($data);

            // Vérification du nombre maximum d'emprunts
            $this->checkMaxLoansPerMember($data['member_id']);

            // Vérification de la disponibilité de l'exemplaire (avec verrouillage)
            $copy = $this->checkAndLockCopy($data['copy_id']);

            // Création de l'emprunt
            $loan = $this->createLoanRecord($data, $copy);

            // Mise à jour du statut de l'exemplaire
            $this->updateCopyStatus($copy, 'borrowed');

            // Audit trail
            $this->logLoanCreated($loan);

            return $loan;
        }, 5); // Retry 5 times in case of deadlock
    }

    /**
     * Process the return of a loan
     *
     * @param Loan $loan
     * @param string $condition
     * @param string|null $notes
     * @return void
     * @throws Exception
     */
    public function processReturn(Loan $loan, string $condition = 'good', ?string $notes = null): void
    {
        DB::transaction(function () use ($loan, $condition, $notes) {
            // Vérification : l'emprunt n'est pas déjà retourné
            if ($loan->returned_at) {
                throw new Exception('⚠️ Cet emprunt a déjà été retourné.');
            }

            // Mise à jour de l'emprunt
            $loan->update([
                'returned_at' => now(),
                'return_condition' => $condition,
                'notes' => $notes,
            ]);

            // Mise à jour du statut de l'exemplaire
            $statusMap = [
                'good' => 'available',
                'damaged' => 'damaged',
                'lost' => 'lost',
            ];

            $this->updateCopyStatus($loan->copy, $statusMap[$condition]);

            // Audit trail
            $this->logLoanReturned($loan, $condition, $notes);

            // Envoyer un email de confirmation si nécessaire
            if ($condition === 'good') {
                $this->sendReturnConfirmation($loan);
            }
        });
    }

    /**
     * Get all overdue loans
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOverdueLoans()
    {
        return Loan::with(['member', 'copy.book'])
            ->where('due_date', '<', now())
            ->whereNull('returned_at')
            ->orderBy('due_date', 'asc')
            ->get();
    }

    /**
     * Check if a member has reached the maximum number of loans
     *
     * @param int $memberId
     * @return bool
     * @throws Exception
     */
    public function checkMaxLoansPerMember(int $memberId): bool
    {
        $member = Member::findOrFail($memberId);
        
        $activeLoansCount = Loan::where('member_id', $memberId)
            ->whereNull('returned_at')
            ->count();

        $maxLoans = config('library.loan_conditions.max_books_per_member', 5);

        if ($activeLoansCount >= $maxLoans) {
            throw new Exception(
                sprintf(
                    '⚠️ Nombre maximum d\'emprunts atteint (%d livres).',
                    $maxLoans
                )
            );
        }

        return true;
    }

    /**
     * Validate loan data before creation
     *
     * @param array $data
     * @return void
     * @throws Exception
     */
    private function validateLoanData(array $data): void
    {
        $validator = Validator::make($data, [
            'member_id' => 'required|exists:members,id,is_active,1',
            'copy_id' => 'required|exists:copies,id,status,available',
            'borrowed_at' => 'required|date|before_or_equal:today',
        ], [
            'member_id.exists' => '⚠️ Adhérent introuvable ou compte désactivé',
            'copy_id.exists' => '⚠️ Exemplaire introuvable ou non disponible',
            'borrowed_at.before_or_equal' => '⚠️ La date d\'emprunt ne peut pas être dans le futur',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    /**
     * Check and lock a copy for borrowing
     *
     * @param int $copyId
     * @return Copy
     * @throws Exception
     */
    private function checkAndLockCopy(int $copyId): Copy
    {
        $copy = Copy::where('id', $copyId)
            ->where('status', 'available')
            ->lockForUpdate() // Verrouillage pessimiste pour éviter les doubles emprunts
            ->firstOrFail();

        if (!$copy) {
            throw new Exception('⚠️ Cet exemplaire n\'est pas disponible.');
        }

        return $copy;
    }

    /**
     * Create loan record
     *
     * @param array $data
     * @param Copy $copy
     * @return Loan
     */
    private function createLoanRecord(array $data, Copy $copy): Loan
    {
        $dueDate = $data['due_date'] ?? now()->addDays(config('library.loan_period_days', 14));

        return Loan::create([
            'member_id' => $data['member_id'],
            'copy_id' => $copy->id,
            'borrowed_at' => $data['borrowed_at'] ?? now(),
            'due_date' => $dueDate,
        ]);
    }

    /**
     * Update copy status
     *
     * @param Copy $copy
     * @param string $status
     * @return void
     */
    private function updateCopyStatus(Copy $copy, string $status): void
    {
        $copy->update(['status' => $status]);
    }

    /**
     * Log loan creation
     *
     * @param Loan $loan
     * @return void
     */
    private function logLoanCreated(Loan $loan): void
    {
        Log::channel('library')->info('Emprunt créé', [
            'loan_id' => $loan->id,
            'member_id' => $loan->member_id,
            'member_email' => $loan->member->email ?? 'N/A',
            'copy_id' => $loan->copy_id,
            'copy_code' => $loan->copy->code,
            'book_title' => $loan->copy->book->title,
            'borrowed_at' => $loan->borrowed_at->toDateTimeString(),
            'due_date' => $loan->due_date->toDateString(),
            'admin_id' => auth('admin')->id() ?? null,
            'ip_address' => request()->ip() ?? 'N/A',
        ]);
    }

    /**
     * Log loan return
     *
     * @param Loan $loan
     * @param string $condition
     * @param string|null $notes
     * @return void
     */
    private function logLoanReturned(Loan $loan, string $condition, ?string $notes): void
    {
        Log::channel('library')->info('Retour traité', [
            'loan_id' => $loan->id,
            'member_id' => $loan->member_id,
            'copy_id' => $loan->copy_id,
            'copy_code' => $loan->copy->code,
            'book_title' => $loan->copy->book->title,
            'returned_at' => $loan->returned_at->toDateTimeString(),
            'return_condition' => $condition,
            'notes' => $notes,
            'new_copy_status' => $loan->copy->status,
            'admin_id' => auth('admin')->id() ?? null,
            'ip_address' => request()->ip() ?? 'N/A',
        ]);
    }

    /**
     * Send return confirmation email
     *
     * @param Loan $loan
     * @return void
     */
    private function sendReturnConfirmation(Loan $loan): void
    {
        try {
            // Implémenter l'envoi d'email si nécessaire
            // Mail::to($loan->member->email)->send(new LoanReturnConfirmationMail($loan));
        } catch (Exception $e) {
            Log::channel('library')->error('Erreur envoi email confirmation retour', [
                'loan_id' => $loan->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Calculate days overdue
     *
     * @param Loan $loan
     * @return int
     */
    public function getDaysOverdue(Loan $loan): int
    {
        if ($loan->returned_at) {
            return 0;
        }

        return now()->diffInDays($loan->due_date, false);
    }

    /**
     * Check if a loan is overdue
     *
     * @param Loan $loan
     * @return bool
     */
    public function isOverdue(Loan $loan): bool
    {
        return $this->getDaysOverdue($loan) > 0;
    }
}