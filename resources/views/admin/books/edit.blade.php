@extends('admin.layouts.app')

@section('title', 'Éditer un livre - Bibliothèque')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-edit mr-3 text-amber-600"></i>
                Éditer le livre : {{ $book->title }}
            </h1>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('admin.books.update', $book) }}">
                @csrf
                @method('PUT')

                <!-- ISBN -->
                <div class="mb-6">
                    <label for="isbn" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-barcode mr-2"></i>ISBN (13 chiffres)
                    </label>
                    <input 
                        type="text" 
                        id="isbn" 
                        name="isbn" 
                        value="{{ old('isbn', $book->isbn) }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('isbn') border-red-500 @enderror