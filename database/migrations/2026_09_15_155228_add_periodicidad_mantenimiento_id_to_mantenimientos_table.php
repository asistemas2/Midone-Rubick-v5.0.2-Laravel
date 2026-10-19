<?php
// database/migrations/2026_09_15_000005_add_periodicidad_mantenimiento_id_to_mantenimientos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mantenimientos', function (Blueprint $table) {
            $table->foreignId('periodicidad_mantenimiento_id')
                  ->nullable()
                  ->after('criticidad_mantenimiento_id')
                  ->constrained('periodicidades_mantenimiento')
                  ->nullOnDelete();

            $table->index('periodicidad_mantenimiento_id');
        });
    }

    public function down(): void
    {
        Schema::table('mantenimientos', function (Blueprint $table) {
            $table->dropForeign(['periodicidad_mantenimiento_id']);
            $table->dropIndex(['periodicidad_mantenimiento_id']);
            $table->dropColumn('periodicidad_mantenimiento_id');
        });
    }
};