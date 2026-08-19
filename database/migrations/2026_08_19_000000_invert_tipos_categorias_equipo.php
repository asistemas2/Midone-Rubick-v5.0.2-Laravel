<?php
// database/migrations/2026_08_19_000000_invert_tipos_categorias_equipo.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Agregar columna categoria_equipo_id a tipos_equipo (nivel inferior)
        Schema::table('tipos_equipo', function (Blueprint $table) {
            $table->foreignId('categoria_equipo_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('categorias_equipo')
                  ->nullOnDelete();
        });

        // 2. Eliminar columna tipo_equipo_id de categorias_equipo (ya no es padre)
        Schema::table('categorias_equipo', function (Blueprint $table) {
            $table->dropForeign(['tipo_equipo_id']);
            $table->dropColumn('tipo_equipo_id');
        });
    }

    public function down(): void
    {
        // Revertir cambios
        Schema::table('categorias_equipo', function (Blueprint $table) {
            $table->foreignId('tipo_equipo_id')->nullable()->constrained('tipos_equipo')->nullOnDelete();
        });

        Schema::table('tipos_equipo', function (Blueprint $table) {
            $table->dropForeign(['categoria_equipo_id']);
            $table->dropColumn('categoria_equipo_id');
        });
    }
};