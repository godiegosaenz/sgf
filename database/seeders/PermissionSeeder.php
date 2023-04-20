<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create(['name' => 'Menu usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'mostrar usuarios']);
        Permission::create(['name' => 'listar usuarios']);

        Permission::create(['name' => 'Menu personas']);
        Permission::create(['name' => 'crear personas']);
        Permission::create(['name' => 'editar personas']);
        Permission::create(['name' => 'mostrar personas']);
        Permission::create(['name' => 'listar personas']);

        Permission::create(['name' => 'Menu citas']);
        Permission::create(['name' => 'crear citas']);
        Permission::create(['name' => 'editar citas']);
        Permission::create(['name' => 'mostrar citas']);
        Permission::create(['name' => 'listar citas']);
        Permission::create(['name' => 'eliminar citas']);

        Permission::create(['name' => 'Menu consultas']);
        Permission::create(['name' => 'crear consultas']);
        Permission::create(['name' => 'editar consultas']);
        Permission::create(['name' => 'mostrar consultas']);
        Permission::create(['name' => 'listar consultas']);
        Permission::create(['name' => 'eliminar consultas']);

        Permission::create(['name' => 'Menu especialistas']);
        Permission::create(['name' => 'crear especialistas']);
        Permission::create(['name' => 'editar especialistas']);
        Permission::create(['name' => 'mostrar especialistas']);
        Permission::create(['name' => 'listar especialistas']);
        Permission::create(['name' => 'eliminar especialistas']);

        Permission::create(['name' => 'Menu configuraciones']);
        Permission::create(['name' => 'listar roles']);
        Permission::create(['name' => 'Editar roles']);
        Permission::create(['name' => 'Crear roles']);
        Permission::create(['name' => 'mostrar roles']);
        Permission::create(['name' => 'asignar roles']);

        Permission::create(['name' => 'Menu servicios']);
        Permission::create(['name' => 'listar servicios']);
        Permission::create(['name' => 'mostrar servicios']);
        Permission::create(['name' => 'crear servicios']);
        Permission::create(['name' => 'editar servicios']);
        Permission::create(['name' => 'eliminar servicios']);


    }
}
