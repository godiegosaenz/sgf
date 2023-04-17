<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidation extends Model
{
    use HasFactory;

    protected $table = 'liquidations';
    protected $fillable = ['id',
                            'voucher_number',
                            'total_payment',
                            'username',
                            'observation',
                            'year',
                            'type_liquidation_id',
                            'cita_id',
                            'created_at',
                            'updated_at'
                        ];

    public function liquidation_services(){
        return $this->belongsToMany(Servicios::class,'liquidation_services','liquidation_id','servicios_id')->withPivot('id','cantidad','precio','importe','iva','retencion','descuento','subtotal','status')->withTimestamps();
    }

    public function cita(){
        return $this->belongsTo(Cita::class, 'cita_id','id');
    }
}
