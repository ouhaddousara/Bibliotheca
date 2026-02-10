<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookRequest;
use App\Http\Requests\Admin\UpdateBookRequest;
use App\Models\Book;
use App\Models\Copy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::withCount(['copies' => function ($query) {
            $query->where('status', 'available');
        }])
        ->withCount('copies as total_copies')
        ->latest()
        ->paginate(15);

        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = config('library.categories', []);
        return view('admin.books.create', compact('categories'));
    }

    public function store(StoreBookRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $book = Book::create($request->validated());

                if ($request->has('initial_copies') && $request->initial_copies > 0) {
                    for ($i = 1; $i <= $request->initial_copies; $i++) {
                        $code = 'BIB-' . date('Y') . '-' . str_pad($book->id . $i, 4, '0', STR_PAD_LEFT);
                        Copy::create([
                            'book_id' => $book->id,
                            'code' => $code,
                            'status' => 'available',
                        ]);
                    }
                }

                Log::channel('library')->info('Livre créé', [
                    'book_id' => $book->id,
                    'title' => $book->title,
                    'admin_id' => auth('admin')->id(),
                ]);
            });

            return redirect()->route('admin.books.index')
                ->with('success', 'Livre ajouté avec succès ! 📚');

        } catch (\Exception $e) {
            Log::channel('library')->error('Erreur création livre', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du livre.');
        }
    }

    public function show(Book $book)
    {
        $book->load(['copies' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = config('library.categories', []);
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            $book->update($request->validated());

            Log::channel('library')->info('Livre mis à jour', [
                'book_id' => $book->id,
                'admin_id' => auth('admin')->id(),
            ]);

            return redirect()->route('admin.books.index')
                ->with('success', 'Livre mis à jour avec succès ! ✏️');

        } catch (\Exception $e) {
            Log::channel('library')->error('Erreur mise à jour livre', [
                'book_id' => $book->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

    public function destroy(Book $book)
    {
        try {
            $borrowedCopies = $book->copies()->where('status', 'borrowed')->count();
            
            if ($borrowedCopies > 0) {
                return back()
                    ->with('error', 'Impossible de supprimer ce livre : ' . $borrowedCopies . ' exemplaire(s) sont actuellement empruntés.');
            }

            $book->delete();

            Log::channel('library')->info('Livre supprimé', [
                'book_id' => $book->id,
                'admin_id' => auth('admin')->id(),
            ]);

            return redirect()->route('admin.books.index')
                ->with('success', 'Livre supprimé avec succès ! 🗑️');

        } catch (\Exception $e) {
            Log::channel('library')->error('Erreur suppression livre', [
                'book_id' => $book->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
}