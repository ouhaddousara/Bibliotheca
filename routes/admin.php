<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Auth Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });
    
    // Protected Routes
    Route::middleware('auth:admin')->group(function () {
        // Déconnexion - CORRECTE
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Books CRUD
        Route::resource('books', BookController::class);
        
        // Members CRUD
        Route::resource('members', MemberController::class);
        
        // Loans CRUD
        Route::resource('loans', LoanController::class);
        Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
        Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
        Route::get('/loans/{loan}/return', [LoanController::class, 'returnForm'])->name('loans.return.form');
        Route::post('/loans/{loan}/return', [LoanController::class, 'processReturn'])->name('loans.return');
    });
});