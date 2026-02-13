@extends('client.layouts.app')

@section('title', 'Livres disponibles')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800"> Livres disponibles</h1>
        <p class="text-gray-600 mt-2">Découvrez les livres que vous pouvez emprunter dès maintenant</p>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('client.books.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Rechercher un titre ou auteur..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <i class="fas fa-search absolute right-3 top-3.5 text-gray-400"></i>
            </div>
            
            <select name="category" onchange="this.form.submit()" 
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">Toutes les catégories</option>
                @foreach(config('library.categories', []) as $key => $label)
                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-lg transition flex items-center justify-center">
                <i class="fas fa-search mr-2"></i>Rechercher
            </button>
        </form>
    </div>

    <!-- Books Grid -->
    @if($books->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($books as $book)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition">
                    <div class="p-6">
                        <div class="text-5xl mb-4 text-emerald-600 text-center">
                            <i class="fas fa-book"></i>
                        </div>
                        
                        <h3 class="font-bold text-lg text-gray-800 mb-1 line-clamp-2">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{ $book->author }}</p>
                        
                        @if($book->publisher || $book->year)
                            <p class="text-xs text-gray-500 mb-4">
                                @if($book->publisher){{ $book->publisher }}@endif
                                @if($book->year) • {{ $book->year }}@endif
                            </p>
                        @endif
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-medium">
                                {{ config('library.categories.' . $book->category, $book->category) }}
                            </span>
                            <span class="text-sm font-bold text-emerald-600">
                                {{ $book->copies_count }} dispo
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $books->appends(request()->query())->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun livre disponible</h3>
            <p class="text-gray-600">Malheureusement, aucun livre ne correspond à votre recherche ou n'est actuellement disponible à l'emprunt.</p>
            @if(request()->anyFilled(['search', 'category']))
                <a href="{{ route('client.books.index') }}" class="mt-4 inline-flex items-center text-emerald-600 hover:text-emerald-800 font-medium">
                    <i class="fas fa-times mr-2"></i>Réinitialiser les filtres
                </a>
            @endif
        </div>
    @endif
</div>
@endsection