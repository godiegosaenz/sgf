<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Cita;

class HomeController extends Controller
{
    public function index(){
        $persona = Persona::all();
        $discapacitado = $persona->filter(function ($value, $key) {
            return $value->discapacidad == 'SI' ;
        });
        $citas = Cita::where('fecha',date('YY-mm-dd'))->get();
        return view('home',['numpersona' => $persona->count(),'numdiscapacitados' => $discapacitado->count(),'numcitas' => $citas->count()]);
    }
}
