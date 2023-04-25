<?php

namespace App\Http\Controllers\citas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Cita;
use App\Models\Citaservicios;
use App\Models\Servicios;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Datatables;
use Illuminate\Support\Facades\Gate;

class CitasController extends Controller
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
        if (! Gate::allows('listar-citas')) {
            abort(403);
        }
        return view('citas.cita');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('crear-citas')) {
            abort(403);
        }
        return view('citas.citaCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        if (! Gate::allows('crear-citas')) {
            abort(403);
        }
        $messages = [
            'especialista_id.required' => 'Seleccione a un especialista',
            'persona_id.required' => 'Seleccione a un paciente',
            'servicios.required' => 'Debe agregar al menos un servicio',
            'required' => 'El campo :attribute es requerido.',
            'unique' => 'El numero de cedula ingresado ya existe',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres',
            'max' => 'El campo :attribute no debe exceder los :max caracteres',
        ];

        $reglas = [
            'persona_id' => 'bail|required',
            'especialista_id' => 'bail|required',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required',
            'tipo_cita' => 'required',
            'servicios' => 'required'
        ];

        $validator = Validator::make($r->all(),$reglas,$messages);
        $checkservicios = $r->servicios;
        $variableservicios = "";
        if($validator->fails()) {
            if($r->servicios != null){
                for($i=0;$i<count($checkservicios);$i++){
                    $valor = Servicios::where('id',$checkservicios[$i])->get();
                    foreach($valor as $v){
                        $variableservicios .= "seleccionarservicio(";
                        $variableservicios .= $v->id.",";
                        $variableservicios .= "'".$v->nombre."',";
                        $variableservicios .= "'".$v->precio."',";
                        $variableservicios .= "'".$v->descuento."',";
                        $variableservicios .= "'".$v->importe."',";
                        $variableservicios .= "'".$v->iva."',";
                        $variableservicios .= "'".$v->retencion."',";
                        $variableservicios .= "'".$v->subtotal."');";
                    }
                }
            }
            return redirect('/cita/ingresar')
                        ->withErrors($validator)
                        ->withInput()
                        ->with('status', $variableservicios);
                        //->with('status','vine de la validacion');
        }

        DB::beginTransaction();
        try {

            $Cita = new Cita();
            $Cita->persona_id = $r->persona_id;
            $Cita->especialista_id = $r->especialista_id;
            $Cita->fecha = $r->fecha;
            $Cita->hora = $r->hora;
            $Cita->estado = 'pendiente';
            $Cita->motivo = $r->motivo;
            $Cita->tipo_cita = $r->tipo_cita;
            $Cita->save();


            for($i=0;$i<count($checkservicios);$i++){
                $Citaservicios = new Citaservicios();
                $Citaservicios->cita_id = $Cita->id;
                $Citaservicios->servicio_id = $checkservicios[$i];
                $Citaservicios->save();
            }
            DB::commit();

            return redirect('cita/'.$Cita->id.'/editar')->with('guardado','Cita agendada correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('cita/ingresar')->with('error',$e->getMessage().' Alerta: Ocurrio un error al procesar la informacion, intenta mas tarde o consulte al administrador de sistema');
        }
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
        if (! Gate::allows('editar-citas')) {
            abort(403);
        }
        $Cita = Cita::find($id);
        return view('citas.citaEdit',compact('Cita'));
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
        if (! Gate::allows('editar-citas')) {
            abort(403);
        }
        $messages = [
            'especialista_id.required' => 'Seleccione a un especialista',
            'persona_id.required' => 'Seleccione a un paciente',
            'servicios.required' => 'Debe agregar al menos un servicio',
            'required' => 'El campo :attribute es requerido.',
            'unique' => 'El numero de cedula ingresado ya existe',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres',
            'max' => 'El campo :attribute no debe exceder los :max caracteres',
        ];

        $reglas = [
            'persona_id' => 'bail|required',
            'especialista_id' => 'bail|required',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required',
            'tipo_cita' => 'required',
            'servicios' => 'required'
        ];
        //DB::beginTransaction();
        try {
        $validator = Validator::make($r->all(),$reglas,$messages);
        $checkservicios = $r->servicios;
        $variableservicios = "";
        if ($validator->fails()) {
            if($r->servicios != null){
                for($i=0;$i<count($checkservicios);$i++){
                    $valor = Servicios::where('id',$checkservicios[$i])->get();
                    foreach($valor as $v){
                        $variableservicios .= "seleccionarservicio(";
                        $variableservicios .= $v->id.",";
                        $variableservicios .= "'".$v->nombre."',";
                        $variableservicios .= "'".$v->precio."',";
                        $variableservicios .= "'".$v->descuento."',";
                        $variableservicios .= "'".$v->importe."',";
                        $variableservicios .= "'".$v->iva."',";
                        $variableservicios .= "'".$v->retencion."',";
                        $variableservicios .= "'".$v->subtotal."');";
                    }
                }
            }
            return redirect('/cita/'.$id.'/editar')
                        ->withErrors($validator)
                        ->withInput()
                        ->with('status', $variableservicios);
        }

            $Cita = Cita::find($id);
            $Cita->persona_id = $r->persona_id;
            $Cita->especialista_id = $r->especialista_id;
            $Cita->fecha = $r->fecha;
            $Cita->hora = $r->hora;
            $Cita->estado = 'pendiente';
            $Cita->motivo = $r->motivo;
            $Cita->tipo_cita = $r->tipo_cita;
            $Cita->save();

            $deleted = Citaservicios::where('cita_id', $id)->delete();

            for($i=0;$i<count($checkservicios);$i++){
                $Citaservicios = new Citaservicios();
                $Citaservicios->cita_id = $Cita->id;
                $Citaservicios->servicio_id = $checkservicios[$i];
                $Citaservicios->save();
            }
            //DB::commit();
            return redirect('cita/'.$Cita->id.'/editar')->with('guardado','La cita se actualizo correctamente');
        } catch (\Exception $e) {
            //DB::rollback();
            return redirect('cita/ingresar')->with('error','Ocurrio un error, intenta mas tarde');
        }
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
        $tipo_usuario = Auth()->user()->tipo_usuario;
        $idpersona = Auth()->user()->idpersona;
        if($tipo_usuario == 'especialista'){
            $Cita = Cita::where([
                'fecha' => $r->fecha,
                'especialista_id' => $idpersona,
            ])->get();
        }else{
            $Cita = Cita::where('fecha',$r->fecha)->get();
        }

        return Datatables($Cita)
                ->removeColumn('persona_id')
                ->removeColumn('especialista_id')
                ->addColumn('paciente', function ($Cita) {
                    return $Cita->persona->nombres.' '.$Cita->persona->apellidos;
                })
                ->addColumn('especialista', function($Cita){
                    return $Cita->especialista->personas->nombres.' '.$Cita->especialista->personas->apellidos;
                })
                ->addColumn('fechahora', function($Cita){
                    return $Cita->fecha.' '.$Cita->hora;
                })
                ->editColumn('estado', function($Cita){
                    if($Cita->estado == 'pendiente'){
                        return '<span class="badge rounded-pill bg-warning text-dark">Pendiente</span>';
                    }else if($Cita->estado == 'atendido'){
                        return '<span class="badge rounded-pill bg-success">Atendido</span>';
                    }else{
                        return '<span class="badge rounded-pill bg-danger">Cancelado</span>';
                    }

                })
                ->addColumn('action', function ($Cita) {
                    $botonesCita = '';
                    if($Cita->estado == 'pendiente'){
                        if(auth()->user()->tipo_usuario == 'especialista'){
                            $botonesCita .= '<a href="'.route('create.consulta',$Cita->id).'" class="btn btn-primary btn-sm"><i class="bi bi-check-circle-fill"></i> Atender</a> ';
                        }
                        $botonesCita .= '<a onclick="mostrarToasCancelarCita('.$Cita->id.')" class="btn btn-danger btn-sm"><i class="bi bi-x-circle-fill"></i> Cancelar</a> ';
                        $botonesCita .= '<a href="'.route('edit.cita',$Cita->id).'" class="btn btn-warning btn-sm"><i class="bi bi-check-circle-fill"></i> Editar</a> ';
                    }else if($Cita->estado == 'atendido'){
                        $botonesCita .= '<a href="'.route('index.pago',$Cita->id).'" class="btn btn-primary btn-sm"><i class="bi bi-receipt"></i> Procesar pago</a> ';
                        $botonesCita .= '<a href="'.route('ficha.citareporte',$Cita->id).'" class="btn btn-secondary btn-sm"><i class="bi bi-file-pdf"></i> reporte</a> ';
                    }else if($Cita->estado == 'completado'){
                        $botonesCita .= '<a href="'.route('index.pago',$Cita->id).'" class="btn btn-primary btn-sm"><i class="bi bi-receipt"></i> Generar recibo</a> ';
                        $botonesCita .= '<a href="'.route('ficha.citareporte',$Cita->id).'" class="btn btn-secondary btn-sm"><i class="bi bi-file-pdf"></i> reporte</a> ';
                    }
                    return $botonesCita;
                })
                ->rawColumns(['estado','action'])
                ->make(true);
    }

    public function cancel(Request $r){
        $Cita = Cita::find($r->id);
        $Cita->estado = 'cancelado';
        $Cita->save();
        $arrayRespuesta = array('respuesta' => true);
        echo json_encode($arrayRespuesta);
    }
}
