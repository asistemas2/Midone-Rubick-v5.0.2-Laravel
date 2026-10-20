<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Contador por prefijo para los códigos automáticos (MT-0001, INM-0001...).
     * La fila se bloquea al generar un código para que dos usuarios no obtengan el mismo número.
     */
    public function up(): void
    {
        Schema::create('consecutivos', function (Blueprint $table) {
            $table->string('prefijo', 10)->primary();
            $table->unsignedInteger('ultimo')->default(0);
            $table->timestamps();
        });

        // El valor real de arranque se toma del código más alto existente al generar el siguiente
        $ahora = now();
        DB::table('consecutivos')->insert(array_map(
            fn ($prefijo) => ['prefijo' => $prefijo, 'ultimo' => 0, 'created_at' => $ahora, 'updated_at' => $ahora],
            ['MT', 'INM', 'EQ', 'GAR'],
        ));
    }

    public function down(): void
    {
        Schema::dropIfExists('consecutivos');
    }
};
