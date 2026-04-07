<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta todos los seeders de tablas maestras del sistema ZFP.
     *
     * ORDEN IMPORTANTE: Las tablas con dependencias (FK) deben ejecutarse
     * después de las tablas referenciadas.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,                 // Primero: usuarios para autenticación
            // ── Inmuebles (sin dependencias entre sí) ──────────
            BloquesSeeder::class,
            TiposInmuebleSeeder::class,
            PeriodicidadesMantenimientoSeeder::class,
            NivelesDeterioroSeeder::class,

            // ── Equipos ────────────────────────────────────────
            TiposEquipoSeeder::class,          // Primero: referenciado por categorías
            EstadosEquipoSeeder::class,
            CategoriasEquipoSeeder::class,      // Depende de tipos_equipo
            MarcasSeeder::class,
            CriticidadesSeeder::class,

            // ── Módulos Principales ────────────────────────────
            InmueblesSeeder::class,             // Depende de bloques, tipos_inmueble, niveles_deterioro
            EquiposSeeder::class,               // Depende de tipos_equipo, categorias_equipo, marcas, estados_equipo, criticidades, periodicidades
            MantenimientosSeeder::class,        // Depende de inmuebles, equipos
            GarantiasSeeder::class,             // Depende de mantenimientos
        ]);
    }
}
