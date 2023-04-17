<?php

namespace App\Http\Controllers\usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Persona;

class DetallarUsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $r, $id,$id2){
        $usuario = User::find($id);
        $persona = Persona::find($id2);

        return view('auth.detallar',['usuario' => $usuario, 'persona' => $persona]);
    }

    public function show(Request $r, $id){
        $User = User::find($id);
        return view('usuarios.perfil',compact('User'));
    }
}
