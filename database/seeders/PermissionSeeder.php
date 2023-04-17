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
        Permission::create(['name' => 'ver usuarios']);

        Permission::create(['name' => 'Menu personas']);
        Permission::create(['name' => 'crear personas']);
        Permission::create(['name' => 'editar personas']);
        Permission::create(['name' => 'eliminar personas']);
        Permission::create(['name' => 'ver personas']);

        Permission::create(['name' => 'Menu citas']);
        Permission::create(['name' => 'crear citas']);
        Permission::create(['name' => 'editar citas']);
        Permission::create(['name' => 'eliminar citas']);
        Permission::create(['name' => 'ver citas']);

        Permission::create(['name' => 'Menu consultas']);
        Permission::create(['name' => 'crear consultas']);
        Permission::create(['name' => 'editar consulta']);
        Permission::create(['name' => 'eliminar consulta']);
        Permission::create(['name' => 'ver consulta']);

        Permission::create(['name' => 'Menu configuraciones']);
        Permission::create(['name' => 'ver roles']);
        Permission::create(['name' => 'Editar roles']);
        Permission::create(['name' => 'Crear roles']);


    }
}
