<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquiposSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/data/equipos_seed.json'));
        $items = json_decode($json, true);

        // Obtener IDs de tablas maestras
        $tiposEquipo = DB::table('tipos_equipo')->pluck('id', 'nombre')->toArray();
        $categoriasEquipo = DB::table('categorias_equipo')->pluck('id', 'nombre')->toArray();
        $marcas = DB::table('marcas')->pluck('id', 'nombre')->toArray();
        $estadosEquipo = DB::table('estados_equipo')->pluck('id', 'nombre')->toArray();
        $criticidades = DB::table('criticidades')->pluck('id', 'nombre')->toArray();
        $periodicidades = DB::table('periodicidades_mantenimiento')->pluck('id', 'nombre')->toArray();
        $inmuebles = DB::table('inmuebles')->pluck('id', 'codigo')->toArray();

        // Mapeo de categorías del JS a tipos_equipo de la BD
        $catToTipo = [
            'Eléctrico' => 'Eléctrico',
            'General' => 'General',
            'Hidráulico' => 'Hidráulico',
            'HVAC' => 'HVAC',
        ];

        // Mapeo plan de mantenimiento a periodicidad
        $planToPeriodicidad = [
            'Mensual' => 'Mensual',
            'Bimensual' => 'Bimensual',
            'Trimestral' => 'Trimestral',
            'Cuatrimestral' => 'Cuatrimestral',
            'Semestral' => 'Semestral',
            'Anual' => 'Anual',
            'Tres en el año' => 'Cuatrimestral',
            'Mes y medio' => 'Bimensual',
        ];

        foreach ($items as $item) {
            // Buscar tipo_equipo_id
            $catTipo = $catToTipo[$item['categoria']] ?? 'General';
            $tipoEquipoId = $tiposEquipo[$catTipo] ?? null;

            // Buscar categoria_equipo_id por nombre de tipo del equipo
            $categoriaId = null;
            foreach ($categoriasEquipo as $nombre => $id) {
                if (stripos($nombre, $item['tipo']) !== false) {
                    $categoriaId = $id;
                    break;
                }
            }

            // Buscar marca_id
            $marcaId = $marcas[$item['marca']] ?? null;

            // Buscar estado_equipo_id
            $estadoId = $estadosEquipo[$item['estado']] ?? null;

            // Buscar criticidad_id
            $criticidadId = $criticidades[$item['criticidad']] ?? null;

            // Buscar periodicidad_id
            $periodicidadNombre = $planToPeriodicidad[$item['plan']] ?? null;
            $periodicidadId = $periodicidadNombre ? ($periodicidades[$periodicidadNombre] ?? null) : null;

            DB::table('equipos')->updateOrInsert(
                ['codigo' => $item['codigo']],
                [
                    'nombre' => $item['nombre'],
                    'tipo_equipo_id' => $tipoEquipoId,
                    'categoria_equipo_id' => $categoriaId,
                    'marca_id' => $marcaId,
                    'modelo' => $item['modelo'],
                    'no_serie' => $item['no_serie'],
                    'inmueble_id' => null,
                    'ubicacion_especifica' => $item['ubicacion'],
                    'capacidad' => $item['capacidad'],
                    'voltaje' => $item['voltaje'],
                    'potencia' => $item['potencia'],
                    'frecuencia' => $item['frecuencia'],
                    'descripcion' => $item['descripcion'],
                    'fecha_adquisicion' => $item['fecha_adquisicion'] ?: null,
                    'fecha_instalacion' => $item['fecha_instalacion'] ?: null,
                    'vida_util_anios' => $item['vida_util_anios'],
                    'proveedor' => $item['proveedor'],
                    'garantia_meses' => $item['garantia_meses'],
                    'estado_equipo_id' => $estadoId,
                    'criticidad_id' => $criticidadId,
                    'periodicidad_mantenimiento_id' => $periodicidadId,
                    'ultimo_mantenimiento' => $item['ultimo_mant'] ?: null,
                    'proximo_mantenimiento' => $item['proximo_mant'] ?: null,
                    'responsable' => $item['responsable'],
                    'observaciones' => $item['observaciones'] ? substr($item['observaciones'], 0, 1000) : null,
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
