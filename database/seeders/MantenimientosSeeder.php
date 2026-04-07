<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MantenimientosSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/data/mantenimientos_seed.json'));
        $items = json_decode($json, true);

        // Mapeo de responsable a tipo_responsable del enum
        $tipoResponsableMap = [
            'Interno' => 'Operador ZFP',
            'Externo' => 'Mincit',
        ];

        // Mapeo de estado
        $estadoMap = [
            'Completado' => 'completado',
            'En Proceso' => 'en_proceso',
            'Programado' => 'programado',
        ];

        // Obtener IDs de inmuebles y equipos
        $inmuebles = DB::table('inmuebles')->pluck('id', 'codigo')->toArray();
        $equipos = DB::table('equipos')->pluck('id', 'codigo')->toArray();

        foreach ($items as $item) {
            // Determinar activo_id y activo_type
            $activoId = null;
            $activoType = null;

            if ($item['tipo_activo'] === 'inmueble') {
                $activoType = 'App\\Models\\Inmueble';
                // activoId para inmuebles es numérico, buscar por código INM-XXX
                $codigoInm = 'INM-' . str_pad($item['activo_id_ref'], 3, '0', STR_PAD_LEFT);
                $activoId = $inmuebles[$codigoInm] ?? null;
            } else {
                $activoType = 'App\\Models\\Equipo';
                $activoId = $equipos[$item['activo_id_ref']] ?? null;
            }

            // Si no encontramos el activo, usar ID 1 como fallback
            if (!$activoId) {
                $activoId = 1;
            }

            $estado = $estadoMap[$item['estado_src']] ?? 'programado';
            $tipoResp = $tipoResponsableMap[$item['tipo_responsable_src']] ?? 'Operador ZFP';

            DB::table('mantenimientos')->updateOrInsert(
                ['codigo' => $item['codigo']],
                [
                    'tipo_activo' => $item['tipo_activo'],
                    'activo_id' => $activoId,
                    'activo_type' => $activoType,
                    'tipo_mantenimiento' => $item['tipo_mantenimiento'],
                    'descripcion' => $item['descripcion'] ? substr($item['descripcion'], 0, 2000) : null,
                    'fecha_programada' => $item['fecha_programada'] ?: null,
                    'fecha_realizada' => $item['fecha_realizada'] ?: null,
                    'responsable' => $item['responsable'],
                    'tipo_responsable' => $tipoResp,
                    'empresa_contratista' => $item['empresa_contratista'],
                    'estado' => $estado,
                    'observaciones' => $item['observaciones'] ? substr($item['observaciones'], 0, 2000) : null,
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
