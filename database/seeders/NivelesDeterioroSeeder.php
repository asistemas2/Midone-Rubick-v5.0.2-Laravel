<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelesDeterioroSeeder extends Seeder
{
    public function run(): void
    {
        $niveles = [
            ['nombre' => 'Bajo',     'codigo' => 'DET-BAJO',     'color_hex' => '#28a745', 'orden' => 1],
            ['nombre' => 'Medio',    'codigo' => 'DET-MEDIO',    'color_hex' => '#ffc107', 'orden' => 2],
            ['nombre' => 'Alto',     'codigo' => 'DET-ALTO',     'color_hex' => '#fd7e14', 'orden' => 3],
            ['nombre' => 'Crítico',  'codigo' => 'DET-CRITICO',  'color_hex' => '#dc3545', 'orden' => 4],
        ];

        foreach ($niveles as $n) {
            DB::table('niveles_deterioro')->updateOrInsert(
                ['codigo' => $n['codigo']],
                array_merge($n, [
                    'activo'     => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
