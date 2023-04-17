<?php

namespace App\Http\Controllers\configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Servicios;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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

    public function list(Request $r){
        $servicios = Servicios::all();
        return Datatables($servicios)
        ->addColumn('action', function($servicios){
            $botones = '';
            $botones .= '<a onclick="seleccionarservicio('.$servicios->id.',\''.$servicios->nombre.'\','.$servicios->precio.','.$servicios->descuento.','.$servicios->importe.','.$servicios->iva.','.$servicios->retencion.','.$servicios->subtotal.')" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> agregar</a>';
            return $botones;
        })
        ->make(true);
    }
}
