<?php
// database/migrations/2026_09_15_000004_create_mantenimiento_documentos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimiento_documentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mantenimiento_id')
                  ->constrained('mantenimientos')
                  ->cascadeOnDelete();

            // Tipo de documento
            $table->enum('tipo', [
                'orden_compra',
                'factura',
                'evidencia_fotografica',
                'acta',
                'otro'
            ])->default('otro');

            $table->string('nombre_original', 255);
            $table->string('ruta', 500);            // ruta dentro de storage/
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->text('descripcion')->nullable();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();

            $table->index('mantenimiento_id');
            $table->index('tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_documentos');
    }
};