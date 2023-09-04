<?php

namespace App\Http\Controllers\consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Especialista;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ConsultaController extends Controller
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
        return view('consultas.consulta');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $r,$id)
    {
        $Cita = Cita::find($id);
        return view('consultas.consultaCreate',compact('Cita'));
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

        $reglas = [
            'cita_id' => 'bail|required',
            'diagnostico' => 'bail|required',
            'tratamiento' => 'bail|required'
        ];

        $validator = Validator::make($r->all(),$reglas,$messages);

        if ($validator->fails()) {
            return redirect('/consulta/ingresar/'.$r->cita_id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $Consulta = new Consulta();
        $Consulta->diagnostico = $r->diagnostico;
        $Consulta->tratamiento = $r->tratamiento;
        $Consulta->cita_id = $r->cita_id;
        $Consulta->fecha = Carbon::now();
        $Consulta->hora = date("H:i:s");
        $Consulta->save();

        $Cita = Cita::find($r->cita_id);
        $Cita->estado = 'atendido';
        $Cita->save();
        return redirect('consulta/'.$Cita->id.'/editar')->with('guardado','Consulta registrada correctamente');

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
        $Cita = Cita::find($id);
        $Consulta = Consulta::find($id);
        return view('consultas.consultaEdit',compact('Cita','Consulta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        $messages = [
            'required' => 'El campo :attribute es requerido.',
            'unique' => 'El numero de cedula ingresado ya existe',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres',
            'max' => 'El campo :attribute no debe exceder los :max caracteres',
        ];

        $reglas = [
            'cita_id' => 'bail|required',
            'diagnostico' => 'bail|required',
            'tratamiento' => 'bail|required'
        ];

        $validator = Validator::make($r->all(),$reglas,$messages);

        if ($validator->fails()) {
            return redirect('/consulta/editar/'.$r->cita_id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $Consulta = Consulta::find($r->cita_id);
        $Consulta->diagnostico = $r->diagnostico;
        $Consulta->tratamiento = $r->tratamiento;
        $Consulta->fecha = Carbon::now();
        $Consulta->hora = date("H:i:s");
        $Consulta->save();

        $Cita = Cita::find($r->cita_id);
        $Cita->estado = 'atendido';
        $Cita->save();

        return back()->withInput()->with('guardado','Consulta actualizada con exito');

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
        $Consulta = Consulta::where('fecha',$r->fecha)->get();
        return Datatables($Consulta)
                ->removeColumn('persona_id')
                ->removeColumn('especialista_id')
                ->addColumn('paciente', function ($Consulta) {
                    return $Consulta->cita->persona->nombres.' '.$Consulta->cita->persona->apellidos;
                })
                ->addColumn('especialista', function($Consulta){
                    return $Consulta->cita->especialista->personas->nombres.' '.$Consulta->cita->especialista->personas->apellidos;
                })
                ->addColumn('fechahora', function($Consulta){
                    return $Consulta->fecha.' '.$Consulta->hora;
                })
                ->editColumn('estado', function($Consulta){
                    if($Consulta->cita->estado == 'pendiente'){
                        return '<span class="badge rounded-pill bg-warning text-dark">Pendiente</span>';
                    }else if($Consulta->cita->estado == 'atendido'){
                        return '<span class="badge rounded-pill bg-success">Atendido</span>';
                    }else{
                        return '<span class="badge rounded-pill bg-danger">Cancelado</span>';
                    }

                })
                ->addColumn('action', function ($Consulta) {
                    $botonesCita = '';
                    $botonesCita .= '<a href="'.route('ficha.citareporte',$Consulta->cita_id).'" class="btn btn-secondary btn-sm"><i class="bi bi-file-pdf"></i> reporte</a> ';
                    /*if($Consulta->estado == 'pendiente'){
                        $botonesCita .= '<a href="'.route('create.consulta',$Consulta->id).'" class="btn btn-primary btn-sm"><i class="bi bi-check-circle-fill"></i> Atender</a> ';
                        $botonesCita .= '<a onclick="mostrarToasCancelarCita('.$Consulta->id.')" class="btn btn-danger btn-sm"><i class="bi bi-x-circle-fill"></i> Cancelar</a> ';
                        $botonesCita .= '<a href="'.route('edit.cita',$Consulta->id).'" class="btn btn-warning btn-sm"><i class="bi bi-check-circle-fill"></i> Editar</a> ';
                    }else if($Consulta->estado == 'atendido'){
                        $botonesCita .= '<a href="'.route('index.pago',$Consulta->id).'" class="btn btn-primary btn-sm"><i class="bi bi-receipt"></i> Procesar pago</a> ';
                        $botonesCita .= '<a href="'.route('ficha.citareporte',$Consulta->id).'" class="btn btn-secondary btn-sm"><i class="bi bi-file-pdf"></i> reporte</a> ';
                    }else if($Consulta->estado == 'completado'){
                        $botonesCita .= '<a href="'.route('index.pago',$Consulta->id).'" class="btn btn-primary btn-sm"><i class="bi bi-receipt"></i> Generar recibo</a> ';
                        $botonesCita .= '<a href="'.route('ficha.citareporte',$Consulta->id).'" class="btn btn-secondary btn-sm"><i class="bi bi-file-pdf"></i> reporte</a> ';
                    }*/
                    return $botonesCita;
                })
                ->rawColumns(['estado','action'])
                ->make(true);
    }
}
