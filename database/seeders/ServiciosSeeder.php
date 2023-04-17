<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servicios')->insert(['nombre' => 'SERVICIOS DE CARACTER SOCIAL C',
                                        'status' => true,
                                        'precio' => 1,
                                        'importe' => 1,
                                        'retencion' => 0,
                                        'descuento' => 0,
                                        'iva' => 0,
                                        'subtotal' => 1,
                                        //'especialidades_id' => 1,
                                        ]);

        DB::table('servicios')->insert(['nombre' => 'SERVICIOS DE CARACTER SOCIAL D',
                                        'status' => true,
                                        'precio' => 1.50,
                                        'importe' => 1.50,
                                        'retencion' => 0,
                                        'descuento' => 0,
                                        'iva' => 0,
                                        'subtotal' => 1.50,
                                        //'especialidades_id' => 1,
                                        ]);
    }
}
