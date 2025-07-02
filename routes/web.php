<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\AdotanteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdotanteAuthController;
use App\Http\Controllers\PetController;


Route::get('/', function () {
    return view('home');
})->name('home');

// Página de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Envio do login - Apenas um controller (AdotanteAuthController, se for o principal)
Route::post('/login', [AdotanteAuthController::class, 'login'])->name('adotante.login');

// Logout
Route::post('/logout', [AdotanteAuthController::class, 'logout'])->name('logout');

// Cadastro
Route::get('/cadastro', function () {
    return view('cadastro');
})->name('cadastro');

// Dashboard protegida
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

// Outras páginas
Route::get('/painel', function () {
    return view('painel');
});

Route::get('/cadastroAnimal', function () {
    return view('cadastroAnimal');
});

Route::post('/tutor/store', [TutorController::class, 'store'])->name('tutor.store');

// CRUD de adotantes
Route::resource('adotantes', AdotanteController::class);

Route::get('/adotar', [PetController::class, 'adotar'])->name('adotar');


Route::get('/pets', [PetController::class, 'index']);


