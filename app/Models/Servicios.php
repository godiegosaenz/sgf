<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;

    protected $table = 'servicios';
    protected $fillable = ['id',
                            'nombre',
                            'descripcion',
                            'status',
                            'precio',
                            'importe',
                            'descuento',
                            'retencion',
                            'iva',
                            'especialidades_id',
                            'created_at',
                            'updated_at'
                        ];

    public function citas()
    {
        return $this->belongsToMany(Cita::class,'cita_servicios','servicio_id','cita_id')->withTimestamps();
    }

}
