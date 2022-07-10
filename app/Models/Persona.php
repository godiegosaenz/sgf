<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = ['id',
                            'cedula',
                            'apellidos',
                            'nombres',
                            'fechaNacimiento',
                            'estadoCivil',
                            'ocupacion',
                            'provincia',
                            'canton',
                            'ciudad',
                            'direccion',
                            'telefono',
                            'discapacidad',
                            'porcentaje',
                            'nota',
                            'rutaimagen',
                            'historiaClinica',
                            'created_at',
                            'updated_at'
                        ];
}
