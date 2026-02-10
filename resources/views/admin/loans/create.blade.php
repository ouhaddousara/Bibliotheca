@extends('admin.layouts.app')

@section('title', 'Nouvel emprunt - Bibliothèque')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-plus-circle mr-3 text-indigo-600"></i>
                Nouvel emprunt
            </h1>
            <p class="text-gray-600 mt-2">Enregistrer un nouvel emprunt pour un adhérent</p>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('admin.loans.store') }}">
                @csrf

                <!-- Adhérent -->
                <div class="mb-6">
                    <label for="member_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user mr-2"></i>Adhérent
                    </label>
                    <select 
                        id="member_id" 
                        name="member_id" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('member_id') border-red-500 @enderror"
                    >
                        <option value="">-- Sélectionnez un adhérent --</option>
                        @foreach($activeMembers as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->firstname }} {{ $member->lastname }} ({{ $member->email }})
                                @if($member->active_loans_count > 0)
                                    - {{ $member->active_loans_count }} emprunt(s) en cours
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Exemplaire -->
                <div class="mb-6">
                    <label for="copy_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-book mr-2"></i>Exemplaire à emprunter
                    </label>
                    <select 
                        id="copy_id" 
                        name="copy_id" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('copy_id') border-red-500 @enderror"
                    >
                        <option value="">-- Sélectionnez un exemplaire disponible --</option>
                        @foreach($availableCopies as $copy)
                            <option value="{{ $copy->id }}" {{ old('copy_id') == $copy->id ? 'selected' : '' }}>
                                {{ $copy->book->title }} - {{ $copy->book->author }} 
                                (Code: {{ $copy->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('copy_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date d'emprunt -->
                <div class="mb-6">
                    <label for="borrowed_at" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-calendar-check mr-2"></i>Date d'emprunt
                    </label>
                    <input 
                        type="datetime-local" 
                        id="borrowed_at" 
                        name="borrowed_at" 
                        value="{{ old('borrowed_at', now()->format('Y-m-d\TH:i')) }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('borrowed_at') border-red-500 @enderror"
                    >
                    @error('borrowed_at')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Par défaut : maintenant. Durée standard : {{ config('library.loan_period_days', 14) }} jours
                    </p>
                </div>

                <!-- Date d'échéance (calculée automatiquement) -->
                <div class="mb-6 bg-blue-50 p-4 rounded-lg">
                    <p class="text-blue-800 font-semibold">
                        <i class="fas fa-clock mr-2"></i>Date de retour prévue : 
                        <span id="due_date_display" class="ml-2">{{ now()->addDays(config('library.loan_period_days', 14))->format('d/m/Y à H:i') }}</span>
                    </p>
                    <p class="text-blue-600 text-sm mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Cette date sera calculée automatiquement après la soumission
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.loans.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer l'emprunt
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Mise à jour dynamique de la date d'échéance
document.getElementById('borrowed_at').addEventListener('change', function() {
    const borrowedAt = new Date(this.value);
    const loanPeriodDays = {{ config('library.loan_period_days', 14) }};
    const dueDate = new Date(borrowedAt);
    dueDate.setDate(dueDate.getDate() + loanPeriodDays);
    
    const options = { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('due_date_display').textContent = dueDate.toLocaleString('fr-FR', options);
});
</script>
@endpush
@endsection