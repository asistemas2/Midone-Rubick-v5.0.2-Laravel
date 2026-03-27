<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosEquipoSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Operativo',          'codigo' => 'EST-OPER',  'color_hex' => '#28a745'],
            ['nombre' => 'Requiere Atención',  'codigo' => 'EST-ATEN',  'color_hex' => '#ffc107'],
            ['nombre' => 'En Mantenimiento',   'codigo' => 'EST-MANT',  'color_hex' => '#17a2b8'],
            ['nombre' => 'Fuera de Servicio',  'codigo' => 'EST-FUERA', 'color_hex' => '#dc3545'],
            ['nombre' => 'Dado de Baja',       'codigo' => 'EST-BAJA',  'color_hex' => '#6c757d'],
        ];

        foreach ($estados as $e) {
            DB::table('estados_equipo')->updateOrInsert(
                ['codigo' => $e['codigo']],
                array_merge($e, [
                    'activo'     => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
