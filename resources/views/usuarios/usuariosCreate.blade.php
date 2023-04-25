@extends('layouts.app')
@section('title', 'Crear usuarios')
@push('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.bootstrap5.min.css">
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">

            <div class="col-md-11">
                <div class="row mb-1">
                    <h2>Ingresar usuarios</h2>
                </div>
                {{$errors->any()}}
                <form action="{{ route('store.usuario') }}" method="post">
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
                        <div class="col-6">
                            <label for="cc_ruc">*Selecciona Persona</label>
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

                            <div class="mb-3">
                                <label for="name">*Nombres</label>
                                <input class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" type="text" id="name" name="name" value="{{ old('name')}}" required>
                                <div class="invalid-feedback">
                                    @if($errors->has('name'))
                                        {{$errors->first('name')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email">*Correo</label>
                                <input class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" type="email" id="email" name="email" value="{{ old('email')}}" required>
                                <div class="invalid-feedback">
                                    @if($errors->has('email'))
                                        {{$errors->first('email')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_usuario">*Tipo de usuario</label>
                                <select onchange="mostrar_ocultar_especialista(this.value)" class="form-select {{$errors->has('tipo_usuario') ? 'is-invalid' : ''}}" aria-label="Default select example" id="tipo_usuario" name="tipo_usuario">
                                    <option value="">Seleccione usuario</option>
                                    <option @selected(old('tipo_usuario') == 'paciente') value="paciente">Paciente</option>
                                    <option @selected(old('tipo_usuario') == 'especialista') value="especialista">Especialista</option>
                                </select>
                                <div class="invalid-feedback">
                                    @if($errors->has('tipo_usuario'))
                                        {{$errors->first('tipo_usuario')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3" style="display:none;" id="div_especialista">
                                <label for="especialidad">*Especialista</label>
                                <select class="form-select {{$errors->has('especialidad') ? 'is-invalid' : ''}}" id="especialidad" name="especialidad">
                                    <option value="">Seleccione especialidad</option>
                                    @foreach ($Especialidades as $e)
                                        <option value="{{$e->id}}" @selected(old('especialidad') == $e->id)>{{$e->nombre}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @if($errors->has('especialidad'))
                                        {{$errors->first('especialidad')}}
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="password">*Contraseña</label>
                                <input class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" type="password" id="password" name="password" value="{{ old('password')}}" required>
                                <div class="invalid-feedback">
                                    @if($errors->has('password'))
                                        {{$errors->first('password')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="name">*Confirmar Contraseña</label>
                                <input id="password-confirm" type="password" class="form-control {{$errors->has('password-confirm') ? 'is-invalid' : ''}}" name="password_confirmation" required autocomplete="new-password" value="{{ old('password_confirmation')}}">
                                <div class="invalid-feedback">
                                    @if($errors->has('password-confirm'))
                                        {{$errors->first('password-confirm')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="estado">*Estado</label>
                                <select class="form-select {{$errors->has('estado') ? 'is-invalid' : ''}}" aria-label="Default select example" id="estado" name="estado">
                                    <option value="">Seleccione estado</option>
                                    <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                <div class="invalid-feedback">
                                    @if($errors->has('estado'))
                                        {{$errors->first('estado')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="titulo">Titulo</label>
                                <input class="form-control {{$errors->has('titulo') ? 'is-invalid' : ''}}" type="text" id="titulo" name="titulo" value="{{ old('titulo')}}" required>
                                <div class="invalid-feedback">
                                    @if($errors->has('titulo'))
                                        {{$errors->first('titulo')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary"><i class="bi bi-clipboard2-check"></i> Crer usuario</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!-- Modal persona -->
     <div class="modal fade" id="modalPersona" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Selecciona Persona</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width:100%" id="tablePersonaCita">
                            <thead>
                                <tr>
                                    <th scope="col">Accion</th>
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

        </div>
        </div>
    </div>
@endsection
@push('scripts')
<!-- jQuery -->
<script src="//code.jquery.com/jquery-3.5.1.js"></script>
<!-- DataTables -->
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="//cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script>
    $(document).ready(function(){
        tablePersonaCita = $("#tablePersonaCita").DataTable({
            "lengthMenu": [ 5, 10],
            "language" : {
                "url": '{{ asset("/js/spanish.json") }}',
            },
            "autoWidth": true,
            "rowReorder": true,
            "order": [], //Initial no order
            "processing" : true,
            "serverSide": true,
            "ajax": {
                "url": '{{ url("/paciente/listar") }}',
                "type": "post",
                "data": function (d){
                    d._token = $("input[name=_token]").val();
                    d.formulario = "cita";
                }
            },
            //"columnDefs": [{ targets: [3], "orderable": false}],
            "columns": [
                {width: '',data: 'action', name: 'action', orderable: false, searchable: false},
                {width: '',data: 'cedula'},
                {width: '',data: 'nombres'},
                {width: '',data: 'apellidos'},

            ],
            "fixedColumns" : true
        });
    })
</script>
<script>
    let token = "{{csrf_token()}}";
    var buttonModalPersona = document.getElementById('buttonModalPersona');
    buttonModalPersona.addEventListener('click', function() {
            var modalPersona = new bootstrap.Modal(document.getElementById('modalPersona'), {
            keyboard: false
            })
            modalPersona.show();
        });
    /*var selectrol = document.getElementById('selectrol');
    selectrol.addEventListener('change', function() {
        //var optionSelectName = document.getElementById('optionSelectCanton');
        //optionSelectName.innerHTML = 'Cargando...';
        var selectedOption = this.options[selectrol.selectedIndex];
        //console.log(selectedOption.value + ': ' + selectedOption.text);
        cargarpermisos(selectedOption.value);
    });
    function cargarpermisos(nameRol){
        var mostrarpermisos = document.getElementById('mostrarpermisos');
        axios.post('{{route('obtener.permissions')}}', {
            _token: token,
            name:nameRol
        }).then(function(res) {
            if(res.status==200) {
                var htmlchecks = '';
                count = Object.keys(res.data.permissions).length;
                console.log(res.data.permissions);
                for(var cont = 1; cont < count; cont++){
                    htmlchecks += '<div class="form-check">';
                    htmlchecks += '<input class="form-check-input" type="checkbox" value=""  name="permissions[]" checked disabled>';
                    htmlchecks += '<label class="form-check-label" for="flexCheckDefault">';
                    htmlchecks += res.data.permissions[cont].name;
                    htmlchecks += '</label>';
                    htmlchecks += '</div>';
                }
                mostrarpermisos.innerHTML = htmlchecks;
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
    }*/

    function seleccionarpersona(id,cedula,nombres,apellidos){
        var name = document.getElementById('name');
        var idpersona = document.getElementById('idpersona');
        var inputCedulaPersona = document.getElementById('inputCedulaPersona');

        name.value = nombres;
        inputCedulaPersona.value = nombres+' '+apellidos;
        //inputNombresPersona.value = nombres+' '+apellidos;
        idpersona.value = id;
        var modal = bootstrap.Modal.getInstance(modalPersona)
        modal.hide();
    }

    function mostrar_ocultar_especialista(valor){
        var div_especialista = document.getElementById('div_especialista');
        if(valor == 'paciente'){
            div_especialista.setAttribute('style', 'display:none')
        }else if('especialista'){
            div_especialista.removeAttribute('style');
        }else if(valor == ''){
            div_especialista.setAttribute('style', 'display:none');
        }
    }

</script>
@endpush
