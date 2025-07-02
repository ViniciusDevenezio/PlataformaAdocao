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
    Schema::table('pets', function (Blueprint $table) {
        $table->unsignedBigInteger('adotante_id')->nullable()->after('ong_id');

        $table->foreign('adotante_id')
              ->references('id')
              ->on('adotantes')
              ->onDelete('set null'); // ou cascade, se quiser deletar o pet junto
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('pets', function (Blueprint $table) {
        $table->dropForeign(['adotante_id']);
        $table->dropColumn('adotante_id');
    });
}
};
