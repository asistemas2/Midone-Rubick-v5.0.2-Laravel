<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garantias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();
            $table->foreignId('mantenimiento_id')->nullable()->constrained('mantenimientos')->nullOnDelete();
            $table->enum('tipo_activo', ['inmueble', 'equipo']);
            $table->unsignedBigInteger('activo_id')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('proveedor', 200)->nullable();
            $table->text('terminos')->nullable();
            $table->decimal('monto', 15, 2)->nullable();
            $table->enum('estado', ['activa', 'vencida', 'en_tramite'])->default('activa');
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('mantenimiento_id');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garantias');
    }
};
