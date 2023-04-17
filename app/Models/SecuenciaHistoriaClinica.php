<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecuenciaHistoriaClinica extends Model
{
    use HasFactory;
    protected $table = 'secuencia_historia_clinica';
    protected $fillable = ['id',
                            'secuencia',
                            'year',
                            'created_at',
                            'updated_at'
                        ];

}
