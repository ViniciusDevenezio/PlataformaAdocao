<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('pets', function (Blueprint $table) {
        $table->id();
        $table->string('nome', 100);
        $table->string('raca', 100);
        $table->boolean('mistura')->default(false);
        $table->string('misturado_com', 100)->nullable();
        $table->string('temperamento', 255)->nullable();
        $table->enum('porte', ['pequeno', 'medio', 'grande']);
        $table->enum('genero', ['Macho', 'Femea']);
        $table->string('faixa_etaria', 20)->nullable();
        $table->string('localizacao', 100)->nullable();
        $table->date('disponivel_ate')->nullable();
        $table->enum('status', ['disponivel', 'reservado'])->default('disponivel');
        $table->string('imagem_url', 255)->nullable();
        $table->string('descricao', 500)->nullable();

        // Índices
        $table->index('porte');
        $table->index('temperamento');
        $table->index('mistura');
        $table->index('localizacao');
        $table->index('status');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
