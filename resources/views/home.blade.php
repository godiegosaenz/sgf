@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center mb-2">
            <h1 class="">Sistema de gestión de fisioterapia</h1>
        </div>
        <div class="col-md-2">
            <div style="width: 100%;" class="card bg-pattern mt-2">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-archive text-primary h4 ml-3"></i>
                    </div>
                    <h5 class="font-size-20 mt-0 pt-1">{{$numpersona}}</h5>
                    <p class="text-muted mb-0">Total Pacientes</p>
                </div>
            </div>
            <div class="card bg-pattern mt-2">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-archive text-primary h4 ml-3"></i>
                    </div>
                    <h5 class="font-size-20 mt-0 pt-1">{{$numdiscapacitados}}</h5>
                    <p class="text-muted mb-0">Discapacitados</p>
                </div>
            </div>
            <div class="card bg-pattern mt-2">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-archive text-primary h4 ml-3"></i>
                    </div>
                    <h5 class="font-size-20 mt-0 pt-1">{{$numcitas}}</h5>
                    <p class="text-muted mb-0">Citas del dia</p>
                </div>
            </div>
        </div>
        <div class="col-md-8 text-center">
            @can('Menu personas')
            <a style="min-width:180px" href="{{ route('mostrar.persona') }}" class="btn btn-lg btn-outline-primary m-2 p-3"><i class="bi bi-people-fill"></i><br>Paciente</a>
            @endcan
            @can('Menu especialistas')
            <a style="min-width:180px" href="{{ route('index.especialista') }}" class="btn btn-lg btn-outline-primary m-2 p-3"><i class="bi bi-person"></i><br>Especialista</a>
            @endcan
            @can('Menu servicios')
            <button style="min-width:180px" type="button" class="btn btn-lg btn-outline-primary m-2 p-3"><i class="bi bi-card-checklist"></i><br>Servicios</button>
            @endcan
            @can('Menu citas')
            <a style="min-width:180px" href="{{ route('index.cita') }}" class="btn btn-lg btn-outline-primary m-2 p-3"><i class="bi bi-journal-medical"></i><br>Citas</a>
            @endcan
            @can('Menu consultas')
            <a style="min-width:180px" href="{{ route('index.consulta') }}" class="btn btn-lg btn-outline-primary m-2 p-3"><i class="bi bi-clipboard2-pulse"></i><br>Consultas</a>
            @endcan
            @can('Menu usuarios')
            <a style="min-width:180px" href="{{ route('index.usuario') }}" class="btn btn-lg btn-outline-primary m-2 p-3"><i class="bi bi-person-badge"></i> <br>Usuarios</a>
            @endcan
            <button style="min-width:180px" type="button" class="btn btn-lg btn-outline-primary m-2 p-3"><i class="bi bi-person-lines-fill"></i><br>Asignaciones</button>
            @can('listar roles')
            <button style="min-width:180px" type="button" class="btn btn-lg btn-outline-primary m-2 p-3"><i class="bi bi-lock-fill"></i><br>Roles</button>
            @endcan
            <button style="min-width:180px" type="button" class="btn btn-lg btn-outline-primary m-2 p-3"><i class="bi bi-filetype-pdf"></i><br>Reportes</button>
        </div>
        <div class="col-md-2">
            <div class="card m-2" style="width: 18rem;">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><strong>Alertas y notificaciones</strong></li>

                </ul>
              </div>
        </div>
    </div>
</div>
@endsection
