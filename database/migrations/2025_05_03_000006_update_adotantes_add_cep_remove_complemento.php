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
    Schema::table('adotantes', function (Blueprint $table) {
        $table->string('cep', 9)->after('cpf'); // ou onde quiser
        $table->dropColumn('complemento');
    });
}

public function down()
{
    Schema::table('adotantes', function (Blueprint $table) {
        $table->dropColumn('cep');
        $table->string('complemento')->nullable(); // se quiser reverter
    });
}
};
