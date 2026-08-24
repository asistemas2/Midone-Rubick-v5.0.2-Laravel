<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InmueblesSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar archivo JSON
        $paths = [
            database_path('seeders/data/inmuebles_seed.json'),
            database_path('seeders/data/inventario.json'),
        ];

        $items = null;
        foreach ($paths as $filePath) {
            if (file_exists($filePath)) {
                $json = file_get_contents($filePath);
                if ($json !== false) {
                    $items = json_decode($json, true);
                    if (is_array($items)) {
                        $this->command->info("Usando archivo: " . basename($filePath));
                        break;
                    }
                }
            }
        }

        if (!is_array($items)) {
            $this->command->error("No se pudo cargar ningún archivo JSON válido.");
            return;
        }

        // Obtener IDs de tablas maestras
        $tiposInmueble = DB::table('tipos_inmueble')->pluck('id', 'nombre')->toArray();
        $bloques = DB::table('bloques')->pluck('id', 'nombre')->toArray();
        $niveles = DB::table('niveles_deterioro')->pluck('id', 'nombre')->toArray();

        // Coordenadas base (se usarán si decides mantener las aleatorias)
        $baseLat = 3.5167;
        $baseLng = -76.3033;

        // Si prefieres que todos los inmuebles tengan las mismas coordenadas fijas
        // (por ejemplo, las de la ZFP), descomenta estas líneas y comenta las aleatorias:
        // $fixedLat = 3.55699494;
        // $fixedLng = -76.38508805;

        foreach ($items as $item) {
            // ---- TIPO DE INMUEBLE ----
            $tipoNombre = $item['tipo'] ?? 'Infraestructura';
            if (!isset($tiposInmueble[$tipoNombre])) {
                $existing = DB::table('tipos_inmueble')->where('nombre', $tipoNombre)->first();
                if ($existing) {
                    $tiposInmueble[$tipoNombre] = $existing->id;
                } else {
                    $id = DB::table('tipos_inmueble')->insertGetId([
                        'nombre' => $tipoNombre,
                        'descripcion' => null,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $tiposInmueble[$tipoNombre] = $id;
                }
            }
            $tipoId = $tiposInmueble[$tipoNombre];

            // ---- BLOQUE (con truncado a 100 caracteres) ----
            $bloqueNombreOriginal = $item['bloque'] ?? null;
            $bloqueNombre = null;
            $bloqueId = null;

            if ($bloqueNombreOriginal) {
                if (is_numeric($bloqueNombreOriginal)) {
                    $bloqueNombre = 'Bloque ' . $bloqueNombreOriginal;
                } else {
                    $bloqueNombre = $bloqueNombreOriginal;
                }
                // Truncar a 100 caracteres (máximo permitido en la migración)
                $bloqueNombre = substr($bloqueNombre, 0, 100);

                if (isset($bloques[$bloqueNombre])) {
                    $bloqueId = $bloques[$bloqueNombre];
                } else {
                    $existing = DB::table('bloques')->where('nombre', $bloqueNombre)->first();
                    if ($existing) {
                        $bloqueId = $existing->id;
                        $bloques[$bloqueNombre] = $bloqueId;
                    } else {
                        // Generar código único (máx 20 caracteres)
                        $baseCodigo = 'BLQ-' . strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $bloqueNombre), 0, 3));
                        $codigo = $baseCodigo;
                        $counter = 1;
                        while (DB::table('bloques')->where('codigo', $codigo)->exists()) {
                            $codigo = $baseCodigo . '-' . $counter;
                            $counter++;
                        }
                        $bloqueId = DB::table('bloques')->insertGetId([
                            'nombre' => $bloqueNombre,
                            'codigo' => $codigo,
                            'descripcion' => null,
                            'area_m2' => null,
                            'activo' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $bloques[$bloqueNombre] = $bloqueId;
                    }
                }
            }

            // ---- NIVEL DETERIORO ----
            $nivelId = null;
            if (isset($item['deterioro'])) {
                if ($item['deterioro'] === 'SI') {
                    $nivelId = $niveles['Medio'] ?? ($niveles['Alto'] ?? null);
                } elseif ($item['deterioro'] === 'NO') {
                    $nivelId = $niveles['Bajo'] ?? null;
                }
            }

            // ---- COORDENADAS (corregido) ----
            // Si usas fijas, descomenta estas dos líneas y comenta las aleatorias:
            // $lat = $fixedLat;
            // $lng = $fixedLng;
            // Si usas aleatorias (como estaba originalmente), usa esto:
            $lat = $baseLat + (mt_rand(-500, 500) / 100000);
            $lng = $baseLng + (mt_rand(-500, 500) / 100000);

            // ---- CÓDIGO DEL INMUEBLE ----
            $codigo = isset($item['id']) ? 'INM-' . str_pad($item['id'], 3, '0', STR_PAD_LEFT) : 'INM-' . uniqid();

            // ---- DESCRIPCIÓN ----
            $desc = ($item['descripcion'] ?? '') . "\n" . ($item['adecuaciones_zfp'] ?? '');
            $desc = trim($desc);

            // ---- DATOS DE FICHA TÉCNICA (seguro) ----
            $ft = isset($item['fichaTecnica']) && is_array($item['fichaTecnica']) ? $item['fichaTecnica'] : [];

            // ---- INSERCIÓN DEL INMUEBLE ----
            DB::table('inmuebles')->updateOrInsert(
                ['codigo' => $codigo],
                [
                    'nombre' => $item['nombre'],
                    'bloque_id' => $bloqueId,
                    'tipo_inmueble_id' => $tipoId,
                    'direccion' => 'Zona Franca del Pacífico, Palmira, Valle del Cauca',
                    'area_m2' => $ft['areaBruta'] ?? null,
                    'area_construida_m2' => $ft['areaUtil'] ?? null,
                    'latitud' => round($lat, 8),
                    'longitud' => round($lng, 8),
                    'estado' => 'operativo',
                    'nivel_deterioro_id' => $nivelId,
                    'fecha_construccion' => null,
                    'valor_catastral' => mt_rand(50000000, 500000000) + (mt_rand(0, 99) / 100),
                    'observaciones' => $desc ?: null,
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $inmuebleId = DB::table('inmuebles')->where('codigo', $codigo)->value('id');

            // ---- FICHA TÉCNICA (solo si hay datos) ----
            if (!empty($ft)) {
                DB::table('fichas_tecnicas_inmuebles')->updateOrInsert(
                    ['inmueble_id' => $inmuebleId],
                    [
                        'area_calificada' => $ft['areaCalificada'] ?? null,
                        'area_util' => $ft['areaUtil'] ?? null,
                        'area_bruta' => $ft['areaBruta'] ?? null,
                        'capacidad_electrica' => $ft['capacidadElectrica'] ?? null,
                        'agua_diametro' => $ft['aguaDiametro'] ?? null,
                        'tuberia_aguas_lluvias' => $ft['tuberiaAguas'] ?? null,
                        'cajas_inspeccion_pluvial' => $ft['cajasInspeccionPluvial'] ?? null,
                        'red_contra_incendios' => $ft['redContraIncendios'] ?? null,
                        'gabinetes_ci' => $ft['gabinetesCI'] ?? null,
                        'cubierta' => $ft['cubierta'] ?? null,
                        'muros' => $ft['muros'] ?? null,
                        'acabados' => $ft['acabados'] ?? null,
                        'pisos' => $ft['pisos'] ?? null,
                        'blindaje_juntas' => $ft['blindajeJuntas'] ?? null,
                        'estructura' => $ft['estructura'] ?? null,
                        'puertas_ventanas' => $ft['puertasVentanas'] ?? null,
                        'muelle' => ($ft['muelle'] ?? 'No') === 'Sí' ? true : false,
                        'mezzanine' => ($ft['mezzanine'] ?? 'No') === 'Sí' ? true : false,
                        'bloques_banos' => is_numeric($ft['bloquesBanos'] ?? null) ? (int)$ft['bloquesBanos'] : null,
                        'cocineta' => ($ft['cocineta'] ?? 'No') === 'Sí' ? true : false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        $this->command->info("Inmuebles y fichas técnicas creados/actualizados correctamente.");
    }
}