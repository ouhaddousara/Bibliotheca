@extends('client.layouts.app')

@section('title', 'Mes emprunts')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800"> Mes emprunts</h1>
        <p class="text-gray-600 mt-2">Consultez l'historique de vos emprunts et leur statut actuel</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500">
            <p class="text-gray-500 text-sm font-medium mb-2">Emprunts en cours</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['active'] }}</p>
            <p class="text-sm text-gray-600 mt-2">
                <i class="fas fa-book-reader mr-1"></i>En cours de lecture
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <p class="text-gray-500 text-sm font-medium mb-2">Emprunts retournés</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['returned'] }}</p>
            <p class="text-sm text-gray-600 mt-2">
                <i class="fas fa-check-circle mr-1"></i>Livres retournés
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <p class="text-gray-500 text-sm font-medium mb-2">Emprunts en retard</p>
            <p class="text-3xl font-bold text-red-600">{{ $stats['overdue'] }}</p>
            <p class="text-sm text-gray-600 mt-2">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                @if($stats['overdue'] > 0)
                    Merci de rapporter !
                @else
                    Tout est à jour
                @endif
            </p>
        </div>
    </div>

    <!-- Overdue Warning -->
    @if($stats['overdue'] > 0)
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-xl">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600 mt-1 mr-4"></i>
                <div>
                    <h3 class="font-bold text-xl text-gray-800 flex items-center">
                        <span class="mr-2">⚠️</span> 
                        Vous avez {{ $stats['overdue'] }} emprunt(s) en retard !
                    </h3>
                    <p class="mt-2 text-gray-700">
                        Merci de rapporter ces livres dès que possible pour éviter des frais de retard.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Loans Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'emprunt</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Échéance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Retour</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($loans as $loan)
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
                            @if($loan->due_date->isPast() && !$loan->returned_at)
                                <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded text-xs">
                                    ⚠️ {{ now()->diffInDays($loan->due_date, false) }}j de retard
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($loan->returned_at)
                                {{ $loan->returned_at->format('d/m/Y') }}
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
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
                        <td colspan="5" class="px-6 py-12 text-center">
                            <i class="fas fa-book-reader text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun emprunt pour le moment</h3>
                            <p class="text-gray-600">Vous n'avez pas encore effectué d'emprunts. Commencez à explorer notre collection de livres !</p>
                            <a href="{{ route('client.books.index') }}" class="mt-4 inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                                <i class="fas fa-book mr-2"></i>Découvrir les livres
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($loans->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $loans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection