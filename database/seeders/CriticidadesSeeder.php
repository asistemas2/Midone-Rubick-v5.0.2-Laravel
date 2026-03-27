<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriticidadesSeeder extends Seeder
{
    public function run(): void
    {
        $criticidades = [
            ['nombre' => 'Crítica', 'nivel' => 4, 'color_hex' => '#dc3545', 'orden' => 1],
            ['nombre' => 'Alta',    'nivel' => 3, 'color_hex' => '#fd7e14', 'orden' => 2],
            ['nombre' => 'Media',   'nivel' => 2, 'color_hex' => '#ffc107', 'orden' => 3],
            ['nombre' => 'Baja',    'nivel' => 1, 'color_hex' => '#28a745', 'orden' => 4],
        ];

        foreach ($criticidades as $c) {
            DB::table('criticidades')->updateOrInsert(
                ['nombre' => $c['nombre']],
                array_merge($c, [
                    'activo'     => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
