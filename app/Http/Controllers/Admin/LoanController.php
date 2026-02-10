<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLoanRequest;
use App\Http\Requests\Admin\UpdateLoanRequest;
use App\Models\Loan;
use App\Models\Copy;
use App\Models\Member;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index(Request $request)
{
    $query = Loan::query()->with(['member', 'copy.book']);

    // Filtre par statut
    if ($request->status === 'current') {
        $query->whereNull('returned_at')->where('due_date', '>=', now());
    } elseif ($request->status === 'returned') {
        $query->whereNotNull('returned_at');
    } elseif ($request->status === 'overdue') {
        $query->where('due_date', '<', now())->whereNull('returned_at');
    }

    // Filtre par adhérent
    if ($request->member) {
        $query->where('member_id', $request->member);
    }

    // Recherche
    if ($request->search) {
        $query->whereHas('member', function($q) use ($request) {
            $q->where('firstname', 'like', "%{$request->search}%")
              ->orWhere('lastname', 'like', "%{$request->search}%");
        })->orWhereHas('copy.book', function($q) use ($request) {
            $q->where('title', 'like', "%{$request->search}%")
              ->orWhere('author', 'like', "%{$request->search}%");
        });
    }

    $loans = $query->latest()->paginate(15);
    $allMembers = Member::where('is_active', true)->orderBy('lastname')->get();

    return view('admin.loans.index', compact('loans', 'allMembers'));
}

    public function create()
    {
        $availableCopies = Copy::where('status', 'available')
            ->with('book')
            ->get();
        
        $activeMembers = Member::where('is_active', true)
            ->orderBy('lastname')
            ->get();

        return view('admin.loans.create', compact('availableCopies', 'activeMembers'));
    }

    public function store(StoreLoanRequest $request)
    {
        try {
            $loan = $this->loanService->createLoan($request->validated());

            Log::channel('library')->info('Emprunt créé', [
                'loan_id' => $loan->id,
                'admin_id' => auth('admin')->id(),
            ]);

            return redirect()->route('admin.loans.index')
                ->with('success', 'Emprunt enregistré ! 📖✨ Profitez bien de votre lecture.');

        } catch (\Exception $e) {
            Log::channel('library')->error('Erreur création emprunt', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(Loan $loan)
    {
        $loan->load(['member', 'copy.book']);

        return view('admin.loans.show', compact('loan'));
    }

    public function returnForm(Loan $loan)
    {
        $loan->load(['member', 'copy.book']);

        return view('admin.loans.return', compact('loan'));
    }

    public function processReturn(UpdateLoanRequest $request, Loan $loan)
    {
        try {
            $this->loanService->processReturn(
                $loan,
                $request->return_condition,
                $request->notes
            );

            Log::channel('library')->info('Retour traité', [
                'loan_id' => $loan->id,
                'admin_id' => auth('admin')->id(),
            ]);

            return redirect()->route('admin.loans.index')
                ->with('success', 'Retour validé ! ✅ Merci pour votre ponctualité.');

        } catch (\Exception $e) {
            Log::channel('library')->error('Erreur traitement retour', [
                'loan_id' => $loan->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(Loan $loan)
    {
        try {
            if ($loan->returned_at) {
                $loan->delete();
                $loan->copy->update(['status' => 'available']);

                return redirect()->route('admin.loans.index')
                    ->with('success', 'Emprunt supprimé avec succès !');
            } else {
                return back()
                    ->with('error', 'Impossible de supprimer un emprunt non retourné.');
            }

        } catch (\Exception $e) {
            Log::channel('library')->error('Erreur suppression emprunt', [
                'loan_id' => $loan->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
}