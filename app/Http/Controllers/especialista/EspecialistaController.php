<?php

namespace App\Http\Controllers\especialista;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use App\Models\Provincia;
use App\Models\Persona;
use App\Models\Archivo;
use App\Models\Especialidades;
use App\Models\Canton;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


class EspecialistaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('especialista.especialista');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $r)
    {
        $Especialidades = Especialidades::all();
        $provincias = Provincia::all();
        $cantones = new Canton();
        if(Cookie::get('provincia_id') !== null){
            $cantones = Canton::where('id_provincia',Cookie::get('provincia_id'))->get();
        }

        Cookie::queue('provincia_id', '');
        return view('especialista.especialistaCreate',compact('provincias','cantones','Especialidades'))->with('estado',$r->estado);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $messages = [
            'required' => 'El campo :attribute es requerido.',
            'unique' => 'El numero de cedula ingresado ya existe',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres',
            'max' => 'El campo :attribute no debe exceder los :max caracteres',
        ];
        if($r->discapacidad == 'NO'){

            $reglas = [
                    'cedula' => 'bail|required|size:10|unique:personas,cedula',
                    'nombres' => 'bail|required|max:250',
                    'apellidos' => 'bail|required|max:250',
                    'fechaNacimiento' => 'required',
                    'estadoCivil' => 'required',
                    'ocupacion' => 'required',
                    'provincia_id' => 'required',
                    'canton_id' => 'required',
                    'ciudad' => 'max:60',
                    'direccion' => '',
                    'telefono' => 'max:12',
                    'discapacidad' => 'required',
                    'porcentaje' => 'max:3',
                    'nota' => '',
                    'password' => ['required', 'confirmed', Password::min(8)],
                    'estado' => 'required',
                    'titulo' => 'required',
                    'especialidad' => 'required',
                    'email' => 'required',
                ];
        }else{

            $reglas = [
                'cedula' => 'bail|required|size:10|unique:personas,cedula',
                'nombres' => 'bail|required|max:250',
                'apellidos' => 'bail|required|max:250',
                'fechaNacimiento' => 'required',
                'estadoCivil' => 'required',
                'ocupacion' => 'required',
                'provincia_id' => 'required',
                'canton_id' => 'required',
                'ciudad' => 'max:60',
                'direccion' => '',
                'telefono' => 'max:12',
                'discapacidad' => 'required',
                'porcentaje' => 'required|max:3',
                'nota' => '',
                'password' => ['required', 'confirmed', Password::min(8)],
                'estado' => 'required',
                'titulo' => 'required',
                'especialidad' => 'required',
                'email' => 'required',
                //'txtFoto' => 'required',
            ];
        }


        Cookie::queue('provincia_id', '');

        $validator = Validator::make($r->all(),$reglas,$messages);

        $validator->after(function ($validator) {

            /*$contador = count($validator->errors());
            if(intval($contador) > 1){
                $validator->errors()->add('selCanton', 'El campo Canton es requerido');
            }*/
        });
        if ($validator->fails()) {
            if($r->provincia_id > 0 ){
                Cookie::queue('provincia_id', $r->provincia_id);
            }
            /*return redirect()->back()->withErrors($validator)
                                    ->withInput()
                                    ->with('success', 'your message,here');*/
            return redirect('/especialista/ingresar')
                        ->withErrors($validator)
                        ->withInput();
        }

        if($r->file('txtFoto') != ''){
            $ruta = $r->file('txtFoto')->store('public');
            $arregloRutas = explode('/',$ruta);
            $rutaparaimgen = 'storage/'.$arregloRutas[1];
        }
        $secuencia = 1;
        $obtenermaximasecuencia = DB::table('secuencia_historia_clinica')->max('secuencia');
        if($obtenermaximasecuencia != null){
            $secuencia = $obtenermaximasecuencia + 1;
            DB::table('secuencia_historia_clinica')->insert([
                'secuencia' => $secuencia,
                'year' => date("Y")
            ]);
        }else{
            DB::table('secuencia_historia_clinica')->insert([
                'secuencia' => $secuencia,
                'year' => date("Y")
            ]);
        }

        $cedula = $r->cedula;
        $personas = new Persona;
        $personas->cedula = $r->cedula;
        $personas->nombres = $r->nombres;
        $personas->apellidos = $r->apellidos;
        $personas->fechaNacimiento = $r->fechaNacimiento;
        $personas->estadoCivil = $r->estadoCivil;
        $personas->ocupacion = $r->ocupacion;
        $provincia = Provincia::find($r->provincia_id);
        $personas->provincia = $provincia->nombre;
        $personas->provincia_id = $r->provincia_id;
        $canton = Canton::find($r->canton_id);
        $personas->canton = $canton->nombre;
        $personas->canton_id = $r->canton_id;
        $personas->ciudad = $r->ciudad;
        $personas->direccion = $r->direccion;
        $personas->telefono = $r->telefono;
        $personas->correo = $r->email;
        $personas->discapacidad = $r->discapacidad;
        $personas->porcentaje = $r->porcentaje;
        $personas->nota = $r->nota;
        $personas->secuencia_historia_clinica = $secuencia;

        if($r->file('txtFoto') != ''){
            $personas->rutaimagen = $rutaparaimgen;
        }

        $personas->save();

        $User= new User();
        $User->name = $personas->nombres;
        $User->email = $r->email;
        $User->idpersona = $personas->id;
        $User->especialidades_id = $r->especialidad;
        $User->tipo_usuario = 'especialista';
        $User->titulo = $r->titulo;
        $User->estado = $r->estado;
        $User->password = bcrypt($r->password);
        $User->save();

        return redirect('especialista/'.$User->id.'/editar');
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
        $Especialidades = Especialidades::all();
        $Especialista = User::find($id);
        $provincias = Provincia::all();
        $cantones = Canton::where('id_provincia',$Especialista->personas->provincia_id)->get();
        $archivo = Archivo::where('idpersona',$Especialista->idpersona)->get();
        Cookie::queue('provincia_id', '');
        return view('especialista.especialistaEdit2',compact('provincias','cantones','Especialidades','Especialista','archivo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

        if($r->panel == 'especialista'){
            $especialista = User::where(['tipo_usuario' => 'especialista'])->get();
            return Datatables($especialista)
            ->addColumn('nombres', function($especialista){
                return $especialista->personas->nombres;
            })
            ->addColumn('apellidos', function($especialista){
                return $especialista->personas->apellidos;
            })
            ->addColumn('cedula', function($especialista){
                return $especialista->personas->cedula;
            })
            ->addColumn('especialidad', function($especialista){
                return $especialista->especialidad->nombre;
            })
            ->addColumn('estado', function($especialista){
                if($especialista->estado == true){
                    return '<span class="badge rounded-pill bg-success text-dark">Activo</span>';
                }else{
                    return '<span class="badge rounded-pill bg-danger">Inactivo</span>';
                }
            })
            ->addColumn('action', function ($especialista) {
                $button = '';
                $button .= '<a class="btn btn-primary btn-sm" href="'.route('detallar.especialista',$especialista->id).'">Ver</a> ';
                $button .= '<a class="btn btn-warning btn-sm" href="'.route('edit.especialista',$especialista->id).'">Editar</a>';
                return $button;
            })
            ->rawColumns(['estado','action'])
            ->make(true);
        }else{
            $especialista = User::where(['tipo_usuario' => 'especialista','estado' => true])->get();
            return Datatables($especialista)
            ->addColumn('nombres', function($especialista){
                return $especialista->personas->nombres;
            })
            ->addColumn('apellidos', function($especialista){
                return $especialista->personas->apellidos;
            })
            ->addColumn('cedula', function($especialista){
                return $especialista->personas->cedula;
            })
            ->addColumn('especialidad', function($especialista){
                return $especialista->especialidad->nombre;
            })
            ->addColumn('action', function ($especialista) {
                return '<a class="btn btn-primary btn-sm" onclick="seleccionarespecialista(\''.$especialista->personas->id.'\',\''.$especialista->personas->cedula.'\',\''.$especialista->personas->nombres.'\',\''.$especialista->personas->apellidos.'\')">Seleccionar</a>';
            })
            ->make(true);
        }

    }
}
