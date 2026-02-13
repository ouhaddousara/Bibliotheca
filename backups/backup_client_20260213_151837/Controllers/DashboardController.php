<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Copy;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the client dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $member = Auth::guard('client')->user();

        // Mes emprunts en cours
        $loans = Loan::with(['copy.book'])
            ->where('member_id', $member->id)
            ->whereNull('returned_at')
            ->latest()
            ->get();

        // Livres disponibles (suggestions)
        $availableBooks = Book::withCount(['copies' => function ($query) {
            $query->where('status', 'available');
        }])
        ->has('copies')
        ->whereHas('copies', function ($query) {
            $query->where('status', 'available');
        })
        ->limit(8)
        ->get();

        return view('client.dashboard', compact('loans', 'availableBooks'));
    }
}