<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the client dashboard with personalized statistics.
     */
    public function index()
    {
        $member = Auth::guard('client')->user();

        // Statistiques personnelles de l'adhérent
        $stats = [
            'active_loans' => Loan::where('member_id', $member->id)
                ->whereNull('returned_at')
                ->count(),
            'returned_loans' => Loan::where('member_id', $member->id)
                ->whereNotNull('returned_at')
                ->count(),
            'overdue_loans' => Loan::where('member_id', $member->id)
                ->where('due_date', '<', now())
                ->whereNull('returned_at')
                ->count(),
            'available_books' => Book::whereHas('copies', function ($query) {
                    $query->where('status', 'available');
                })->count(),
        ];

        // Emprunts en retard de l'adhérent
        $overdueLoans = Loan::where('member_id', $member->id)
            ->where('due_date', '<', now())
            ->whereNull('returned_at')
            ->with('copy.book')
            ->orderBy('due_date', 'asc')
            ->get();

        // Livres disponibles (avec au moins 1 exemplaire dispo)
        $availableBooks = Book::withCount(['copies' => function ($query) {
                $query->where('status', 'available');
            }])
            ->whereHas('copies', function ($query) {
                $query->where('status', 'available');
            })
            ->limit(8)
            ->get();

        // Emprunts récents de l'adhérent
        $recentLoans = Loan::where('member_id', $member->id)
            ->with('copy.book')
            ->latest()
            ->limit(10)
            ->get();

        return view('client.dashboard', compact('stats', 'overdueLoans', 'availableBooks', 'recentLoans'));
    }

     /**
 * Display the client profile page.
 */
public function profile()
{
    $member = Auth::guard('client')->user();
    return view('client.profile', compact('member'));
}
    
}