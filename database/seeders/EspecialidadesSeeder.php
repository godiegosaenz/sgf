<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia deportiva',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia geriatrica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia pediatrica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia neurologica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia comunitaria',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia en salud ocupacional y del trabajo',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia en ergonomia',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia plastica y estetica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia especializada en balneoterapia e hidroterapia',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia en cuidados paliativos',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia veterinaria',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia odontologica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia traumatologica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia oncologica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia ortopedica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia ginecologica, uroginecologica y obstetrica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia cardiovascular',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia respiratoria',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia en salud mental y psiquiatria',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia toricica',
        ]);
        DB::table('especialidades')->insert([
            'nombre' => 'Fisioterapia reumatologica',
        ]);
    }
}
