<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * El valor que se registra al programar un mantenimiento es el presupuesto
     * aprobado, no un costo aproximado/estimado.
     */
    public function up(): void
    {
        Schema::table('mantenimientos', function (Blueprint $table) {
            $table->renameColumn('costo_aproximado', 'presupuesto_aprobado');
        });
    }

    public function down(): void
    {
        Schema::table('mantenimientos', function (Blueprint $table) {
            $table->renameColumn('presupuesto_aprobado', 'costo_aproximado');
        });
    }
};
