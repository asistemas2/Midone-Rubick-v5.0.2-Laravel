<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inmuebles', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 200);
            $table->foreignId('bloque_id')->nullable()->constrained('bloques')->nullOnDelete();
            $table->foreignId('tipo_inmueble_id')->nullable()->constrained('tipos_inmueble')->nullOnDelete();
            $table->string('direccion', 300)->nullable();
            $table->decimal('area_m2', 12, 2)->nullable();
            $table->decimal('area_construida_m2', 12, 2)->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->enum('estado', ['operativo', 'mantenimiento', 'fuera_servicio'])->default('operativo');
            $table->foreignId('nivel_deterioro_id')->nullable()->constrained('niveles_deterioro')->nullOnDelete();
            $table->date('fecha_construccion')->nullable();
            $table->decimal('valor_catastral', 15, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('codigo');
            $table->index('bloque_id');
            $table->index('tipo_inmueble_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inmuebles');
    }
};
