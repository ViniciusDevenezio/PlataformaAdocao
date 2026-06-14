<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\AdotanteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdotanteAuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\OngPainelController;
use App\Http\Controllers\OngController;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\MatchController;
use App\Models\Ong;
use App\Models\Pet;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

// Home ---------------------------------------------------------
Route::get('/', function () {
    $stats = Cache::remember('home.stats', now()->addMinutes(30), function () {
        return [
            'petsAdotados' => Pet::where('status', 'adotado')->count(),
            'ongsParceiras' => Ong::count(),
            'cidadesAtendidas' => Ong::whereNotNull('cidade')->distinct('cidade')->count('cidade'),
        ];
    });

    return view('home', $stats);
})->name('home');

// Login / Logout ------------------------------------------------
Route::post('/login', [AdotanteAuthController::class, 'login'])
    ->name('adotante.login')
    ->middleware('throttle:6,1');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('bloquear_se_logado');

Route::post('/logout', [AdotanteAuthController::class, 'logout'])->name('logout');

// Cadastro adotante ---------------------------------------------
Route::get('/cadastro', function () {
    return view('cadastro');
})->name('cadastro');

// rota de POST principal do cadastro (name único tutor.store)
Route::post('/cadastro', [TutorController::class, 'store'])
    ->name('tutor.store')
    ->middleware('throttle:5,1');

// rota alternativa, sem name (não conflita com tutor.store)
Route::post('/tutor/store', [TutorController::class, 'store'])
    ->middleware('throttle:5,1');

// Cadastro de ONG ------------------------------------------------
Route::get('/cadastro-ong-AssddkOWDOK099dplds', [OngController::class, 'create'])->name('ong.cadastro');
Route::post('/cadastro-ong-AssddkOWDOK099dplds', [OngController::class, 'store'])
    ->name('ong.store')
    ->middleware('throttle:3,1');

// Dashboard protegida -------------------------------------------
Route::get('/dashboard', function () {
    return view('painelAdotante');
})->name('dashboard')->middleware('auth');

// Outras páginas simples ----------------------------------------
Route::get('/painel', function () {
    return view('painel');
});

Route::get('/cadastroAnimal', function () {
    return view('cadastroAnimal');
});

// Painel Adotante -----------------------------------------------
Route::get('/painelAdotante', [AdotanteAuthController::class, 'painelAdotante'])
    ->name('adotante.pets')
    ->middleware('auth:adotante');

// CRUD de adotantes ---------------------------------------------
Route::resource('adotantes', AdotanteController::class)
    ->only(['index', 'create']);

Route::post('/adotantes', [AdotanteController::class, 'store'])
    ->name('adotantes.store')
    ->middleware('throttle:5,1');

// Adoção / Pets -------------------------------------------------
Route::get('/adotar', [PetController::class, 'adotar'])->name('adotar');

Route::get('/pets', [PetController::class, 'index']);

Route::post('/pets/{id}/reservar', [PetController::class, 'reservar'])
    ->name('pets.reservar')
    ->middleware('auth:adotante');

Route::get('/pet/{pet}', [PetController::class, 'mostrar'])->name('pet.mostrar');

// Filtros de pets (cachorros / gatos) ---------------------------
Route::get('/adotar/cachorros', [PetController::class, 'listarCachorros'])
    ->name('pets.cachorros');

Route::get('/adotar/gatos', [PetController::class, 'listarGatos'])
    ->name('pets.gatos');

// Painel da ONG - Pets / Interesses -----------------------------
Route::middleware(['auth:ong'])->group(function () {
    Route::view('/painel-ong', 'painelOng')->name('painel.ong');

    Route::get('/painel-ong/pets', [OngPainelController::class, 'listarPets'])->name('ong.pets');
    Route::get('/painel-ong/pets/novo', [OngPainelController::class, 'cadastrarPet'])->name('ong.pets.novo');
    Route::post('/painel-ong/pets', [OngPainelController::class, 'salvarPet'])->name('ong.pets.salvar');
    Route::put('/painel/ong/pets/{id}/status', [OngPainelController::class, 'atualizarStatusPet'])->name('ong.pets.atualizar.status');
    Route::get('/painel-ong/pets/{id}/editar', [OngPainelController::class, 'editarPet'])->name('ong.pets.editar');
    Route::put('/painel-ong/pets/{id}', [OngPainelController::class, 'atualizarPet'])->name('ong.pets.atualizar');
    Route::delete('/painel-ong/pets/{id}', [OngPainelController::class, 'excluirPet'])->name('ong.pets.excluir');
    Route::post('/painel-ong/pets/{id}/facebook', [OngPainelController::class, 'enviarPetParaFacebook'])
        ->name('ong.pets.facebook')
        ->middleware('throttle:3,1');

    Route::get('/painel-ong/interesses', [OngPainelController::class, 'interesses'])->name('ong.interesses');
});

// Solicitações de adoção (adotante) -----------------------------
Route::post('/solicitacoes', [SolicitacaoController::class, 'store'])
    ->name('solicitacoes.store')
    ->middleware('throttle:10,1');

// Painel da ONG - Solicitações ----------------------------------
Route::middleware('auth:ong')
    ->prefix('painel/ong')
    ->name('ong.')
    ->group(function () {
        // lista de solicitações (sua view)
        Route::get('/solicitacoes', [SolicitacaoController::class, 'index'])
            ->name('solicitacoes');

        // aceitar uma solicitação (form POST da view usa /painel/ong/solicitacoes/{id}/aceitar)
        Route::post('/solicitacoes/{id}/aceitar', [SolicitacaoController::class, 'aceitar'])
            ->name('solicitacoes.aceitar');

        // atualizar status (sua view faz PATCH /painel/ong/solicitacoes/{id}/status)
        Route::patch('/solicitacoes/{id}/status', [SolicitacaoController::class, 'atualizarStatus'])
            ->name('solicitacoes.status');
    });

// Match ---------------------------------------------------------
Route::middleware('auth:adotante')->group(function () {
    Route::match(['get', 'post'], '/match', [MatchController::class, 'index'])
        ->name('match');
});

Route::get('/resultado-match', function () {
    return view('resultado_match');
})->name('resultado_match');

// Servir imagens do storage -------------------------------------
Route::get('/storage/images/{file}', function (string $file) {
    $file = ltrim($file, '/');
    abort_unless(Storage::disk('public')->exists('images/' . $file), 404);

    return Storage::disk('public')->response('images/' . $file)
        ->header('Cache-Control', 'public, max-age=604800'); // 7 dias
})->where('file', '.*');

// Política de privacidade ---------------------------------------
Route::view('/politica-de-privacidade', 'politica-privacidade')->name('politica');

// Parcerias -----------------------------------------------------
Route::view('/seja-um-parceiro', 'parceiro')->name('parceiro');
