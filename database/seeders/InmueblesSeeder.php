<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InmueblesSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/data/inmuebles_seed.json'));
        $items = json_decode($json, true);

        // Obtener IDs de tablas maestras
        $tiposInmueble = DB::table('tipos_inmueble')->pluck('id', 'nombre')->toArray();
        $bloques = DB::table('bloques')->pluck('id', 'nombre')->toArray();
        $niveles = DB::table('niveles_deterioro')->pluck('id', 'nombre')->toArray();

        // Coordenadas base para Palmira, Colombia (zona industrial ZFP)
        $baseLat = 3.5167;
        $baseLng = -76.3033;

        foreach ($items as $item) {
            // Buscar tipo_inmueble_id
            $tipoId = null;
            foreach ($tiposInmueble as $nombre => $id) {
                if (stripos($nombre, $item['tipo']) !== false || stripos($item['tipo'], $nombre) !== false) {
                    $tipoId = $id;
                    break;
                }
            }
            // Si no encontramos, usar primer tipo como default
            if (!$tipoId && !empty($tiposInmueble)) {
                $tipoId = reset($tiposInmueble);
            }

            // Buscar bloque_id (primer bloque como default)
            $bloqueId = !empty($bloques) ? reset($bloques) : null;

            // Nivel de deterioro basado en campo "deterioro"
            $nivelId = null;
            if ($item['deterioro'] === 'SI') {
                $nivelId = $niveles['Medio'] ?? ($niveles['Alto'] ?? null);
            } else {
                $nivelId = $niveles['Bajo'] ?? null;
            }

            // Generar coordenadas aleatorias alrededor de ZFP Palmira
            $lat = $baseLat + (mt_rand(-500, 500) / 100000);
            $lng = $baseLng + (mt_rand(-500, 500) / 100000);

            DB::table('inmuebles')->updateOrInsert(
                ['codigo' => $item['codigo']],
                [
                    'nombre' => $item['nombre'],
                    'bloque_id' => $bloqueId,
                    'tipo_inmueble_id' => $tipoId,
                    'direccion' => 'Zona Franca del Pacífico, Palmira, Valle del Cauca',
                    'area_m2' => mt_rand(50, 10000) + (mt_rand(0, 99) / 100),
                    'area_construida_m2' => mt_rand(30, 8000) + (mt_rand(0, 99) / 100),
                    'latitud' => round($lat, 8),
                    'longitud' => round($lng, 8),
                    'estado' => 'operativo',
                    'nivel_deterioro_id' => $nivelId,
                    'fecha_construccion' => null,
                    'valor_catastral' => mt_rand(50000000, 500000000) + (mt_rand(0, 99) / 100),
                    'observaciones' => $item['obs'] ?: null,
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
