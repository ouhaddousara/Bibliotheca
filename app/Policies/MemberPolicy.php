<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class MemberPolicy
{
    /**
     * Determine whether the admin can view any members.
     */
    public function viewAny(Admin $admin): bool
    {
        return true; // Admin voit tous les adhérents
    }

    /**
     * Determine whether the admin can view the member.
     */
    public function view(Admin $admin, Member $member): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can create members.
     */
    public function create(Admin $admin): bool
    {
        return true; // Admin peut ajouter des adhérents
    }

    /**
     * Determine whether the admin can update the member.
     */
    public function update(Admin $admin, Member $member): bool
    {
        return true; // Admin peut modifier des adhérents
    }

    /**
     * Determine whether the admin can delete the member.
     */
    public function delete(Admin $admin, Member $member): bool
    {
        return true; // Admin peut supprimer des adhérents
    }

    /**
     * Determine whether the admin can activate/deactivate the member.
     */
    public function manageStatus(Admin $admin, Member $member): bool
    {
        return true; // Admin peut activer/désactiver des comptes
    }
}