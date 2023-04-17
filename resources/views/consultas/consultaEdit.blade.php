@extends('layouts.app')
@section('title', 'Registrar consulta')
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">

            <div class="col-md-9 ">
                <div class="row mb-1">
                    <h2>Actualizar consulta</h2>
                </div>
                @if(session('guardado'))
                    <div id="alertCitaActualizada" class="alert alert-success" role="alert">
                        {{session('guardado')}}
                    </div>
                @endif
                <form method="POST" action="{{route('update.consulta')}}">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-12">

                            <div class="alert alert-info alert-dismissible">
                                <div>
                                    <h5><i class="bi-info-circle"></i> Recuerda!</h5>
                                    Todos los campos con un asterisco al final. Son campos obligatorios.
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <table id="Cita-table" class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr style="background-color: #BCDCF9">
                                        <td colspan="4" style="text-align: center"><strong>Informacion de paciente</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-user"></i> <strong>Cedula :</strong></td>
                                        <td>{{$Cita->persona->cedula}}</td>
                                        <td><strong>Historia clínica</strong></td>
                                        <td>{{$Cita->persona->secuencia_historia_clinica}}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-user"></i> <strong>Nombres :</strong></td>
                                        <td>{{$Cita->persona->nombres}}</td>
                                        <td><i class="fa fa-user"></i> <strong>Apellidos :</strong></td>
                                        <td>{{$Cita->persona->apellidos}}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-envelope"></i><strong>Edad :</strong></td>
                                        <td></td>
                                        <td><i class="fa fa-check"></i><strong>Fecha de nacimiento : </strong></td>
                                        <td>{{$Cita->persona->fechaNacimiento}}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-phone"></i><strong>Telefono :</strong></td>
                                        <td>{{$Cita->persona->telefono}}</td>
                                        <td><i class="fa fa-hourglass"></i><strong>Estado Civíl :</strong></td>
                                        <td>{{$Cita->persona->estadoCivil}}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-envelope"></i><strong>Provincia :</strong></td>
                                        <td>{{$Cita->persona->provincia}}</td>
                                        <td><i class="fa fa-check"></i><strong>Cantón : </strong></td>
                                        <td>{{$Cita->persona->canton}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%"><i class="fa fa-phone"></i><strong>Ciudad :</strong></td>
                                        <td style="width: 25%">{{$Cita->persona->ciudad}}</td>
                                        <td style="width: 25%"><i class="fa fa-hourglass"></i><strong>Dirección :</strong></td>
                                        <td style="width: 25%">{{$Cita->persona->direccion}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%"><i class="fa fa-phone"></i><strong>Discapacidad :</strong></td>
                                        <td style="width: 25%">{{$Cita->persona->discapacidad}}</td>
                                        <td style="width: 25%"><i class="fa fa-hourglass"></i><strong>Porcentaje :</strong></td>
                                        <td style="width: 25%">{{$Cita->persona->porcentaje}}</td>
                                    </tr>
                                    <tr style="background-color: #BCDCF9">
                                        <td colspan="4" style="text-align: center"><strong>Informacion de la cita</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%"><i class="fa fa-phone"></i><strong>Fecha :</strong></td>
                                        <td style="width: 25%">{{$Cita->fecha}}</td>
                                        <td style="width: 25%"><i class="fa fa-hourglass"></i><strong>Hora :</strong></td>
                                        <td style="width: 25%">{{$Cita->hora}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%"><i class="fa fa-phone"></i><strong>Estado :</strong></td>
                                        <td style="width: 25%">{{$Cita->estado}}</td>
                                        <td style="width: 25%"><i class="fa fa-hourglass"></i><strong>Tipo de cita :</strong></td>
                                        <td style="width: 25%">{{$Cita->tipo_cita}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%"><i class="fa fa-phone"></i><strong>Especialista :</strong></td>
                                        <td colspan="3" style="width: 25%">{{$Cita->especialista->persona->nombres.' '.$Cita->especialista->persona->apellidos}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%"><i class="fa fa-phone"></i><strong>Motivo :</strong></td>
                                        <td colspan="3" style="width: 25%">{{$Cita->motivo}}</td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4>Informacion Consulta :</h4>
                            <hr>
                        </div>
                        <input type="hidden" id="cita_id" name="cita_id" value="{{$Cita->id}}">
                        <div class="co-12">
                            <div class="mb-3">
                                <label for="diagnostico">* Diagnostico : </label>
                                <textarea class="form-control {{$errors->has('diagnostico') ? 'is-invalid' : ''}}" id="diagnostico" name="diagnostico" rows="3">{{$Consulta->diagnostico}}</textarea>
                                <div class="invalid-feedback">
                                    @if($errors->has('diagnostico'))
                                        {{$errors->first('diagnostico')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="co-12">
                            <div class="mb-3">
                                <label for="tratamiento">* Tratamiento : </label>
                                <textarea class="form-control {{$errors->has('tratamiento') ? 'is-invalid' : ''}}" id="tratamiento" name="tratamiento" rows="3">{{$Consulta->tratamiento}}</textarea>
                                <div class="invalid-feedback">
                                    @if($errors->has('tratamiento'))
                                        {{$errors->first('tratamiento')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
