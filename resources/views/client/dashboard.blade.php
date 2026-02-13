@extends('client.layouts.app')

@section('title', 'Mon tableau de bord')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl p-8 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">👋 Bonjour, {{ auth('client')->user()->firstname }} !</h1>
                <p class="text-emerald-100 text-lg">Bienvenue dans votre espace personnel de la bibliothèque</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-4">
                <div class="text-center">
                    <div class="text-4xl font-bold">{{ $stats['active_loans'] }}</div>
                    <div class="text-emerald-100 text-sm">Emprunts en cours</div>
                </div>
                <div class="w-px h-12 bg-emerald-400"></div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-200">{{ $stats['overdue_loans'] }}</div>
                    <div class="text-emerald-100 text-sm">En retard</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Emprunts en cours -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Emprunts en cours</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['active_loans'] }}</p>
                    <p class="text-emerald-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-book-reader mr-1 text-xs"></i>
                        {{ $stats['available_books'] }} livres disponibles
                    </p>
                </div>
                <div class="bg-emerald-100 text-emerald-600 w-14 h-14 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-book-open text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Emprunts retournés -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Emprunts retournés</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['returned_loans'] }}</p>
                    <p class="text-amber-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-history mr-1 text-xs"></i>
                        Historique complet
                    </p>
                </div>
                <div class="bg-green-100 text-green-600 w-14 h-14 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Emprunts en retard -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 {{ $stats['overdue_loans'] > 0 ? 'border-red-500' : 'border-gray-300' }} hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Emprunts en retard</p>
                    <p class="text-3xl font-bold {{ $stats['overdue_loans'] > 0 ? 'text-red-600' : 'text-gray-800' }}">{{ $stats['overdue_loans'] }}</p>
                    @if($stats['overdue_loans'] > 0)
                        <p class="text-red-600 text-sm mt-1 flex items-center font-semibold">
                            <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                            Merci de rapporter !
                        </p>
                    @else
                        <p class="text-green-600 text-sm mt-1 flex items-center">
                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                            Tout est à jour
                        </p>
                    @endif
                </div>
                <div class="bg-red-100 text-red-600 w-14 h-14 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Overdue Loans Alert -->
    @if($overdueLoans->count() > 0)
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-xl">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600 mt-1 mr-4"></i>
                <div>
                    <h3 class="font-bold text-xl text-gray-800 flex items-center">
                        <span class="mr-2">⚠️</span> 
                        Vous avez {{ $overdueLoans->count() }} emprunt(s) en retard !
                    </h3>
                    <p class="mt-2 text-gray-700">
                        Merci de rapporter ces livres dès que possible pour éviter des frais de retard.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('client.loans.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-list mr-2"></i>Voir mes emprunts en retard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Available Books Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 bg-emerald-50">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-book mr-2 text-emerald-600"></i>
                Livres disponibles ({{ $stats['available_books'] }})
            </h2>
            <p class="text-gray-600 mt-1">Découvrez nos nouveautés et classiques</p>
        </div>
        
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($availableBooks as $book)
                <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition cursor-pointer" 
                     onclick="window.location.href='{{ route('client.books.index') }}'">
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="text-4xl mb-3 text-emerald-600 text-center">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1 line-clamp-2">{{ Str::limit($book->title, 30) }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $book->author }}</p>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded text-xs font-medium">
                                {{ config('library.categories.' . $book->category, $book->category) }}
                            </span>
                            <span class="text-sm font-semibold text-emerald-600">
                                {{ $book->copies_count }} dispo
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- AMÉLIORATION UX : Lien avec icônes -->
        <div class="p-6 border-t border-gray-200">
            <div class="mt-4 text-center">
                <a href="{{ route('client.books.index') }}" class="inline-flex items-center justify-center text-emerald-600 hover:text-emerald-800 font-medium text-lg">
                    <i class="fas fa-book-open mr-2"></i>Voir tous les livres
                    <i class="fas fa-arrow-right ml-2 text-base"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Loans Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 bg-indigo-50">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-history mr-2 text-indigo-600"></i>
                Mes emprunts récents ({{ $recentLoans->count() }})
            </h2>
            <p class="text-gray-600 mt-1">Vos lectures en cours et passées</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'emprunt</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Échéance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentLoans as $loan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $loan->copy->book->title }}</div>
                                <div class="text-sm text-gray-500">{{ $loan->copy->book->author }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $loan->borrowed_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $loan->due_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($loan->returned_at)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>Retourné
                                    </span>
                                @elseif($loan->due_date->isPast())
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-clock mr-1"></i>En retard
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                        <i class="fas fa-book-reader mr-1"></i>En cours
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <i class="fas fa-book-reader text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun emprunt pour le moment</h3>
                                <p class="text-gray-600">Commencez à explorer notre collection de livres !</p>
                                <a href="{{ route('client.books.index') }}" class="mt-4 inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                                    <i class="fas fa-book mr-2"></i>Découvrir les livres
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- AMÉLIORATION UX : Lien avec icônes -->
        <div class="p-6 border-t border-gray-200">
            <div class="mt-4 text-center">
                <a href="{{ route('client.loans.index') }}" class="inline-flex items-center justify-center text-emerald-600 hover:text-emerald-800 font-medium text-lg">
                    <i class="fas fa-history mr-2"></i>Voir tous mes emprunts
                    <i class="fas fa-arrow-right ml-2 text-base"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection