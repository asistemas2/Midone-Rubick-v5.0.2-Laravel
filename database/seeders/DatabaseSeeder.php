<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            
            UserSeeder::class,
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
        ]);

        

        
    }
}
