<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'available_copies' => Copy::where('status', 'available')->count(),
            'borrowed_copies' => Copy::where('status', 'borrowed')->count(),
            'overdue_count' => Loan::where('due_date', '<', now())
                ->whereNull('returned_at')
                ->count(),
            'active_members' => Member::where('is_active', true)->count(),
            'total_books' => Book::count(),
            'new_members' => Member::where('created_at', '>=', now()->subWeek())->count(),
        ];

        $overdueLoans = Loan::with(['member', 'copy.book'])
            ->where('due_date', '<', now())
            ->whereNull('returned_at')
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        $recentLoans = Loan::with(['member', 'copy.book'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'overdueLoans', 'recentLoans'));
    }
}