<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//rota para receber os dados do formulario
use App\Http\Controllers\TutorController;

Route::post('/cadastro', [TutorController::class, 'store'])->name('tutor.store');

