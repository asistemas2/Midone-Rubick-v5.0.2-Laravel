<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Sistema',
            'name' => 'Admin Sistema',
            'email' => 'admin@zfp.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'position' => 'Administrador',
            'gender' => 'male', // ← AGREGAR ESTE CAMPO
            'active' => 1,
            'remember_token' => Str::random(10),
        ]);

        User::factory()->count(9)->create();
    }
}
