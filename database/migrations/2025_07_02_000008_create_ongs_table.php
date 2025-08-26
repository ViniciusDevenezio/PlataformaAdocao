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
    Schema::create('ongs', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('email')->unique();
        $table->string('senha'); // hashed
        $table->string('telefone')->nullable();
        $table->string('cnpj')->unique();
        $table->string('cep');
        $table->string('endereco');
        $table->string('numero');
        $table->string('bairro');
        $table->string('cidade');
        $table->string('estado');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ongs');
    }
};
