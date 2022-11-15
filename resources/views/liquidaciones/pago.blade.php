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

        <br>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Detalle de pago por consulta</h5>
                      <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>

                      <table class="table table-bordered">
                        <tr>
                            <td>Paciente: </td>
                            <td>Diego Andres Bermudez Saenz</td>
                        </tr>
                        <tr>
                            <td>Fecha:</td>
                            <td>2022-11-12</td>
                        </tr>
                      </table>
                      <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td colspan="2">Detalle de cobro</td>
                                </tr>
                                <tr>
                                    <th>Rubro</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Consulta de fisioterapia</td>
                                    <td>$ 1.50</td>
                                </tr>
                                <tr>
                                    <td>TOTAL</td>
                                    <td>$ 1.50</td>
                                </tr>
                            </tbody>
                      </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Procesar pago</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="diagnostico">* Categoria : </label>
                                    <select class="form-select" aria-label="Default select example" id="categoria_id" name="categoria_id">
                                        <option selected>Seleccione categoria</option>
                                        @isset($Categoria)
                                            @foreach ($Categoria as $c)
                                                <option value="{{$c->id}}">{{$c->nombre}}</option>
                                            @endforeach
                                        @endisset
                                      </select>
                                </div>
                                <div class="mb-3">
                                    <label for="diagnostico">* Valor recibido : </label>
                                    <input type="text" class="form-control" id="inputValorRecibido" name="inputValorRecibido" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="diagnostico">* Valor a cobrar : </label>
                                    <input type="text" class="form-control" id="inputValorCobrar" name="inputValorCobrar" value="0.00">
                                </div>
                                <div class="mb-3">
                                    <label for="diagnostico">* Cambio : </label>
                                    <input type="text" class="form-control" id="inputCambio" name="inputCambio" value="0.00">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mb-3"><i class="bi bi-wallet"></i> Procesar</button>
                                    <button type="submit" class="btn btn-primary mb-3" disabled><i class="bi bi-receipt"></i> Generar recibo</button>
                                </div>

                            </div>
                            <div class="col-6">
                                <p class="fs-1">TOTAL A PAGAR</p>
                                <h1><span class="badge bg-secondary" id="spanValor">$ 0.00</span></h1>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    var inputValorRecibido = document.getElementById('inputValorRecibido');
    var inputValorCobrar = document.getElementById('inputValorCobrar');
    var inputCambio = document.getElementById('inputCambio');
    var resultado = 0;
    let token = "{{csrf_token()}}";

    inputValorRecibido.addEventListener('keyup', function() {
        if (event.keyCode === 13) {
            resultado = inputValorRecibido.value - inputValorCobrar.value;
            inputCambio.value = resultado;
        }
    });
    inputValorCobrar.addEventListener('keyup', function() {
        if (event.keyCode === 13) {
            resultado = inputValorRecibido.value - inputValorCobrar.value;
            inputCambio.value = resultado;
        }
    });

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
