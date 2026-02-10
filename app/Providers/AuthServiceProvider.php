<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;
use App\Models\Copy;
use App\Policies\BookPolicy;
use App\Policies\MemberPolicy;
use App\Policies\LoanPolicy;
use App\Policies\CopyPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Book::class => BookPolicy::class,
        Member::class => MemberPolicy::class,
        Loan::class => LoanPolicy::class,
        Copy::class => CopyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Enregistrement automatique des policies
        $this->registerPolicies();

        // Gates personnalisées si nécessaire
        Gate::before(function ($user, $ability) {
            // Logique globale d'autorisation si nécessaire
        });
    }
}