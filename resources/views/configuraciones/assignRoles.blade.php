@extends('layouts.app')
@section('title', 'Asignación de roles')
@push('styles')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <h2 class="text-center">Asignación de Roles </h2>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <label for="cc_ruc"> Selecciona Persona *</label>
                <div class="input-group mb-3">
                    <button class="btn btn-outline-secondary" id="buttonModalPersona" type="button">Buscar</button>
                    <input id="inputCedulaPersona" type="text" class="form-control {{$errors->has('idpersona') ? 'is-invalid' : ''}}" placeholder="" aria-label="Example text with button addon" aria-describedby="buttonModalPersona" value="{{old('name')}}" disabled>
                    <div class="invalid-feedback">
                        @if($errors->has('idpersona'))
                            {{$errors->first('idpersona')}}
                        @endif
                    </div>
                </div>
                <input type="hidden" name="idpersona" id="idpersona" value="{{old('idpersona')}}">
            </div>
            <div class="col-6">
                <label for="cc_ruc"> Selecciona Rol *</label>
                <div class="input-group mb-3">
                    <button class="btn btn-outline-secondary" id="buttonModalPersona" type="button">Buscar</button>
                    <input id="inputCedulaPersona" type="text" class="form-control {{$errors->has('idpersona') ? 'is-invalid' : ''}}" placeholder="" aria-label="Example text with button addon" aria-describedby="buttonModalPersona" value="{{old('name')}}" disabled>
                    <div class="invalid-feedback">
                        @if($errors->has('idpersona'))
                            {{$errors->first('idpersona')}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
