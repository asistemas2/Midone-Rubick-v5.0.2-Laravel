<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloquesSeeder extends Seeder
{
    public function run(): void
    {
        $bloques = [
            ['nombre' => 'Bloque A', 'codigo' => 'BLQ-A', 'descripcion' => 'Bloque principal de bodegas A1-A15', 'area_m2' => 45000.00],
            ['nombre' => 'Bloque B', 'codigo' => 'BLQ-B', 'descripcion' => 'Bloque de bodegas 10-19', 'area_m2' => 32000.00],
            ['nombre' => 'Bloque C', 'codigo' => 'BLQ-C', 'descripcion' => 'Bloque de bodegas 28-31', 'area_m2' => 18000.00],
            ['nombre' => 'Bloque D', 'codigo' => 'BLQ-D', 'descripcion' => 'Zona administrativa y locales comerciales', 'area_m2' => 5000.00],
            ['nombre' => 'Bloque E', 'codigo' => 'BLQ-E', 'descripcion' => 'Zona de patios y áreas comunes', 'area_m2' => 60000.00],
        ];

        foreach ($bloques as $bloque) {
            DB::table('bloques')->updateOrInsert(
                ['codigo' => $bloque['codigo']],
                array_merge($bloque, [
                    'activo'     => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
