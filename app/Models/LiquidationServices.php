<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiquidationServices extends Model
{
    use HasFactory;


    protected $table = 'liquidation_services';

    protected $fillable = ['id',
                            'servicios_id',
                            'liquidation_id',
                            'cantidad',
                            'precio',
                            'importe',
                            'iva',
                            'retencion',
                            'descuento',
                            'subtotal',
                            'status',
                            'created_at',
                            'updated_at'
                        ];
}
