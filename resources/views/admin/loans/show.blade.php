@extends('admin.layouts.app')

@section('title', 'Détails de l\'emprunt - Bibliothèque')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-file-alt mr-3 text-indigo-600"></i>
                    Détails de l'emprunt #{{ $loan->id }}
                </h1>
                <p class="text-gray-600 mt-1">Informations complètes sur cet emprunt</p>
            </div>
            <div class="flex space-x-3">
                @if(!$loan->returned_at)
                <a href="{{ route('admin.loans.return.form', $loan) }}" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                    <i class="fas fa-undo mr-2"></i>Retourner
                </a>
                @endif
                <a href="{{ route('admin.loans.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
                </a>
            </div>
        </div>

        <!-- Informations de l'emprunt -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Informations de l'emprunt</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Date d'emprunt</p>
                    <p class="font-semibold text-gray-800">{{ $loan->borrowed_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Date d'échéance</p>
                    <p class="font-semibold text-gray-800">
                        {{ $loan->due_date->format('d/m/Y') }}
                        @if($loan->isOverdue())
                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                ⚠️ {{ $loan->getDaysOverdueAttribute() }} jour(s) de retard
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Date de retour</p>
                    <p class="font-semibold text-gray-800">
                        @if($loan->returned_at)
                            {{ $loan->returned_at->format('d/m/Y à H:i') }}
                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                                ✅ Retourné
                            </span>
                        @else
                            <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded text-xs font-medium">
                                🟡 En cours
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Statut</p>
                    <p class="font-semibold text-gray-800">
                        @if($loan->returned_at)
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm">
                                ✅ Retourné
                            </span>
                        @elseif($loan->isOverdue())
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-sm">
                                ⚠️ En retard
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-sm">
                                🟡 En cours
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Informations de l'adhérent -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Adhérent</h2>
            
            <div class="flex items-center space-x-4 mb-4">
                <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-800 font-bold text-2xl">
                    {{ strtoupper(substr($loan->member->firstname, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $loan->member->firstname }} {{ $loan->member->lastname }}</h3>
                    <p class="text-gray-600">{{ $loan->member->email }}</p>
                    @if($loan->member->phone)
                        <p class="text-gray-600"><i class="fas fa-phone mr-2"></i>{{ $loan->member->phone }}</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Statut du compte</p>
                    <p class="font-semibold text-gray-800">
                        @if($loan->member->is_active)
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-sm">
                                ✅ Actif
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-sm">
                                ⚠️ Inactif
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Emprunts actifs</p>
                    <p class="font-semibold text-gray-800">
                        {{ $loan->member->loans()->whereNull('returned_at')->count() }} emprunt(s)
                    </p>
                </div>
            </div>
        </div>

        <!-- Informations du livre -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Livre emprunté</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Titre</p>
                    <p class="font-semibold text-gray-800">{{ $loan->copy->book->title }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Auteur</p>
                    <p class="font-semibold text-gray-800">{{ $loan->copy->book->author }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">ISBN</p>
                    <p class="font-semibold text-gray-800">{{ $loan->copy->book->isbn }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Catégorie</p>
                    <p class="font-semibold text-gray-800">
                        <span class="px-2 py-1 rounded-full bg-indigo-100 text-indigo-800 text-xs">
                            {{ config('library.categories.' . $loan->copy->book->category, $loan->copy->book->category) }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Exemplaire</p>
                    <p class="font-semibold text-gray-800">{{ $loan->copy->code }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Statut de l'exemplaire</p>
                    <p class="font-semibold text-gray-800">
                        @if($loan->copy->status === 'available')
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-sm">
                                🟢 Disponible
                            </span>
                        @elseif($loan->copy->status === 'borrowed')
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-sm">
                                🟡 Emprunté
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-sm">
                                🔴 {{ ucfirst($loan->copy->status) }}
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection