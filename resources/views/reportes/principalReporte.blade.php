@extends('layouts.app')
@push('styles')

@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">LISTA DE USUARIOS</h2>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <a href="{{route('create.usuario')}}" class="btn btn-primary"><i class="bi bi-plus-circle" disabled></i> Ingresar usuario</a>
            </div>
        </div>

    </div>
@endsection
