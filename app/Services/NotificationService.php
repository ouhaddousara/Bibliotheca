<?php

namespace App\Services;

use App\Models\Loan;
use App\Mail\OverdueReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class NotificationService
{
    /**
     * Send overdue reminder email
     *
     * @param Loan $loan
     * @return bool
     */
    public function sendOverdueReminder(Loan $loan): bool
    {
        try {
            // Vérifier que l'emprunt est en retard
            if (!$loan->isOverdue()) {
                Log::warning('Tentative d\'envoi de rappel pour un emprunt non en retard', [
                    'loan_id' => $loan->id,
                ]);
                return false;
            }

            // Vérifier que le membre est actif
            if (!$loan->member->is_active) {
                Log::warning('Tentative d\'envoi de rappel à un membre désactivé', [
                    'loan_id' => $loan->id,
                    'member_id' => $loan->member_id,
                ]);
                return false;
            }

            // Envoyer l'email
            Mail::to($loan->member->email)
                ->send(new OverdueReminderMail($loan));

            // Mettre à jour la date du dernier rappel
            $loan->update([
                'last_reminder_sent_at' => now(),
            ]);

            // Audit trail
            Log::channel('library')->info('Rappel de retard envoyé', [
                'loan_id' => $loan->id,
                'member_id' => $loan->member_id,
                'member_email' => $loan->member->email,
                'book_title' => $loan->copy->book->title,
                'days_overdue' => now()->diffInDays($loan->due_date, false),
            ]);

            return true;
        } catch (Exception $e) {
            Log::channel('library')->error('Erreur envoi rappel de retard', [
                'loan_id' => $loan->id,
                'member_email' => $loan->member->email ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    /**
     * Send bulk overdue reminders
     *
     * @param array $loanIds
     * @return array
     */
    public function sendBulkOverdueReminders(array $loanIds): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'skipped' => 0,
            'details' => [],
        ];

        foreach ($loanIds as $loanId) {
            try {
                $loan = Loan::with(['member', 'copy.book'])
                    ->findOrFail($loanId);

                if ($this->sendOverdueReminder($loan)) {
                    $results['success']++;
                    $results['details'][] = [
                        'loan_id' => $loanId,
                        'status' => 'success',
                        'email' => $loan->member->email,
                    ];
                } else {
                    $results['skipped']++;
                    $results['details'][] = [
                        'loan_id' => $loanId,
                        'status' => 'skipped',
                        'reason' => 'Non éligible',
                    ];
                }
            } catch (Exception $e) {
                $results['failed']++;
                $results['details'][] = [
                    'loan_id' => $loanId,
                    'status' => 'failed',
                    'error' => $e->getMessage(),
                ];

                Log::channel('library')->error('Erreur envoi rappel bulk', [
                    'loan_id' => $loanId,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Audit trail
        Log::channel('library')->info('Envoi bulk rappels terminé', [
            'total' => count($loanIds),
            'success' => $results['success'],
            'failed' => $results['failed'],
            'skipped' => $results['skipped'],
            'admin_id' => auth('admin')->id() ?? null,
        ]);

        return $results;
    }

    /**
     * Send welcome email to new member
     *
     * @param mixed $member
     * @return bool
     */
    public function sendWelcomeEmail($member): bool
    {
        try {
            // Implémenter l'envoi d'email de bienvenue
            // Mail::to($member->email)->send(new WelcomeMemberMail($member));
            
            Log::channel('library')->info('Email de bienvenue envoyé', [
                'member_id' => $member->id,
                'member_email' => $member->email,
            ]);

            return true;
        } catch (Exception $e) {
            Log::channel('library')->error('Erreur envoi email bienvenue', [
                'member_id' => $member->id ?? 'N/A',
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send loan confirmation email
     *
     * @param Loan $loan
     * @return bool
     */
    public function sendLoanConfirmation(Loan $loan): bool
    {
        try {
            // Implémenter l'envoi d'email de confirmation
            // Mail::to($loan->member->email)->send(new LoanConfirmationMail($loan));
            
            Log::channel('library')->info('Email confirmation emprunt envoyé', [
                'loan_id' => $loan->id,
                'member_email' => $loan->member->email,
                'book_title' => $loan->copy->book->title,
            ]);

            return true;
        } catch (Exception $e) {
            Log::channel('library')->error('Erreur envoi email confirmation emprunt', [
                'loan_id' => $loan->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}