<?php

namespace App\Policies;

use App\Models\Copy;
use App\Models\Admin;
use App\Models\Member;
use Illuminate\Auth\Access\Response;

class CopyPolicy
{
    /**
     * Determine whether the admin can view any copies.
     */
    public function viewAny(Admin $admin): bool
    {
        return true; // Admin voit tous les exemplaires
    }

    /**
     * Determine whether the admin can view the copy.
     */
    public function view(Admin $admin, Copy $copy): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can create copies.
     */
    public function create(Admin $admin): bool
    {
        return true; // Admin peut ajouter des exemplaires
    }

    /**
     * Determine whether the admin can update the copy.
     */
    public function update(Admin $admin, Copy $copy): bool
    {
        return true; // Admin peut modifier des exemplaires
    }

    /**
     * Determine whether the admin can delete the copy.
     */
    public function delete(Admin $admin, Copy $copy): bool
    {
        return true; // Admin peut supprimer des exemplaires
    }

    /**
     * Determine whether the copy can be borrowed.
     */
    public function borrow(Admin $admin, Copy $copy): bool
    {
        return $copy->status === 'available'; // Exemplaire disponible pour emprunt
    }

    public function borrowMember(Member $member, Copy $copy): bool
    {
        return $copy->status === 'available'; // Exemplaire disponible pour emprunt
    }
}