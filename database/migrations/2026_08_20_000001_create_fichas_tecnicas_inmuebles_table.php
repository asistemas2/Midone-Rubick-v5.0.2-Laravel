<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fichas_tecnicas_inmuebles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inmueble_id')->constrained()->onDelete('cascade');
            // Áreas
            $table->decimal('area_calificada', 12, 2)->nullable();
            $table->decimal('area_util', 12, 2)->nullable();
            $table->decimal('area_bruta', 12, 2)->nullable();
            // Servicios
            $table->string('capacidad_electrica', 50)->nullable();
            $table->string('agua_diametro', 20)->nullable();
            $table->text('tuberia_aguas_lluvias')->nullable();
            // Contra incendios
            $table->string('cajas_inspeccion_pluvial')->nullable();
            $table->text('red_contra_incendios')->nullable();
            $table->unsignedInteger('gabinetes_ci')->nullable();
            // Estructura y acabados
            $table->text('cubierta')->nullable();
            $table->text('muros')->nullable();
            $table->text('acabados')->nullable();
            $table->text('pisos')->nullable();
            $table->text('blindaje_juntas')->nullable();
            $table->text('estructura')->nullable();
            $table->text('puertas_ventanas')->nullable();
            // Complementos
            $table->boolean('muelle')->default(false);
            $table->boolean('mezzanine')->default(false);
            $table->unsignedInteger('bloques_banos')->nullable();
            $table->boolean('cocineta')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fichas_tecnicas_inmuebles');
    }
};