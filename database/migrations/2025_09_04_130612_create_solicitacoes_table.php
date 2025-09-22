<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('solicitacoes', function (Blueprint $table) {
            $table->id();

            // FKs (precisam existir: pets, adotantes, ongs)
            $table->foreignId('pet_id')->constrained('pets')->cascadeOnDelete();
            $table->foreignId('adotante_id')->constrained('adotantes')->cascadeOnDelete();
            $table->foreignId('ong_id')->constrained('ongs')->cascadeOnDelete();

            // snapshot do celular do adotante no momento do pedido (vem de adotantes.celular)
            $table->string('celular_cache', 32)->nullable();

            $table->text('mensagem')->nullable();

            // fluxo simples de aprovação
            $table->enum('status', ['novo', 'aprovado', 'recusado'])->default('novo');

            $table->timestamps();

            // evita duplicar pedido do MESMO adotante para o MESMO pet
            $table->unique(['pet_id', 'adotante_id']);

            // ajuda na listagem do painel da ONG
            $table->index(['ong_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitacoes');
    }
};
