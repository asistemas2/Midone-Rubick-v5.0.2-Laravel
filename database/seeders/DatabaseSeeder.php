<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // ── Autenticación y permisos ───────────────────────
            UserSeeder::class,
            RolesAndPermissionsSeeder::class,

            // ── Catálogos de inmuebles ─────────────────────────
            BloquesSeeder::class,
            TiposInmuebleSeeder::class,
            PeriodicidadesMantenimientoSeeder::class,
            NivelesDeterioroSeeder::class,

            // ── Catálogos de equipos ───────────────────────────
            CategoriasEquipoSeeder::class,
            TiposEquipoSeeder::class,
            EstadosEquipoSeeder::class,
            MarcasSeeder::class,
            CriticidadesSeeder::class,              // equipos
            CriticidadesMantenimientoSeeder::class, // ← NUEVO (mantenimientos)

            // ── Módulos principales ────────────────────────────
            InmueblesSeeder::class,
            EquiposSeeder::class,
            MantenimientosSeeder::class,
            GarantiasSeeder::class,
        ]);
    }
}