<?php

use Illuminate\Support\Facades\Route;

// Rediriger la route racine vers l'admin ou le client
Route::get('/', function () {
    return redirect()->route('admin.login');
    // OU
    // return redirect()->route('client.login');
});

// Charger les routes personnalisées
require __DIR__.'/admin.php';
require __DIR__.'/client.php';