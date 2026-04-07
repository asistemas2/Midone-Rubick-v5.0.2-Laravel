<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();
            $table->enum('tipo_activo', ['inmueble', 'equipo']);
            $table->unsignedBigInteger('activo_id');
            $table->string('activo_type', 100);
            $table->enum('tipo_mantenimiento', ['preventivo', 'correctivo', 'predictivo']);
            $table->text('descripcion')->nullable();
            $table->date('fecha_programada')->nullable();
            $table->date('fecha_realizada')->nullable();
            $table->string('responsable', 200)->nullable();
            $table->enum('tipo_responsable', ['Mincit', 'Operador ZFP', 'Usuario-calificado'])->nullable();
            $table->string('empresa_contratista', 200)->nullable();
            $table->enum('estado', ['programado', 'en_proceso', 'completado', 'cancelado'])->default('programado');
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('activo_id');
            $table->index('activo_type');
            $table->index('estado');
            $table->index('tipo_activo');
            $table->index('tipo_mantenimiento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
