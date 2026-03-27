<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias_equipo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
            $table->foreignId('tipo_equipo_id')
                  ->nullable()
                  ->constrained('tipos_equipo')
                  ->nullOnDelete();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_equipo');
    }
};
