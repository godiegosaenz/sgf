<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citaservicios extends Model
{
    use HasFactory;

    protected $table = 'cita_servicios';

    protected $fillable = [
        'id',
        'cita_id',
        'servicio_id'
    ];
}
