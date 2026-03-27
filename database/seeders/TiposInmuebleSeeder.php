<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposInmuebleSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Bodega',
            'Oficina',
            'Área Común',
            'Infraestructura',
            'Local Comercial',
            'Caseta',
            'Patio',
            'Subestación',
            'Planta de Tratamiento',
            'Portería',
            'Casino / Comedor',
            'Parqueadero',
            'Cuarto Técnico',
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipos_inmueble')->updateOrInsert(
                ['nombre' => $tipo],
                [
                    'descripcion' => null,
                    'activo'      => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }
    }
}
