<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;

class HomeController extends Controller
{
    public function index(){
        $persona = Persona::all();
        $discapacitado = $persona->filter(function ($value, $key) {
            return $value->discapacidad == 'SI' ;
        });
        return view('home',['numpersona' => $persona->count(),'numdiscapacitados' => $discapacitado->count()]);
    }
}
