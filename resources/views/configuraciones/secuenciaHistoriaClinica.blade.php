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
                <h2 class="text-center">LISTA DE PERSONAS</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <a href="{{route('ingresar.persona')}}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Ingresar persona</a>
            </div>
        </div>
        <div class="row mt-3">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered" style="width:100%" id="tablePersona">
                    <thead>
                        <tr>
                            <th scope="col">Accion</th>
                            <th>Foto</th>
                            <th scope="col">Cedula</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Apellidos</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
