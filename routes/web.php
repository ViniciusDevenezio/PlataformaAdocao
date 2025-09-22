<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\AdotanteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdotanteAuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\OngPainelController;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\MatchController;



Route::get('/', function () {
    return view('home');
})->name('home');


// Envio do login - Apenas um controller (AdotanteAuthController, se for o principal)
Route::post('/login', [AdotanteAuthController::class, 'login'])->name('adotante.login');

// Controle de login se estiver logado
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('bloquear_se_logado');

// Logout
Route::post('/logout', [AdotanteAuthController::class, 'logout'])->name('logout');

// Cadastro
Route::get('/cadastro', function () {
    return view('cadastro');
})->name('cadastro');

// Dashboard protegida
Route::get('/dashboard', function () {
    return view('painelAdotante');
})->name('dashboard')->middleware('auth');

// Outras páginas
Route::get('/painel', function () {
    return view('painel');
});
// routes/web.php




Route::get('/cadastroAnimal', function () {
    return view('cadastroAnimal');
});

Route::get('/painelAdotante', [AdotanteAuthController::class, 'painelAdotante'])
    ->name('adotante.pets')
    ->middleware('auth:adotante');

Route::post('/tutor/store', [TutorController::class, 'store'])->name('tutor.store');

// CRUD de adotantes
Route::resource('adotantes', AdotanteController::class);

Route::get('/adotar', [PetController::class, 'adotar'])->name('adotar');


Route::get('/pets', [PetController::class, 'index']);

Route::post('/pets/{id}/reservar', [PetController::class, 'reservar'])->name('pets.reservar')->middleware('auth:adotante');
// mostrar info completa do pet

Route::get('/pet/{pet}', [PetController::class, 'mostrar'])->name('pet.mostrar');


//Painel da ong ----------------------------------------------------------------------
Route::middleware(['auth:ong'])->group(function () {
    Route::view('/painel-ong', 'painelOng')->name('painel.ong');

    Route::get('/painel-ong/pets', [OngPainelController::class, 'listarPets'])->name('ong.pets');
    Route::get('/painel-ong/pets/novo', [OngPainelController::class, 'cadastrarPet'])->name('ong.pets.novo');
    Route::post('/painel-ong/pets', [OngPainelController::class, 'salvarPet'])->name('ong.pets.salvar');
    Route::put('/painel/ong/pets/{id}/status', [OngPainelController::class, 'atualizarStatusPet'])->name('ong.pets.atualizar.status');
    Route::get('/painel-ong/pets/{id}/editar', [OngPainelController::class, 'editarPet'])->name('ong.pets.editar');
    Route::put('/painel-ong/pets/{id}', [OngPainelController::class, 'atualizarPet'])->name('ong.pets.atualizar');
    Route::delete('/painel-ong/pets/{id}', [OngPainelController::class, 'excluirPet'])->name('ong.pets.excluir');

    Route::get('/painel-ong/interesses', [OngPainelController::class, 'interesses'])->name('ong.interesses');
});
Route::post('/cadastro', [TutorController::class, 'store'])->name('tutor.store');



//rota para mostrar apenas os cachorros ou gatos ---------------------------
Route::get('/adotar/cachorros', [App\Http\Controllers\PetController::class, 'listarCachorros'])
    ->name('pets.cachorros');

Route::get('/adotar/gatos', [App\Http\Controllers\PetController::class, 'listarGatos'])
    ->name('pets.gatos');

//solicitaçao -------------------------

Route::post(
    '/solicitacoes',
    [SolicitacaoController::class, 'store']
)->name('solicitacoes.store');

// 👉 rotas do painel da ONG
Route::middleware('auth:ong')
    ->prefix('painel/ong')
    ->name('ong.')
    ->group(function () {
        Route::get('/solicitacoes', [SolicitacaoController::class, 'index'])
            ->name('solicitacoes');

        Route::patch('/solicitacoes/{solicitacao}/status', [SolicitacaoController::class, 'updateStatus'])
            ->name('solicitacoes.status');
    });

Route::middleware('auth:adotante')->group(function () {
    Route::match(['get','post'], '/match', [\App\Http\Controllers\MatchController::class, 'index'])
        ->name('match');
});

Route::get('/resultado-match', function () {
    return view('resultado_match');
})->name('resultado_match');
