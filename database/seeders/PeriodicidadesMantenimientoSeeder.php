<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodicidadesMantenimientoSeeder extends Seeder
{
    public function run(): void
    {
        $periodicidades = [
            ['nombre' => 'Semanal',       'dias_frecuencia' => 7,   'descripcion' => 'Cada 7 días'],
            ['nombre' => 'Quincenal',     'dias_frecuencia' => 15,  'descripcion' => 'Cada 15 días'],
            ['nombre' => 'Mensual',       'dias_frecuencia' => 30,  'descripcion' => 'Cada 30 días'],
            ['nombre' => 'Mes y medio',   'dias_frecuencia' => 45,  'descripcion' => 'Cada 45 días'],
            ['nombre' => 'Bimensual',     'dias_frecuencia' => 60,  'descripcion' => 'Cada 60 días'],
            ['nombre' => 'Trimestral',    'dias_frecuencia' => 90,  'descripcion' => 'Cada 90 días'],
            ['nombre' => 'Cuatrimestral', 'dias_frecuencia' => 120, 'descripcion' => 'Cada 120 días'],
            ['nombre' => 'Semestral',     'dias_frecuencia' => 180, 'descripcion' => 'Cada 180 días'],
            ['nombre' => 'Tres en el año','dias_frecuencia' => 122, 'descripcion' => 'Tres veces al año (cada ~4 meses)'],
            ['nombre' => 'Anual',         'dias_frecuencia' => 365, 'descripcion' => 'Una vez al año'],
        ];

        foreach ($periodicidades as $p) {
            DB::table('periodicidades_mantenimiento')->updateOrInsert(
                ['nombre' => $p['nombre']],
                array_merge($p, [
                    'activo'     => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
