<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    /**
     * Le statut à afficher
     */
    public string $status;

    /**
     * Create a new component instance.
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $colors = [
            'available' => 'bg-emerald-100 text-emerald-800',
            'borrowed' => 'bg-amber-100 text-amber-800',
            'overdue' => 'bg-red-100 text-red-800 font-bold animate-pulse',
            'returned' => 'bg-green-100 text-green-800',
            'pending' => 'bg-blue-100 text-blue-800'
        ];
        
        return view('components.status-badge', [
            'colorClass' => $colors[$this->status] ?? 'bg-gray-100 text-gray-800'
        ]);
    }
}