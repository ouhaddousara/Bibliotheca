<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\Auth\ClientLoginController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\BookController;
use App\Http\Controllers\Client\LoanController;
use App\Http\Controllers\Client\ProfileController;


/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/

Route::prefix('client')->name('client.')->group(function () {
    
    // Routes publiques (sans authentification)
    Route::middleware('guest:client')->group(function () {
        Route::get('/login', [ClientLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [ClientLoginController::class, 'login']);

    Route::get('/register', [ClientLoginController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [ClientLoginController::class, 'register']);

    });
    
    // Routes protégées (nécessitent authentification)
    Route::middleware('auth:client')->group(function () {
        Route::post('/logout', [ClientLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/books', [BookController::class, 'index'])->name('books.index');

        Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');

        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });  
});