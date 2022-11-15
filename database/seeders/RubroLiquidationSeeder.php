<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RubroLiquidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rubros')->insert(['name' => 'CONSULTA DE FISIOTERAPIA','status' => true]);
        DB::table('rubros')->insert(['name' => 'TASA ADMINISTRATIVA','status' => true]);
    }
}
