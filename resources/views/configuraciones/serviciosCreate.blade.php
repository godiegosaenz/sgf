@extends('layouts.app')
@section('title', 'Crear Servicios')
@push('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.bootstrap5.min.css">
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">

            <div class="col-md-11">
                <div class="row mb-1">
                    <h2>Crear Servicios</h2>
                </div>
                <form action="{{ route('store.servicios') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">

                            <div class="alert alert-info alert-dismissible">
                                <div>
                                    <h5><i class="bi-info-circle"></i> Recuerda!</h5>
                                    Todos los campos con un asterisco al final. Son campos obligatorios.
                                </div>
                            </div>
                            @if(session('guardado'))
                                <div id="alertCitaActualizada" class="alert alert-success" role="alert">
                                    {{session('guardado')}}
                                </div>
                            @endif
                            @if($errors->any())
                                <div id="" class="alert alert-danger" role="alert">
                                    Llene todos los campos obligatorios.
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4>Informacion general :</h4>

                            <hr>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="nombre">*Nombre</label>
                                <input class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" type="text" id="nombre" name="nombre" value="{{ old('nombre')}}">
                                <div class="invalid-feedback">
                                    @if($errors->has('nombre'))
                                        {{$errors->first('nombre')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion">Descripcion</label>
                                <textarea class="form-control {{$errors->has('descripcion') ? 'is-invalid' : ''}}" name="descripcion" id="descripcion" cols="30" rows="3"></textarea>
                                <div class="invalid-feedback">
                                    @if($errors->has('descripcion'))
                                        {{$errors->first('descripcion')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="estado">*Estado</label>
                                <select class="form-select {{$errors->has('estado') ? 'is-invalid' : ''}}" aria-label="Default select example" id="estado" name="estado">
                                    <option value="">Seleccione estado</option>

                                </select>
                                <div class="invalid-feedback">
                                    @if($errors->has('estado'))
                                        {{$errors->first('estado')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="descuento">*Descuento</label>
                                <input class="form-control {{$errors->has('descuento') ? 'is-invalid' : ''}}" type="number" id="descuento" name="descuento" value="{{ old('descuento',0)}}">
                                <div class="invalid-feedback">
                                    @if($errors->has('descuento'))
                                        {{$errors->first('descuento')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="retencion">*Retencion</label>
                                <input class="form-control {{$errors->has('retencion') ? 'is-invalid' : ''}}" type="number" id="retencion" name="retencion" value="{{ old('retencion',0)}}" value="0">
                                <div class="invalid-feedback">
                                    @if($errors->has('retencion'))
                                        {{$errors->first('retencion')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="importe">*Importe</label>
                                <input onchange="calcultarIvaImporte(this.value)" class="form-control {{$errors->has('importe') ? 'is-invalid' : ''}}" type="number" id="importe" name="importe" value="{{ old('importe',0)}}">
                                <div class="invalid-feedback">
                                    @if($errors->has('importe'))
                                        {{$errors->first('importe')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="iva"> Iva *</label>
                                <select onchange="calcularIva(this.value)" class="form-select {{$errors->has('iva') ? 'is-invalid' : ''}}" aria-label="Default select example" id="iva" name="iva">
                                    <option value="">Seleccione Iva</option>
                                    <option value="0">0 %</option>
                                    <option value="12">12 %</option>

                                </select>
                                <div class="invalid-feedback">
                                    @if($errors->has('estado'))
                                        {{$errors->first('estado')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="precio">*Precio</label>
                                <input class="form-control {{$errors->has('precio') ? 'is-invalid' : ''}}" type="number" id="precio" name="precio" value="0">
                                <div class="invalid-feedback">
                                    @if($errors->has('precio'))
                                        {{$errors->first('precio')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary"><i class="bi bi-clipboard2-check"></i> Ingresar servicio</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    let importe = document.getElementById('importe');
    let iva = document.getElementById('iva');
    let precio = document.getElementById('precio');
    function calcularIva(iva){
        let valorIva = parseFloat(importe.value) * parseFloat(parseFloat(iva) / 100);
        precio.value = valorIva;
    }
    function calcultarIvaImporte(importe){
        if (isNaN(importe)) {
            console.log(x + " is not a number");
        }
        let valorIva = parseFloat(importe) * parseFloat(parseInt(iva) / 100);
        precio.value = parseFloat(valorIva);
    }
</script>
@endpush
