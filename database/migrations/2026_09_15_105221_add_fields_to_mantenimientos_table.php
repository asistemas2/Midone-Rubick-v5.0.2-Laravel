<?php
// database/migrations/2026_09_15_000002_add_fields_to_mantenimientos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mantenimientos', function (Blueprint $table) {
            // Criterio del mantenimiento (radio)
            $table->enum('criterio_mantenimiento', [
                'riesgo_vida',
                'riesgo_operacional',
                'riesgo_sancionatorio',
                'riesgo_activo',
            ])->nullable()->after('tipo_mantenimiento');

            // Criticidad del mantenimiento (select dependiente)
            $table->foreignId('criticidad_mantenimiento_id')
                  ->nullable()
                  ->after('criterio_mantenimiento')
                  ->constrained('criticidades_mantenimiento')
                  ->nullOnDelete();

            // Costo aproximado (ingresado por el usuario al crear/editar)
            $table->decimal('costo_aproximado', 15, 2)->nullable()->after('empresa_contratista');

            // Costo real (ingresado al completar)
            $table->decimal('costo_real', 15, 2)->nullable()->after('costo_aproximado');

            // Fecha en que se completó realmente
            $table->timestamp('fecha_completado')->nullable()->after('fecha_realizada');

            // Índice sobre criticidad_mantenimiento_id
            $table->index('criticidad_mantenimiento_id');
        });
    }

    public function down(): void
    {
        Schema::table('mantenimientos', function (Blueprint $table) {
            $table->dropForeign(['criticidad_mantenimiento_id']);
            $table->dropIndex(['criticidad_mantenimiento_id']);
            $table->dropColumn([
                'criterio_mantenimiento',
                'criticidad_mantenimiento_id',
                'costo_aproximado',
                'costo_real',
                'fecha_completado',
            ]);
        });
    }
};