<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil : redirige vers la liste des personnes si connecté, sinon vers login
Route::get('/', function () {
    return Auth::check() 
        ? redirect()->route('people.index') 
        : redirect()->route('login');
});

// Routes d'authentification publiques (accessibles sans être connecté)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Déconnexion (doit être accessible uniquement aux utilisateurs connectés)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Toutes les routes liées à la gestion des personnes sont protégées par 'auth'
Route::middleware('auth')->group(function () {
    Route::resource('people', PersonController::class);
    
    // Tu peux ajouter d'autres routes protégées ici plus tard
    // Exemple : Route::get('/profile', [ProfileController::class, 'show']);
});
