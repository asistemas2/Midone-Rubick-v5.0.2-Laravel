<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // Inmuebles
            BloquesSeeder::class,
            TiposInmuebleSeeder::class,
            PeriodicidadesMantenimientoSeeder::class,
            NivelesDeterioroSeeder::class,

            // Equipos (nuevo orden)
            CategoriasEquipoSeeder::class,   // primero categorías (superior)
            TiposEquipoSeeder::class,        // luego tipos (inferior, dependen de categorías)
            EstadosEquipoSeeder::class,
            MarcasSeeder::class,
            CriticidadesSeeder::class,

            // Módulos principales
            InmueblesSeeder::class,
            EquiposSeeder::class,            // depende de tipos y categorías
            MantenimientosSeeder::class,
            GarantiasSeeder::class,
        ]);
    }
}