<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ===== CREAR PERMISOS =====
        // Inmuebles
        Permission::create(['name' => 'ver_inmuebles']);
        Permission::create(['name' => 'crear_inmuebles']);
        Permission::create(['name' => 'editar_inmuebles']);
        Permission::create(['name' => 'eliminar_inmuebles']);

        // Equipos
        Permission::create(['name' => 'ver_equipos']);
        Permission::create(['name' => 'crear_equipos']);
        Permission::create(['name' => 'editar_equipos']);
        Permission::create(['name' => 'eliminar_equipos']);

        // Mantenimientos
        Permission::create(['name' => 'ver_mantenimientos']);
        Permission::create(['name' => 'crear_mantenimientos']);
        Permission::create(['name' => 'editar_mantenimientos']);
        Permission::create(['name' => 'eliminar_mantenimientos']);

        // Garantías
        Permission::create(['name' => 'ver_garantias']);
        Permission::create(['name' => 'crear_garantias']);
        Permission::create(['name' => 'editar_garantias']);
        Permission::create(['name' => 'eliminar_garantias']);

        // Parametrización
        Permission::create(['name' => 'ver_parametrizacion']);
        Permission::create(['name' => 'editar_parametrizacion']);

        // Usuarios y roles
        Permission::create(['name' => 'ver_usuarios']);
        Permission::create(['name' => 'crear_usuarios']);
        Permission::create(['name' => 'editar_usuarios']);
        Permission::create(['name' => 'eliminar_usuarios']);
        Permission::create(['name' => 'asignar_roles']);

        // Dashboard
        Permission::create(['name' => 'ver_dashboard']);

        // ===== CREAR ROLES =====
        $roleAdmin = Role::create(['name' => 'Administrador']);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleOperador = Role::create(['name' => 'Operador']);
        $roleOperador->givePermissionTo([
            'ver_dashboard',
            'ver_inmuebles', 'crear_inmuebles', 'editar_inmuebles',
            'ver_equipos', 'crear_equipos', 'editar_equipos',
            'ver_mantenimientos', 'crear_mantenimientos', 'editar_mantenimientos',
            'ver_garantias', 'crear_garantias', 'editar_garantias',
        ]);

        $roleUsuario = Role::create(['name' => 'Usuario']);
        $roleUsuario->givePermissionTo([
            'ver_dashboard',
            'ver_inmuebles',
            'ver_equipos',
            'ver_mantenimientos',
            'ver_garantias',
        ]);

        // ===== ASIGNAR ROL ADMIN AL USUARIO POR DEFECTO =====
        $user = \App\Models\User::where('email', 'admin@zfp.com')->first();
        if ($user) {
            $user->assignRole('Administrador');
        }
    }
}