<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RubroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rubros')->insert(['name' => 'SERVICIOS DE CARACTER SOCIAL','status' => true]);
        DB::table('rubros')->insert(['name' => 'TASA ADMINISTRATIVA','status' => true]);
    }
}
