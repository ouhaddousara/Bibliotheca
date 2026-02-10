@extends('admin.layouts.app')

@section('title', 'Ajouter un livre - Bibliothèque')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-book mr-3 text-indigo-600"></i>
                Ajouter un nouveau livre
            </h1>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('admin.books.store') }}">
                @csrf

                <!-- ISBN -->
                <div class="mb-6">
                    <label for="isbn" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-barcode mr-2"></i>ISBN (13 chiffres)
                    </label>
                    <input 
                        type="text" 
                        id="isbn" 
                        name="isbn" 
                        value="{{ old('isbn') }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('isbn') border-red-500 @enderror"
                        placeholder="978-2-266-31927-1"
                    >
                    @error('isbn')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Titre -->
                <div class="mb-6">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-heading mr-2"></i>Titre
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                        placeholder="Le Petit Prince"
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Auteur -->
                <div class="mb-6">
                    <label for="author" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user-edit mr-2"></i>Auteur
                    </label>
                    <input 
                        type="text" 
                        id="author" 
                        name="author" 
                        value="{{ old('author') }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('author') border-red-500 @enderror"
                        placeholder="Antoine de Saint-Exupéry"
                    >
                    @error('author')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div class="mb-6">
                    <label for="category" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tags mr-2"></i>Catégorie
                    </label>
                    <select 
                        id="category" 
                        name="category" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('category') border-red-500 @enderror"
                    >
                        <option value="">-- Sélectionnez une catégorie --</option>
                        @foreach(config('library.categories', []) as $key => $label)
                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nombre d'exemplaires initiaux -->
                <div class="mb-6">
                    <label for="initial_copies" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-copy mr-2"></i>Nombre d'exemplaires à créer
                    </label>
                    <input 
                        type="number" 
                        id="initial_copies" 
                        name="initial_copies" 
                        value="{{ old('initial_copies', 1) }}" 
                        min="0" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.books.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer le livre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection