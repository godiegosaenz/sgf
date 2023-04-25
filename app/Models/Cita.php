<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';
    protected $fillable = ['id',
                            'persona_id',
                            'especialista_id',
                            'especialidades_id',
                            'fecha',
                            'hora',
                            'estado',
                            'motivo',
                            'created_at',
                            'updated_at'
                        ];

    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id');
    }

    public function especialista(){
        return $this->belongsTo(User::class,'especialista_id','id');
    }

    public function consulta(){
        return $this->hasOne(Consulta::class,'cita_id');
    }

    public function liquidacion(){
        return $this->hasOne(Liquidation::class,'cita_id');
    }

    public function servicios_citas()
    {
        return $this->belongsToMany(Servicios::class,'cita_servicios','cita_id','servicio_id');
    }
}
