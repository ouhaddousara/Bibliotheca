<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\Admin;
use App\Models\Member;
use Illuminate\Auth\Access\Response;

class LoanPolicy
{
    /**
     * Determine whether the admin can view any loans.
     */
    public function viewAny(Admin $admin): bool
    {
        return true; // Admin voit tous les emprunts
    }

    /**
     * Determine whether the member can view any loans.
     */
    public function viewAnyMember(Member $member): bool
    {
        return true; // Le membre peut voir la liste de SES emprunts
    }

    /**
     * Determine whether the admin can view the loan.
     */
    public function view(Admin $admin, Loan $loan): bool
    {
        return true; // Admin peut voir n'importe quel emprunt
    }

    /**
     * Determine whether the member can view the loan.
     */
    public function viewMember(Member $member, Loan $loan): bool
    {
        return $loan->member_id === $member->id; // Client voit SEULEMENT ses emprunts
    }

    /**
     * Determine whether the admin can create loans.
     */
    public function create(Admin $admin): bool
    {
        return true; // Admin peut créer des emprunts
    }

    /**
     * Determine whether the member can create loans.
     */
    public function createMember(Member $member): bool
    {
        return true; // Adhérent peut emprunter des livres
    }

    /**
     * Determine whether the admin can update the loan.
     */
    public function update(Admin $admin, Loan $loan): bool
    {
        return true; // Admin peut modifier n'importe quel emprunt
    }

    /**
     * Determine whether the admin can delete the loan.
     */
    public function delete(Admin $admin, Loan $loan): bool
    {
        return true; // Admin peut supprimer des emprunts
    }

    /**
     * Determine whether the admin can return a loan.
     */
    public function returnLoan(Admin $admin, Loan $loan): bool
    {
        return true; // Admin peut traiter le retour de n'importe quel emprunt
    }

    /**
     * Determine whether the member can return their own loan.
     */
    public function returnLoanMember(Member $member, Loan $loan): bool
    {
        return $loan->member_id === $member->id; // Adhérent peut retourner SES emprunts
    }
}