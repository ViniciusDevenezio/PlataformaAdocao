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

            // relação
            $table->unsignedBigInteger('ong_id')->nullable(); 
            $table->unsignedBigInteger('adotante_id')->nullable();

            // dados principais
            $table->string('nome', 100);
            $table->enum('especie', ['cachorro','gato'])->default('cachorro');
            $table->string('raca', 100)->nullable();
            $table->boolean('mistura')->default(false);
            $table->string('misturado_com', 100)->nullable();

            // comportamento
            $table->string('temperamento', 255)->nullable(); // chips concatenados
            $table->enum('porte', ['pequeno','medio','grande']);
            $table->enum('genero', ['macho','femea']);

            // idade + faixa etária calculada
            $table->string('idade', 50)->nullable(); // ex: "2 anos", "8 meses"
            $table->enum('faixa_etaria', ['Filhote','Jovem','Adulto','Idoso'])->nullable();

            // localização
            $table->string('localizacao', 100)->nullable();

            // status e datas
            $table->date('disponivel_ate')->nullable();
            $table->enum('status', ['disponivel', 'reservado','adotado'])->default('disponivel');

            // imagem e descrição
            $table->string('imagem_url', 255)->nullable();
            $table->string('descricao', 500)->nullable();

            // saúde
            $table->boolean('vacinado')->default(false);
            $table->boolean('vermifugado')->default(false);

            // slug p/ urls
            $table->string('slug', 255)->unique();

            // índices úteis
            $table->index('porte');
            $table->index('temperamento');
            $table->index('mistura');
            $table->index('localizacao');
            $table->index('status');
            $table->index('especie');
            $table->index('faixa_etaria');
            $table->index('ong_id');

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
