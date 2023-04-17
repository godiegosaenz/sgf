<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;
    protected $table = 'consultas';
    protected $fillable = [ 'cita_id',
                            'diagnostico',
                            'tratamiento',
                            'created_at',
                            'updated_at'
                        ];
    protected $primaryKey = 'cita_id';
    public function cita(){
        return $this->belongsTo(Cita::class, 'cita_id','id');
    }
}
