<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periodicidades_mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->integer('dias_frecuencia');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodicidades_mantenimiento');
    }
};
