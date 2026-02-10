<?php

use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\BookController;
use App\Http\Controllers\Client\LoanController;
use App\Http\Controllers\Client\Auth\ClientLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Routes pour l'espace adhérent de la bibliothèque
|
*/

Route::prefix('client')->name('client.')->group(function () {
    
    // Routes d'authentification (adhérents non connectés)
    Route::middleware('guest:client')->group(function () {
        Route::get('/login', [ClientLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [ClientLoginController::class, 'login']);
    });
    
    // Routes protégées (adhérent connecté)
    Route::middleware('auth:client')->group(function () {
        Route::post('/logout', [ClientLoginController::class, 'logout'])->name('logout');
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Books - Consultation uniquement
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
        Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
        
        // Loans - Emprunts personnels
        Route::get('/loans', [LoanController::class, 'myLoans'])->name('loans.index');
        Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
        Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
        Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
    });
});