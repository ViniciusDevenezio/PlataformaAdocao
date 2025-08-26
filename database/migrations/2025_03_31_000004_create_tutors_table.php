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
        Schema::create('tutor', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf')->unique(); 
            $table->date('nascimento');
            $table->string('email')->unique();
            $table->string('celular')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('endereco'); 
            $table->string('numero'); 
            $table->string('complemento')->nullable(); 
            $table->string('bairro'); 
            $table->string('estado'); 
            $table->string('cidade'); 
            $table->string('senha');
           // $table->rememberToken();
          //  $table->timestamps();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tutors', function (Blueprint $table) {
            //
        });
    }
};
