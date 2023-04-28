@extends('layouts.app')
@section('title', 'Procesar pago')
@push('styles')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <h2 class="text-center">Procesar pago </h2>
                </div>
            </div>
        </div>

        @if ($contadorLiquidacion == 1)
        <div class="row justify-content-md-center">
            <div class="col-8">
                <div class="alert alert-info" role="alert">
                    El pago de la consulta ya fue realizado
                </div>
            </div>
        </div>
        @endif
        <br>
        <div class="row justify-content-md-center">
            <div class="col-8">
                @if(session('guardado'))
                    <div class="alert alert-success" role="alert">
                        {{session('guardado')}}
                    </div>
                @endif
            </div>

            @if(session('guardado') || $contadorLiquidacion == 1)
                <div class="col-5">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">

                                    <table>
                                        <tr>
                                            <td><img src="{{asset('img/logogadmsv.jpg')}}" alt="" sizes="" srcset="" height="100px"></td>
                                            <td>
                                                <table style="text-align: center;margin-rigth:20px">
                                                    <tr>
                                                        <td><strong>GAD MUNICIPAL DEL CANTÓN SAN VICENTE</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>DIRECCIÓN FINANCIERA</td>
                                                    </tr>
                                                    <tr>
                                                        <td>COMPROBANTE DE RECAUDACIÓN</td>
                                                    </tr>
                                                    <tr style="border:solid 1px;border-color:#DEDEDE;">
                                                        <td>UNIDAD DE FISIOTERAPIA MUNICIPAL</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="text-align:right;">
                                                <table style="text-align:right;margin-left:20px">
                                                    <tr>
                                                        <td><img src="{{asset('img/logo.png')}}" alt="" sizes="" srcset="" height="60px"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color:#D31515;">N°: {{str_pad($Liquidation->voucher_number, 6, '0', STR_PAD_LEFT);}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" style="text-align: center"><strong></strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-8">
                                    <table style="width: 570px;font-size:14px;" >
                                        @foreach ($Liquidation->liquidation_services as $lr)
                                            <tr>
                                                <td>{{$lr->nombre}}</td>
                                                <td style="width:50px;">Tarifa</td>
                                                <td style="width:70px;background-color: #{{$lr->descripcion}}">{{$lr->pivot->subtotal}}</td>
                                            </tr>
                                        @endforeach

                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">

                                    <table style="width: 500px;font-size:14px;">
                                        <tr>
                                            <th >Usuario:</th>
                                            <td style="text-align: left;">{{$Cita->persona->nombres.' '.$Cita->persona->apellidos}}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <table class="mt-5" width="100%">
                                        <tr>
                                            <td style="width: 50%">________________________</td>
                                            <td style="width: 50%">________________________</td>
                                        </tr>
                                        <tr>
                                            <td>Analista de renta Mcpal</td>
                                            <td>Unidad de Fisioterapia</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-8 mt-3">
                    <a target="_blank" href="{{route('recibo.pago',$Cita->id)}}" class="btn btn-secondary mb-3" disabled><i class="bi bi-receipt"></i> Generar recibo</a>
                </div>
            @else
            <div class="col-12">
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Procesar pago</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                                <form action="{{route('store.pago')}}" method="post" id="formPago">
                                    @csrf
                                    <input type="hidden" name="cita_id" value="{{$Cita->id}}">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="mb-3">
                                                <label for="diagnostico">* Valor recibido : </label>
                                                <input type="text" class="form-control" id="inputValorRecibido" name="inputValorRecibido" value="" onkeyup="calcularCambio()">
                                            </div>
                                            <div class="mb-3">
                                                <label for="diagnostico">* Valor a cobrar : </label>
                                                <input type="text" class="form-control" id="inputValorCobrar" name="inputValorCobrar" value="{{number_format($Cita->servicios_citas->sum('subtotal'), 2);}}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="diagnostico">* Cambio : </label>
                                                <input type="text" class="form-control" id="inputCambio" name="inputCambio" value="0.00">
                                            </div>
                                            <div class="mb-3">
                                                <button type="button" id="btnProcesarPago" class="btn btn-primary mb-3"><i class="bi bi-wallet"></i> Procesar</button>

                                            </div>

                                        </div>
                                        <div class="col-5">
                                            <p class="fs-3">TOTAL A PAGAR</p>
                                            <h1><span class="badge bg-primary" id="spanValor">$ {{number_format($Cita->servicios_citas->sum('subtotal'), 2);}}</span></h1>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Accion</th>
                                    <th>Unidad</th>
                                    <th style="width: 40%">Concepto</th>
                                    <th>Precio Uni</th>
                                    <th>Desc (%)</th>
                                    <th>Base ($)</th>
                                    <th>Iva (%)</th>
                                    <th>Ret (%)</th>
                                    <th>Subtotal ($)</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyservicios">
                                @foreach ($Cita->servicios_citas as $cs)
                                    <tr>
                                        <td>
                                        </td>
                                        <td>1</td>
                                        <td>{{$cs->nombre}}</td>
                                        <td>{{$cs->precio}}</td>
                                        <td>{{$cs->descuento}}</td>
                                        <td>{{$cs->importe}}</td>
                                        <td>{{$cs->iva}}</td>
                                        <td>{{$cs->retencion}}</td>
                                        <td>{{$cs->subtotal}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5"></td>
                                    <td id="tdBase"><strong> TOTAL BASE ($) {{number_format($Cita->servicios_citas->sum('importe'), 2);}}</strong> </td>
                                    <td id="tdIva"><strong> TOTAL IVA ($) {{number_format($Cita->servicios_citas->sum('iva'), 2);}}</strong> </td>
                                    <td></td>
                                    <td id="tdTotal"><strong> TOTAL ($) {{number_format($Cita->servicios_citas->sum('subtotal'), 2);}}</strong> </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
            @endif
        </div>
    </div>
@endsection
@push('scripts')
<script>
    var inputValorRecibido = document.getElementById('inputValorRecibido');
    var inputValorCobrar = document.getElementById('inputValorCobrar');
    var inputCambio = document.getElementById('inputCambio');
    var btnProcesarPago = document.getElementById('btnProcesarPago');

    var resultado = 0;
    let token = "{{csrf_token()}}";

    btnProcesarPago.addEventListener('click', function() {
        var formPago = document.getElementById('formPago').submit();
    });
    /*inputValorCobrar.addEventListener('keyup', function() {
        alert('hola');
        if (event.keyCode === 13) {
            resultado = inputValorRecibido.value - inputValorCobrar.value;
            inputCambio.value = resultado;
        }
    });*/

    function calcularCambio(){
        if (event.keyCode === 13) {
            resultado = inputValorRecibido.value - inputValorCobrar.value;
            inputCambio.value = resultado;
        }
    }

    var categoria_id = document.getElementById('categoria_id');
    categoria_id.addEventListener('change', function() {
        var selectedOption = this.options[categoria_id.selectedIndex];
        var spanValor = document.getElementById('spanValor');
        axios.post('{{route('obtener.categoria')}}',{
            id: categoria_id.value,
            _token: token
        }).then(function(res) {
            if(res.status==200) {
                if(res.data.respuesta == true){
                    spanValor.innerHTML = '$ '+res.data.valor;
                    inputValorCobrar.value = res.data.valor;
                }
            }
        }).catch(function(err) {
            if(err.response.status == 500){
                toastr.error('Error al comunicarse con el servidor, contacte al administrador de Sistemas');
                console.log('error al consultar al servidor');
            }

            if(err.response.status == 419){
                toastr.error('Es posible que tu session haya caducado, vuelve a iniciar sesion');
                console.log('Es posible que tu session haya caducado, vuelve a iniciar sesion');
            }
        }).then(function() {

        });
    });
</script>
@endpush
