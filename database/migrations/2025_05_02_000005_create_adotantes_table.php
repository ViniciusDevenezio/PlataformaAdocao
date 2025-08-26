<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('adotantes', function (Blueprint $table) {
        $table->id();
        $table->string('nome_completo');
        $table->string('cpf');
        $table->date('nascimento');
        $table->string('email')->unique();
        $table->string('celular');
        $table->string('senha');
        $table->string('endereco');
        $table->string('numero');
        $table->string('complemento')->nullable();
        $table->string('bairro');
        $table->string('estado');
        $table->string('cidade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adotantes');
    }
};
