<?php
// database/seeders/CriticidadesMantenimientoSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriticidadesMantenimientoSeeder extends Seeder
{
    public function run(): void
    {
        $criticidades = [
            [
                'nombre'    => 'Grave',
                'codigo'    => 'GRAVE',
                'nivel'     => 3,
                'color_hex' => '#dc3545', // rojo
                'orden'     => 1,
            ],
            [
                'nombre'    => 'Moderado',
                'codigo'    => 'MODERADO',
                'nivel'     => 2,
                'color_hex' => '#ffc107', // amarillo
                'orden'     => 2,
            ],
            [
                'nombre'    => 'Leve',
                'codigo'    => 'LEVE',
                'nivel'     => 1,
                'color_hex' => '#28a745', // verde
                'orden'     => 3,
            ],
        ];

        foreach ($criticidades as $c) {
            DB::table('criticidades_mantenimiento')->updateOrInsert(
                ['codigo' => $c['codigo']],
                array_merge($c, [
                    'activo'     => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}