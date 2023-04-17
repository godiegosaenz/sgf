<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $fillable = ['id',
                            'cedula',
                            'apellidos',
                            'nombres',
                            'fechaNacimiento',
                            'estadoCivil',
                            'ocupacion',
                            'provincia',
                            'provincia_id',
                            'canton',
                            'canton_id',
                            'ciudad',
                            'direccion',
                            'telefono',
                            'correo',
                            'discapacidad',
                            'porcentaje',
                            'nota',
                            'rutaimagen',
                            'secuencia_historia_clinica',
                            'created_at',
                            'updated_at'
                        ];

    public function especialista(){
        return $this->belongsTo(Especialista::class,'persona_id', 'id');
    }

    public function cita(){
        return $this->hasMany(Cita::class,'persona_id');
    }

    public function getSecuenciaHistoriaClinicaAttribute($secuencia){
        return str_pad($secuencia, 4, "0", STR_PAD_LEFT);
    }
}
