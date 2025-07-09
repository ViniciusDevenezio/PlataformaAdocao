<?php

use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\TutorController;
use App\Http\Controllers\AdotanteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdotanteAuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AnimalController; // ← adicionado se ainda não tiver
>>>>>>> Stashed changes

// Página inicial
Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/cadastro', function () {
    return view('cadastro');
});

Route::get('/painel', function () {
    return view('painel');
});

<<<<<<< Updated upstream
=======
Route::get('/cadastroAnimal', function () {
    return view('cadastroAnimal');
});

// Cadastro de tutor
Route::post('/tutor/store', [TutorController::class, 'store'])->name('tutor.store');

// CRUD de adotantes
Route::resource('adotantes', AdotanteController::class);

// CRUD de pets
Route::resource('pets', PetController::class);

// Evita conflito com a rota de resource acima
Route::get('/pets', [PetController::class, 'index'])->name('index');

// CRUD de animais (se estiver usando esse controller também)
Route::resource('/pets', AnimalController::class);

>>>>>>> Stashed changes
