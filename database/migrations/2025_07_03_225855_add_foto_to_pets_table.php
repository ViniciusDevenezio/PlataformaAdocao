<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona a coluna `foto` (caso não exista).
     */
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            // evita erro “Duplicate column”
            if (!Schema::hasColumn('pets', 'foto')) {
                $table->string('foto')->nullable()->after('raca');
            }
        });
    }

    /**
     * Remove a coluna `foto` no rollback.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            if (Schema::hasColumn('pets', 'foto')) {
                $table->dropColumn('foto');
            }
        });
    }
};
