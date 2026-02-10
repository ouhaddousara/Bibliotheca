<x-client-layout>
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Bonjour, {{ auth('client')->user()->firstname }} ! 👋</h1>
        <p class="text-gray-600 mt-2">Voici vos emprunts en cours et à venir</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Mes emprunts -->
        <div>
            <h2 class="text-xl font-bold mb-4 flex items-center">
                <span class="mr-2">📖</span> Mes emprunts
            </h2>
            @forelse($loans as $loan)
                <div class="border rounded-lg p-4 mb-3 bg-white shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold">{{ $loan->copy->book->title }}</h3>
                            <p class="text-gray-600 text-sm">{{ $loan->copy->book->author }}</p>
                            <p class="text-xs text-gray-500 mt-1">Exemplaire : {{ $loan->copy->code }}</p>
                        </div>
                        <x-status-badge :status="$loan->status">
                            {{ config('library.status_emojis.' . $loan->status) }}
                            {{ ucfirst(__($loan->status)) }}
                        </x-status-badge>
                    </div>
                    <div class="mt-3 pt-3 border-t flex justify-between text-sm">
                        <span>Emprunté le : {{ $loan->borrowed_at->format('d/m/Y') }}</span>
                        <span class="font-medium">
                            @if($loan->isOverdue())
                                <span class="text-red-600 font-bold">⚠️ Échéance : {{ $loan->due_date->format('d/m/Y') }}</span>
                            @else
                                ✅ À retourner avant le {{ $loan->due_date->format('d/m/Y') }}
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <p class="text-gray-500">Aucun emprunt en cours ✨</p>
                    <a href="{{ route('client.books.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                        Découvrir les nouveautés 📚
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Livres disponibles -->
        <div>
            <h2 class="text-xl font-bold mb-4 flex items-center">
                <span class="mr-2">🌟</span> Suggestions du moment
            </h2>
            @foreach($availableBooks as $book)
                <x-book-card :book="$book" :availableCopies="$book->availableCopiesCount()" />
            @endforeach
        </div>
    </div>

    <div class="mt-10 text-center text-gray-600 border-t pt-6">
        <p>📚 Besoin d'aide ? Contactez-nous : <a href="mailto:biblio@contact.fr" class="text-blue-600">biblio@contact.fr</a></p>
        <p class="mt-1 text-sm">Merci de votre confiance ! L'équipe de la bibliothèque 🌟</p>
    </div>
</x-client-layout>