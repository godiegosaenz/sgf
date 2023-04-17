@extends('layouts.app')
@section('title', 'Perfil')
@push('styles')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <h2 class="text-center">Perfil de usuario </h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                        class="rounded-circle img-fluid" style="width: 150px;">
                      <h5 class="my-3">{{$User->name}}</h5>
                      <p class="text-muted mb-1">Full Stack Developer</p>
                      <p class="text-muted mb-4">Bay Area, San Francisco, CA</p>
                      <div class="d-flex justify-content-center mb-2">
                        <button type="button" class="btn btn-primary">Follow</button>
                        <button type="button" class="btn btn-outline-primary ms-1">Message</button>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Nombres y apellidos</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{$User->personas->nombres.' '.$User->personas->apellidos}}</p>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Correo</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{$User->email}}</p>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Cedula</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{$User->personas->cedula}}</p>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">telefono</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{$User->personas->telefono}}</p>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Direccion</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{$User->personas->direccion}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
@endsection
