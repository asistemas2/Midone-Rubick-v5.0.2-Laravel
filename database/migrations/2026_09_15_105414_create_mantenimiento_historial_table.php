<?php
// database/migrations/2026_09_15_000003_create_mantenimiento_historial_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimiento_historial', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mantenimiento_id')
                  ->constrained('mantenimientos')
                  ->cascadeOnDelete();

            // Estado anterior (nullable = creación)
            $table->enum('estado_anterior', [
                'programado', 'en_proceso', 'completado', 'cancelado'
            ])->nullable();

            // Estado nuevo
            $table->enum('estado_nuevo', [
                'programado', 'en_proceso', 'completado', 'cancelado'
            ]);

            // Comentario/observación del cambio
            $table->text('comentario')->nullable();

            // Costo real (si aplica al pasar a completado)
            $table->decimal('costo_real', 15, 2)->nullable();

            // Usuario que realizó el cambio (auditoría)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Snapshot del nombre del usuario (para auditoría inmutable)
            $table->string('user_nombre', 200)->nullable();

            $table->timestamps();

            $table->index('mantenimiento_id');
            $table->index('estado_nuevo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_historial');
    }
};