<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criticidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->unique();
            $table->unsignedTinyInteger('nivel');
            $table->string('color_hex', 7)->default('#6c757d');
            $table->unsignedTinyInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criticidades');
    }
};
