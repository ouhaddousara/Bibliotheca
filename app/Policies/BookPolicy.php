<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\Admin;
use App\Models\Member;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    /**
     * Determine whether the admin can view any books.
     */
    public function viewAny(Admin $admin): bool
    {
        return true; // Admin voit tous les livres
    }

    /**
     * Determine whether the member can view any books.
     */
    public function viewAnyMember(Member $member): bool
    {
        return true; // Adhérent peut voir tous les livres disponibles
    }

    /**
     * Determine whether the admin can view the book.
     */
    public function view(Admin $admin, Book $book): bool
    {
        return true;
    }

    /**
     * Determine whether the member can view the book.
     */
    public function viewMember(Member $member, Book $book): bool
    {
        return true; // Adhérent peut voir les détails de n'importe quel livre
    }

    /**
     * Determine whether the admin can create books.
     */
    public function create(Admin $admin): bool
    {
        return true; // Admin peut ajouter des livres
    }

    /**
     * Determine whether the admin can update the book.
     */
    public function update(Admin $admin, Book $book): bool
    {
        return true; // Admin peut modifier des livres
    }

    /**
     * Determine whether the admin can delete the book.
     */
    public function delete(Admin $admin, Book $book): bool
    {
        return true; // Admin peut supprimer des livres
    }
}