<?php

namespace App\Http\Controllers\paciente;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\models\Persona;
use App\models\Archivo;
use App\models\Consulta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Gate;

class DetallarPacienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $r, $id){
        if (! Gate::allows('mostrar-persona')) {
            abort(403);
        }
        $persona = Persona::find($id);
        $archivo = Archivo::where('idpersona',$id)->get();
        //$archivo = Archivo::where('idpersona',$id)->get();
        return view('paciente.detallepaciente2',compact('persona','archivo'))->with('estado',$r->estado);
    }

    public function guardarFoto(Request $r){
        $ruta = $r->file('txtFoto')->store('public');
        $arregloRutas = explode('/',$ruta);
        $rutaparaimgen = 'storage/'.$arregloRutas[1];
        Persona::where('id',$r->idpersona)->update(['rutaimagen' => $rutaparaimgen]);
        return redirect('/api/paciente/detallar/'.$r->idpersona);
    }

    public function guardarArchivo(Request $r){
        $messages = [
            'required' => 'El campo :attribute es requerido.',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres',
            'max' => 'El campo :attribute no debe exceder los :max caracteres',
        ];
        $reglas = [
            'nombres' => 'bail|required|max:25',
            'txtArchivo' => ['required',File::types(['pdf'])]
        ];
        $validator = Validator::make($r->all(),$reglas,$messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                                    ->withInput()
                                    ->with('success', 'your message,here');
            /*return redirect('/paciente//editar')
                        ->withErrors($validator)
                        ->withInput();*/
        }
        $ruta = $r->file('txtArchivo')->store('public');
        $arregloRutas = explode('/',$ruta);
        $rutaparaimgen = 'storage/'.$arregloRutas[1];
        $archivo = new Archivo;
        $archivo->nombreArchivo = $r->nombres;
        $archivo->rutaArchivo = $rutaparaimgen;
        $archivo->idpersona = $r->idpersona;
        $archivo->save();
        return redirect('paciente/editar/'.$r->idpersona);
    }

    public function actualizar(Request $r){
        $idpersona = $r->idpersona;
        $datosParaComparar = Persona::find($idpersona);

        $messages = [
            'required' => 'El campo :attribute es requerido.',
            'cedula.unique' => 'El numero de cedula ingresado ya existe',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres',
            'max' => 'El campo :attribute no debe exceder los :max caracteres',
        ];

        if($r->txtCedula == $datosParaComparar->cedula){
            $reglas = [
                'txtNombres' => 'bail|required|max:250',
                'txtApellidos' => 'bail|required|max:250',
                'txtFechaNacimiento' => 'required',
                'selEstadoCivil' => 'required',
                'txtOcupacion' => 'required',

                'ciudad' => 'max|60',
                'direccion' => '',
                'txttelefono' => 'max:12',
                'selDiscapacidad' => 'required',
                'txtPorcentaje' => 'max:3',
                'txtNota' => '',
                'txtHistoriaClinica' => 'required|max:6'
            ];
            if($r->selDiscapacidad == 'SI'){
                $reglas['txtPorcentaje'] = 'required|max:3';
            }
        }else{
            $reglas = [
                'txtCedula' => 'bail|required|size:10|unique:personas,cedula',
                'txtNombres' => 'bail|required|max:250',
                'txtApellidos' => 'bail|required|max:250',
                'txtFechaNacimiento' => 'required',
                'selEstadoCivil' => 'required',
                'txtOcupacion' => 'required',

                'ciudad' => 'max|60',
                'direccion' => '',
                'txttelefono' => 'max:12',
                'selDiscapacidad' => 'required',
                'txtPorcentaje' => 'max:3',
                'txtNota' => '',

                'txtHistoriaClinica' => 'required|max:6'
            ];
        }



        $validator = Validator::make($r->all(), $reglas,$messages);//->validate();

        if ($validator->fails()) {
            return redirect('/api/paciente/detallar/'.$idpersona)
                        ->withErrors($validator)
                        ->withInput();
        }

        $personas = array(
            'cedula' => $r->txtCedula,
            'nombres' => $r->txtNombres,
            'apellidos' => $r->txtApellidos,
            'fechaNacimiento' => $r->txtFechaNacimiento,
            'estadoCivil' => $r->selEstadoCivil,
            'ocupacion' => $r->txtOcupacion,

            'ciudad' => $r->txtCiudad,
            'direccion' => $r->txtDireccion,
            'telefono' => $r->txttelefono,
            'discapacidad' => $r->selDiscapacidad,
            'porcentaje' => $r->txtPorcentaje,
            'nota' => $r->txtNota,
            'historiaClinica' => $r->txtHistoriaClinica
        );


        /*$personas->historiaClinica = $r->txtHistoriaClinica;*/
        DB::table('personas')->where('id', $idpersona)->update($personas);

        return redirect()->route('detallar.persona', ['id' => $idpersona])->with('estado','actualizado');

    }

    public function descargar($id)
    {
        $Archivo = Archivo::find($id);
        $rutaArchivo = public_path($Archivo->rutaArchivo);
        return response()->download($rutaArchivo);
    }
}
