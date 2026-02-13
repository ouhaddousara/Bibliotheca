<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of available books for clients.
     */
    public function index(Request $request)
    {
        $query = Book::query()
            ->withCount(['copies' => function ($q) {
                $q->where('status', 'available');
            }])
            ->having('copies_count', '>', 0)
            ->orderBy('title', 'asc');

        // Recherche par titre/auteur
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('author', 'like', $searchTerm);
            });
        }

        // Filtre par catégorie
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $books = $query->paginate(12);
        $categories = config('library.categories', []);

        return view('client.books.index', compact('books', 'categories'));
    }
}