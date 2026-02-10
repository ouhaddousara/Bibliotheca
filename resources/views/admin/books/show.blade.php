@extends('admin.layouts.app')

@section('title', 'Détails du livre - Bibliothèque')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-book-reader mr-3 text-indigo-600"></i>
                    {{ $book->title }}
                </h1>
                <p class="text-gray-600 mt-1">{{ $book->author }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.books.edit', $book) }}" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                    <i class="fas fa-edit mr-2"></i>Éditer
                </a>
                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash-alt mr-2"></i>Supprimer
                    </button>
                </form>
                <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>

        <!-- Informations du livre -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">ISBN</p>
                    <p class="font-semibold text-gray-800">{{ $book->isbn }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Catégorie</p>
                    <p class="font-semibold text-gray-800">
                        <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 text-sm">
                            {{ config('library.categories.' . $book->category, $book->category) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Exemplaires -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Exemplaires ({{ $book->copies->count() }})</h2>
            </div>

            @if($book->copies->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($book->copies as $copy)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $copy->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($copy->status === 'available')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                        🟢 Disponible
                                    </span>
                                @elseif($copy->status === 'borrowed')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                        🟡 Emprunté
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        🔴 {{ ucfirst($copy->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i> Éditer
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p>Aucun exemplaire pour ce livre</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection