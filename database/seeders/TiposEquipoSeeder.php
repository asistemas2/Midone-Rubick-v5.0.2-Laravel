<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposEquipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Eléctrico',   'descripcion' => 'Equipos del sistema eléctrico: transformadores, UPS, generadores, tableros'],
            ['nombre' => 'Hidráulico',  'descripcion' => 'Equipos del sistema hidráulico: bombas, válvulas, tanques'],
            ['nombre' => 'HVAC',        'descripcion' => 'Equipos de climatización: aires acondicionados, chillers, ventilación'],
            ['nombre' => 'General',     'descripcion' => 'Equipos de uso general: herramientas, básculas, plantas telefónicas'],
            ['nombre' => 'Medición',    'descripcion' => 'Medidores de energía, agua, gas'],
            ['nombre' => 'Seguridad',   'descripcion' => 'Equipos de seguridad: cámaras, control de acceso, detección de incendios'],
        ];

        foreach ($tipos as $t) {
            DB::table('tipos_equipo')->updateOrInsert(
                ['nombre' => $t['nombre']],
                array_merge($t, [
                    'activo'     => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
