<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan; // ← Import explicite

class LoanController extends Controller
{
    /**
     * Display a listing of the member's loans.
     */
    public function index()
    {
        // Récupère l'adhérent connecté
        $member = Auth::guard('client')->user();
        
        // Récupère TOUS ses emprunts avec les relations nécessaires
        $loans = Loan::where('member_id', $member->id)
            ->with(['copy.book'])
            ->latest()
            ->paginate(15);

        // Calcule les statistiques SANS utiliser la relation (évite l'erreur)
        $stats = [
            'active' => $loans->whereNull('returned_at')->count(),
            'returned' => $loans->whereNotNull('returned_at')->count(),
            'overdue' => $loans->where('due_date', '<', now())
                            ->whereNull('returned_at')
                            ->count(),
        ];

        return view('client.loans.index', compact('loans', 'stats'));
    }
}