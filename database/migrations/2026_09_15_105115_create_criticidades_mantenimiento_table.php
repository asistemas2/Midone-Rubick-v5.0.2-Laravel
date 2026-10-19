<?php
// database/migrations/2026_09_15_000001_create_criticidades_mantenimiento_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criticidades_mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->unique();      // Grave, Moderado, Leve
            $table->string('codigo', 20)->unique();      // GRAVE, MODERADO, LEVE
            $table->unsignedTinyInteger('nivel');        // 3, 2, 1
            $table->string('color_hex', 7)->default('#6c757d');
            $table->unsignedTinyInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criticidades_mantenimiento');
    }
};