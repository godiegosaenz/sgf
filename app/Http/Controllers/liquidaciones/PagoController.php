<?php

namespace App\Http\Controllers\liquidaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Categoria;
use App\models\Cita;
use App\models\Liquidation;
use App\models\LiquidationSequence;
use App\models\LiquidationServices;
use Illuminate\Support\Facades\Validator;
use PDF;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
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
    public function index($id)
    {
        $Cita = Cita::find($id);
        $Liquidation = new Liquidation();
        $contadorLiquidacion = Liquidation::where('cita_id',$id)->count();
        if(Liquidation::where('cita_id',$id)->count() == 1){
            $Liquidation = Liquidation::where('cita_id',$id)->first();
        }
        return view('liquidaciones.pago',compact('Cita','Liquidation','contadorLiquidacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'inputValorCobrar' => 'bail|required',
            'cita_id' => 'bail|required',
        ];

        $validator = Validator::make($r->all(),$reglas,$messages);

        if ($validator->fails()) {
            return redirect('/pago/'.$r->cita_id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $Cita = Cita::find($r->cita_id);

        $Liquidation = new Liquidation();
        $Liquidation->total_payment = $r->inputValorCobrar;
        $Liquidation->cita_id = $r->cita_id;
        $Liquidation->type_liquidation_id = 1;
        $Liquidation->year = date('Y');
        if($Cita->persona->discapacidad == 'SI'){
            $Liquidation->status = 3; //PAGADO  - 2 SIN PAGAR - 3 EXONERADO - 4 ANULADO
        }else{
            $Liquidation->status = 1;
        }
        $Liquidation->username = Auth()->user()->email;
        //$Liquidation->voucher_number = $secuenciaLiquidacion;
        $Liquidation->save();


        foreach($Cita->servicios_citas as $c){
            $LiquidationServices = new LiquidationServices();
            $LiquidationServices->servicios_id = $c->id;

            $LiquidationServices->liquidation_id = $Liquidation->id;
            if($Cita->persona->discapacidad == 'SI'){

                $LiquidationServices->status = 3;
                $LiquidationServices->subtotal = 0.00;
                $LiquidationServices->precio = 0.00;
                $LiquidationServices->importe = 0.00;
                $LiquidationServices->iva = 0.00;
                $LiquidationServices->retencion = 0.00;
                $LiquidationServices->descuento = 0.00;
            }else{
                $LiquidationServices->status = 1;
                $LiquidationServices->subtotal = $c->subtotal;
                $LiquidationServices->precio = $c->precio;
                $LiquidationServices->importe = $c->importe;
                $LiquidationServices->iva = $c->iva;
                $LiquidationServices->retencion = $c->retencion;
                $LiquidationServices->descuento = $c->descuento;
            }
            $LiquidationServices->cantidad = 1;

            $LiquidationServices->save();

            //obtener maxima secuencia;
            $secuenciamaxima = LiquidationSequence::where('servicios_id', $LiquidationServices->servicios_id)->max('sequence');
            //$secuenciamaxima = LiquidationSequence::max('sequence');
            $secuenciaLiquidacion = $secuenciamaxima + 1;
            //registramos la secuencia nueva
            $LiquidationSequence = new LiquidationSequence();
            $LiquidationSequence->sequence = $secuenciaLiquidacion;
            $LiquidationSequence->year = date('Y');
            //$LiquidationSequence->type_liquidation_id = 1;
            $LiquidationSequence->servicios_id = $LiquidationServices->servicios_id;
            $LiquidationSequence->save();

            $affected = DB::table('liquidations')->where('id', $LiquidationServices->liquidation_id)->update(['voucher_number' => $LiquidationSequence->sequence]);
        }




        return redirect('pago/'.$r->cita_id)->with('guardado','Pago realizado con exito, descargue el comprobante');
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
        //
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

    public function recibo(Request $r, $id){
        $Cita = Cita::find($id);
        $Liquidation = Liquidation::where('cita_id',$id)->first();
        $data = [
            'title' => 'Rebibo',
            'date' => date('m/d/Y'),
            'Cita' => $Cita,
            'Liquidation' => $Liquidation
        ];


        $pdf = PDF::loadView('reportes.recibo', $data);

        return $pdf->download('recibo-'.$id.'.pdf');
    }
}
