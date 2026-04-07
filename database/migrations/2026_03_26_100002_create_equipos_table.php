<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 300);
            $table->foreignId('tipo_equipo_id')->nullable()->constrained('tipos_equipo')->nullOnDelete();
            $table->foreignId('categoria_equipo_id')->nullable()->constrained('categorias_equipo')->nullOnDelete();
            $table->foreignId('marca_id')->nullable()->constrained('marcas')->nullOnDelete();
            $table->string('modelo', 150)->nullable();
            $table->string('no_serie', 100)->nullable();
            $table->foreignId('inmueble_id')->nullable()->constrained('inmuebles')->nullOnDelete();
            $table->string('ubicacion_especifica', 300)->nullable();
            $table->string('capacidad', 100)->nullable();
            $table->string('voltaje', 100)->nullable();
            $table->string('potencia', 100)->nullable();
            $table->string('frecuencia', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->date('fecha_adquisicion')->nullable();
            $table->date('fecha_instalacion')->nullable();
            $table->unsignedSmallInteger('vida_util_anios')->nullable();
            $table->string('proveedor', 200)->nullable();
            $table->unsignedSmallInteger('garantia_meses')->nullable();
            $table->foreignId('estado_equipo_id')->nullable()->constrained('estados_equipo')->nullOnDelete();
            $table->foreignId('criticidad_id')->nullable()->constrained('criticidades')->nullOnDelete();
            $table->foreignId('periodicidad_mantenimiento_id')->nullable()->constrained('periodicidades_mantenimiento')->nullOnDelete();
            $table->date('ultimo_mantenimiento')->nullable();
            $table->date('proximo_mantenimiento')->nullable();
            $table->string('responsable', 200)->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('codigo');
            $table->index('tipo_equipo_id');
            $table->index('categoria_equipo_id');
            $table->index('marca_id');
            $table->index('inmueble_id');
            $table->index('estado_equipo_id');
            $table->index('criticidad_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
