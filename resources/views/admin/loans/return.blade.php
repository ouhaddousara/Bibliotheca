@extends('admin.layouts.app')

@section('title', 'Retourner un emprunt - Bibliothèque')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-undo mr-3 text-amber-600"></i>
                Retourner l'emprunt #{{ $loan->id }}
            </h1>
            <p class="text-gray-600 mt-2">Traiter le retour de cet exemplaire</p>
        </div>

        <!-- Informations de l'emprunt -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-6 rounded-r-lg">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-3xl text-blue-600 mt-1 mr-4"></i>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Emprunt en cours</h3>
                    <p class="mt-2 text-gray-700">
                        <strong>{{ $loan->copy->book->title }}</strong> par {{ $loan->copy->book->author }}<br>
                        Emprunté par <strong>{{ $loan->member->firstname }} {{ $loan->member->lastname }}</strong><br>
                        Date d'emprunt : <strong>{{ $loan->borrowed_at->format('d/m/Y') }}</strong><br>
                        Date d'échéance : <strong>{{ $loan->due_date->format('d/m/Y') }}</strong>
                        @if($loan->isOverdue())
                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                ⚠️ {{ $loan->getDaysOverdueAttribute() }} jour(s) de retard
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulaire de retour -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('admin.loans.return', $loan) }}">
                @csrf
                @method('POST')

                <!-- État de retour -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-3">
                        <i class="fas fa-star mr-2"></i>État de l'exemplaire au retour
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition {{ old('return_condition', 'good') === 'good' ? 'border-indigo-500 bg-indigo-50' : '' }}">
                            <input 
                                type="radio" 
                                name="return_condition" 
                                value="good" 
                                {{ old('return_condition', 'good') === 'good' ? 'checked' : '' }}
                                class="form-radio h-5 w-5 text-indigo-600"
                            >
                            <div class="ml-3">
                                <p class="font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Bon état
                                </p>
                                <p class="text-sm text-gray-600 mt-1">Aucun dommage</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-amber-500 transition {{ old('return_condition') === 'damaged' ? 'border-amber-500 bg-amber-50' : '' }}">
                            <input 
                                type="radio" 
                                name="return_condition" 
                                value="damaged" 
                                {{ old('return_condition') === 'damaged' ? 'checked' : '' }}
                                class="form-radio h-5 w-5 text-amber-600"
                            >
                            <div class="ml-3">
                                <p class="font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-exclamation-triangle text-amber-500 mr-2"></i>
                                    Endommagé
                                </p>
                                <p class="text-sm text-gray-600 mt-1">Petits dommages</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-500 transition {{ old('return_condition') === 'lost' ? 'border-red-500 bg-red-50' : '' }}">
                            <input 
                                type="radio" 
                                name="return_condition" 
                                value="lost" 
                                {{ old('return_condition') === 'lost' ? 'checked' : '' }}
                                class="form-radio h-5 w-5 text-red-600"
                            >
                            <div class="ml-3">
                                <p class="font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                    Perdu
                                </p>
                                <p class="text-sm text-gray-600 mt-1">Exemplaire non retourné</p>
                            </div>
                        </label>
                    </div>
                    @error('return_condition')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label for="notes" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-sticky-note mr-2"></i>Notes (optionnel)
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror"
                        placeholder="Ajoutez des notes sur l'état de l'exemplaire ou des commentaires...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Ces notes seront enregistrées dans l'historique de l'emprunt
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.loans.show', $loan) }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                    <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                        <i class="fas fa-check mr-2"></i>Confirmer le retour
                    </button>
                </div>
            </form>
        </div>

        <!-- Avertissement -->
        <div class="mt-6 bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-amber-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">
                        <strong>Attention :</strong> Cette action est irréversible. Une fois l'emprunt retourné, 
                        l'exemplaire sera remis à disposition (sauf s'il est marqué comme endommagé ou perdu).
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection