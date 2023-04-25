<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Especialidades;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('listar-usuarios')) {
            abort(403);
        }
        return view('usuarios.usuarios');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('crear-usuarios')) {
            abort(403);
        }
        $Especialidades = Especialidades::all();
        $Role = Role::all();
        return view('usuarios.usuariosCreate',compact('Role','Especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        if (! Gate::allows('crear-usuarios')) {
            abort(403);
        }
        $messages = [
            'required' => 'El campo es requerido.',
            'unique' => 'El :attribute ya existe',
            'idpersona.unique' => 'Ya existe un usuario con la persona seleccionada',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres',
            'max' => 'El campo :attribute no debe exceder los :max caracteres',
        ];

        if($r->tipo_usuario == 'especialista'){
            $reglas = [
                'email' => ['bail','required','email','unique:users,email'],
                'name' => 'bail|required|max:250',
                'idpersona' => 'bail|required|unique:users,idpersona',
                'password' => ['required', 'confirmed', Password::min(8)],
                'especialidad' => 'required',
                'estado' => 'required',
                'titulo' => 'required',
                'tipo_usuario' => 'required',
            ];
        }else{
            $reglas = [
                'email' => ['bail','required','email','unique:users,email'],
                'name' => 'bail|required|max:250',
                'idpersona' => 'bail|required|unique:users,idpersona',
                'password' => ['required', 'confirmed', Password::min(8)],
                'estado' => 'required',
                'titulo' => 'required',
                'tipo_usuario' => 'required',
            ];
        }


        $validator = Validator::make($r->all(),$reglas,$messages);

        $validator->after(function ($validator) {

        });
        if ($validator->fails()) {
            return redirect('/usuario/crear/')
                        ->withErrors($validator)
                        ->withInput();
        }

        $User= new User();
        $User->name = $r->name;
        $User->email = $r->email;
        $User->idpersona = $r->idpersona;
        $User->estado = $r->estado;
        $User->titulo = $r->titulo;
        $User->tipo_usuario = $r->tipo_usuario;
        $User->especialidades_id = $r->especialidad;
        $User->password = bcrypt($r->password);
        $User->save();

        return redirect('usuario/'.$User->id.'/editar')->with('guardado','Usuario registrado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('editar-usuarios')) {
            abort(403);
        }
        $User = User::find($id);
        $Role = Role::all();
        $Especialidades = Especialidades::all();
        return view('usuarios.usuariosEdit',compact('Role','User','Especialidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        if (! Gate::allows('editar-usuarios')) {
            abort(403);
        }
        $messages = [
            'required' => 'El campo es requerido.',
            'unique' => 'El :attribute ya existe',
            'idpersona.unique' => 'Ya existe un usuario con la persona seleccionada',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres',
            'max' => 'El campo :attribute no debe exceder los :max caracteres',
        ];

        if($r->tipo_usuario == 'especialista'){
            $reglas = [
                'email' => ['bail','required','email',Rule::unique('users')->ignore($id)],
                'name' => 'bail|required|max:250',
                'idpersona' => ['bail','required',Rule::unique('users')->ignore($id)],
                'password' => ['required', 'confirmed', Password::min(8)],
                'especialidad' => 'required',
                'estado' => 'required',
                'titulo' => 'required',
                'tipo_usuario' => 'required',
            ];
        }else{
            $reglas = [
                'email' => ['bail','required','email',Rule::unique('users')->ignore($id)],
                'name' => 'bail|required|max:250',
                'idpersona' => ['bail','required',Rule::unique('users')->ignore($id)],
                'password' => ['required', 'confirmed', Password::min(8)],
                'estado' => 'required',
                'titulo' => 'required',
                'tipo_usuario' => 'required',
            ];
        }

        $validator = Validator::make($r->all(),$reglas,$messages);

        $validator->after(function ($validator) {

        });
        if ($validator->fails()) {
            return redirect('/usuario/'.$id.'/editar/')
                        ->withErrors($validator)
                        ->withInput();
        }

        $User= User::find($id);
        $User->name = $r->name;
        $User->email = $r->email;
        $User->idpersona = $r->idpersona;
        $User->estado = $r->estado;
        $User->titulo = $r->titulo;
        $User->tipo_usuario = $r->tipo_usuario;
        $User->especialidades_id = $r->especialidad;
        $User->password = bcrypt($r->password);
        $User->save();

        return redirect('usuario/'.$User->id.'/editar')->with('guardado','Usuario registrado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list(Request $r){
        if($r->ajax()){
            $listausuario = User::all();
               return Datatables($listausuario)
               ->addColumn('action', function ($listausuario) {
                   $buttonPersona = '';
                   $buttonPersona .= '<a class="btn btn-primary btn-sm" href="'.route('detallar.persona',$listausuario->id).'">Ver</a> ';
                   $buttonPersona .= '<a class="btn btn-warning btn-sm" href="'.route('edit.usuario',$listausuario->id).'">Editar</a>';
                   return $buttonPersona;

               })
               ->addColumn('roles', function ($listausuario) {
                    $roles = $listausuario->getRoleNames();
                    return $roles;
               })
               ->rawColumns(['action'])
               ->make(true);
           }

    }
}
