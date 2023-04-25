@extends('layouts.app')
@section('title', 'Configuracion secuencia historia clinica')
@push('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.bootstrap5.min.css">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">CONFIGURACION SECUENCIA DE HISTORIAL CLINICA</h2>
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-8">
                <div class="alert alert-info alert-dismissible">
                    <div>
                        <h5><i class="bi-info-circle"></i> Recuerda!</h5>
                        Si desactivas la opcion de secuencia automática de historial clínica, tendras que ingresar el secuencial de forma manual.
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('store.roles') }}" method="post">
            <div class="row justify-content-center align-items-center mt-3">
                @csrf
                <div class="col-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Secuencial automático</label>
                    </div>
                </div>
                <div class="col-5">
                    <div class="mb-3">
                        <label for="name">*Numero de secuencia de inicial</label>
                        <input class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" type="text" id="name" name="name" value="{{ old('name')}}">
                        <div class="invalid-feedback">
                            @if($errors->has('name'))
                                {{$errors->first('name')}}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <button class="btn btn-primary"><i class="bi bi-clipboard2-check"></i> Guardar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
