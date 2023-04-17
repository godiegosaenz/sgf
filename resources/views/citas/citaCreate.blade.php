@extends('layouts.app')
@section('title', 'Creando Cita')
@push('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.bootstrap5.min.css">
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">

            <div class="col-md-11">
                <div class="row mb-1">
                    <h2>Ingreso de citas</h2>
                </div>

                <form method="POST" action="{{route('store.cita')}}">
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
                            <div class="mb-3">
                                <label for="fecha">* Fecha de programacion : </label>
                                <input class="form-control {{$errors->has('fecha') ? 'is-invalid' : ''}}" type="date" id="fecha" name="fecha" value="{{ old('fecha')}}">
                                <div class="invalid-feedback">
                                    @if($errors->has('fecha'))
                                        {{$errors->first('fecha')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="hora">* Hora : </label>
                                <input type="time" class="form-control {{$errors->has('hora') ? 'is-invalid' : ''}}" id="hora" name="hora" value="{{ old('hora') }}" >
                                <div class="invalid-feedback">
                                    @if($errors->has('hora'))
                                        {{$errors->first('hora')}}
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="motivo">* Motivo : </label>
                                <textarea class="form-control {{$errors->has('motivo') ? 'is-invalid' : ''}}" id="motivo" name="motivo" rows="3">{{ old('motivo') }}</textarea>
                                <div class="invalid-feedback">
                                    @if($errors->has('motivo'))
                                        {{$errors->first('motivo')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="tipo_cita"> Tipo de cita *</label>
                                <select class="form-select {{$errors->has('tipo_cita') ? 'is-invalid' : ''}}" aria-label="Default select example" id="tipo_cita" name="tipo_cita">
                                    <option value="">Seleccione tipo</option>
                                    <option value="Primera visita" {{ old('tipo_cita') == 'Primera visita' ? 'selected' : '' }}>Primera visita</option>
                                    <option value="Cita derivida" {{ old('tipo_cita') == 'Cita derivida' ? 'selected' : '' }}>Cita derivida</option>
                                    <option value="Urgencia" {{ old('tipo_cita') == 'Urgencia' ? 'selected' : '' }}>Urgencia</option>
                                    <option value="Empieza tratamiento" {{ old('tipo_cita') == 'Empieza tratamiento' ? 'selected' : '' }}>Empieza tratamiento</option>
                                    <option value="Continua tratamiento" {{ old('tipo_cita') == 'Continua tratamiento' ? 'selected' : '' }}>Continua tratamiento</option>
                                    <option value="Revision" {{ old('tipo_cita') == 'Revision' ? 'selected' : '' }}>Revision</option>
                                </select>
                                <div class="invalid-feedback">
                                    @if($errors->has('tipo_cita'))
                                        {{$errors->first('tipo_cita')}}
                                    @endif
                                </div>
                            </div>

                            <label for="cc_ruc"> Selecciona Paciente *</label>
                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary" id="buttonModalPersona" type="button">Buscar</button>
                                <input id="inputCedulaPersona" type="text" class="form-control {{$errors->has('persona_id') ? 'is-invalid' : ''}}" placeholder="" aria-label="Example text with button addon" aria-describedby="buttonModalPersona" value="{{old('persona_name')}}" disabled>
                                <div class="invalid-feedback">
                                    @if($errors->has('persona_id'))
                                        {{$errors->first('persona_id')}}
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="persona_id" id="persona_id" value="{{old('persona_id')}}">
                            <input type="hidden" name="persona_name" id="persona_name" value="{{old('persona_name')}}">
                            <input type="hidden" name="persona_cedula" id="persona_cedula" value="{{old('persona_cedula')}}">
                            <label for="cc_ruc"> Selecciona Especialista *</label>
                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary" type="button" id="buttonModalEspecialista">Buscar</button>
                                <input id="inputCedulaEspecialista" type="text" class="form-control {{$errors->has('especialista_id') ? 'is-invalid' : ''}}" placeholder="" aria-label="Example text with button addon" aria-describedby="buttonModalEspecialista" value="{{ old('especialista_name') }}" disabled>
                                <div class="invalid-feedback">
                                    @if($errors->has('especialista_id'))
                                        {{$errors->first('especialista_id')}}
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="especialista_id" id="especialista_id" value="{{old('especialista_id')}}">
                            <input type="hidden" name="especialista_name" id="especialista_name" value="{{old('especialista_name')}}">
                            <input type="hidden" name="especialista_cedula" id="especialista_cedula" value="{{old('especialista_cedula')}}">
                        </div>

                        <div class="col-12">
                            <h4>Servicios :</h4>
                            <button type="button" class="btn btn-secondary btn-sm" id="btnModalServicio"><i class="bi bi-plus-circle"></i> Agregar Servicio</button>

                            @if($errors->has('servicios'))
                                {{$errors->first('servicios')}} <i style="color:red;" class="bi bi-info-circle-fill"></i>
                            @endif

                        </div>

                        <div class="co-12 mt-3">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Accion</th>
                                        <th>Unidad</th>
                                        <th style="width: 40%">Concepto</th>
                                        <th>Precio Uni</th>
                                        <th>Desc (%)</th>
                                        <th>Base ($)</th>
                                        <th>Iva (%)</th>
                                        <th>Ret (%)</th>
                                        <th>Subtotal ($)</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyservicios">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td id="tdBase"><strong> TOTAL BASE ($)</strong> </td>
                                        <td id="tdIva"><strong> TOTAL IVA ($)</strong> </td>
                                        <td></td>
                                        <td id="tdTotal"><strong> TOTAL ($)</strong> </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary"><i class="bi bi-clipboard2-check"></i> Agendar Cita</button>
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
        <!-- Modal especialistas -->
    <div class="modal fade" id="modalEspecialista" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Selecciona Especialista</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width:100%" id="tableEspecialistaCita">
                            <thead>
                                <tr>
                                    <th scope="col">Accion</th>
                                    <th scope="col">Cedula</th>
                                    <th scope="col">Nombres</th>
                                    <th scope="col">Apellidos</th>
                                    <th scope="col">Especialidad</th>
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
        <!-- Modal servicios -->
    <div class="modal fade" id="modalServicios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Selecciona el servicio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div id="alertServicios" style="display:none;" class="alert alert-info" role="alert">
                            Informacion: El servicio ya ha sido agregado.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width:100%" id="tableServicios">
                            <thead>
                                <tr>
                                    <th scope="col">Accion</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Importe</th>
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
        @if (session('status'))
            @php
                echo html_entity_decode(session("status"));
            @endphp
        @endif
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
        tableEspecialistaCita = $("#tableEspecialistaCita").DataTable({
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
                "url": '{{ url("/especialista/lista") }}',
                "type": "post",
                "data": function (d){
                    d._token = $("input[name=_token]").val();
                }
            },
            //"columnDefs": [{ targets: [3], "orderable": false}],
            "columns": [
                {width: '',data: 'action', name: 'action', orderable: false, searchable: false},
                {width: '',data: 'cedula'},
                {width: '',data: 'nombres'},
                {width: '',data: 'apellidos'},
                {width: '',data: 'especialidad'},

            ],
            "fixedColumns" : true
        });
        tableServicios = $("#tableServicios").DataTable({
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
                "url": '{{ url("/servicios/lista") }}',
                "type": "post",
                "data": function (d){
                    d._token = $("input[name=_token]").val();
                }
            },
            //"columnDefs": [{ targets: [3], "orderable": false}],
            "columns": [
                {width: '',data: 'action', name: 'action', orderable: false, searchable: false},
                {width: '',data: 'nombre'},
                {width: '',data: 'importe'},
            ],
            "fixedColumns" : true
        });
    })
</script>
<script>
    var buttonModalPersona = document.getElementById('buttonModalPersona');
    var buttonModalEspecialista = document.getElementById('buttonModalEspecialista');
    var btnModalServicio = document.getElementById('btnModalServicio');
    let token = "{{csrf_token()}}";




    buttonModalPersona.addEventListener('click', function() {
        var modalPersona = new bootstrap.Modal(document.getElementById('modalPersona'), {
        keyboard: false
        })
        modalPersona.show();
    });
    buttonModalEspecialista.addEventListener('click', function() {
        var modalEspecialista = new bootstrap.Modal(document.getElementById('modalEspecialista'), {
        keyboard: false
        })
        modalEspecialista.show();
    });
    btnModalServicio.addEventListener('click', function() {
        var modalServicios = new bootstrap.Modal(document.getElementById('modalServicios'), {
        keyboard: false
        })
        modalServicios.show();
    });
    function cargarcantones(idprovincia){
        var canton_id = document.getElementById('canton_id');

        axios.post('{{route('canton.obtener')}}', {
            _token: token,
            idprovincia:idprovincia
        }).then(function(res) {
            if(res.status==200) {
                console.log("cargando cantones");
                canton_id.innerHTML = res.data;
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
    }

    function seleccionarpersona(id,cedula,nombres,apellidos){
        var inputCedulaPersona = document.getElementById('inputCedulaPersona');
        var inputNombresPersona = document.getElementById('inputNombresPersona');
        var persona_id = document.getElementById('persona_id');
        ///////input para carga de paciente //////
        var persona_name = document.getElementById('persona_name');
        var persona_cedula = document.getElementById('persona_cedula');
        /////////////////////////////////////
        inputCedulaPersona.value = nombres+' '+apellidos;
        //inputNombresPersona.value = nombres+' '+apellidos;
        persona_name.value = nombres+' '+apellidos;
        persona_cedula.value = cedula;
        persona_id.value = id;
        var modal = bootstrap.Modal.getInstance(modalPersona)
        modal.hide();
    }

    function seleccionarespecialista(id,cedula,nombres,apellidos){
        var inputCedulaEspecialista = document.getElementById('inputCedulaEspecialista');
        var inputNombresEspecialista = document.getElementById('inputNombresEspecialista');
        var especialista_id = document.getElementById('especialista_id');
        ///////input para carga de especialista //////
        var especialista_name = document.getElementById('especialista_name');
        var especialista_cedula = document.getElementById('especialista_cedula');
        /////////////////////////////////////
        inputCedulaEspecialista.value = nombres+' '+apellidos;
        //inputNombresEspecialista.value = nombres+' '+apellidos;
        especialista_name.value = nombres+' '+apellidos;
        especialista_cedula.value = cedula;
        especialista_id.value = id;
        var modal = bootstrap.Modal.getInstance(modalEspecialista)
        modal.hide();
    }
    localStorage.setItem("totalservicios", 0);
    localStorage.setItem("totalbase", 0);
    localStorage.setItem("totaliva", 0);

    sessionStorage.setItem('filastabla', '  ')
    function seleccionarservicio(id,nombres,precio,descuento,importe,iva,retencion,subtotal){
        var tdTotal = document.getElementById('tdTotal');
        var tdBase = document.getElementById('tdBase');
        var tdIva = document.getElementById('tdIva');
        var totalservicios = localStorage.getItem("totalservicios");
        var totalbase = localStorage.getItem("totalbase");
        var totaliva = localStorage.getItem("totaliva");
        var alertServicios = document.getElementById('alertServicios');
        var checkservicio = document.getElementsByName('servicios[]');
        const datosSeleccionados = [];
        if (checkservicio !== null) {

            for (let i = 0; i < checkservicio.length; i++) {
                if (checkservicio[i].checked) {
                    const valor = checkservicio[i].value;
                    if(valor == id){
                        alertServicios.removeAttribute('style');
                        return false;
                    }
                }
            }
        }else{
            alert('no existe');
        }
        var sumaTotal = parseFloat(totalservicios) + parseFloat(subtotal);
        var sumaBase = parseFloat(totalbase) + parseFloat(importe);
        var sumaIva = parseFloat(totaliva) + parseFloat(iva);
        localStorage.setItem("totalservicios",sumaTotal);
        localStorage.setItem("totalbase",sumaBase);
        localStorage.setItem("totaliva",sumaIva);
        var tbodyservicios = document.getElementById('tbodyservicios');
        // Crear una fila de datos
        let fila1 = document.createElement("tr");
        // Crear las celdas de datos
        let datoCel1 = document.createElement("td");
        datoCel1.innerHTML = '<button type="button" onclick="eliminarFila(this,'+subtotal+','+importe+','+iva+')" class="btn-close" aria-label="Close"></button><input style="display:none;" type="checkbox" name="servicios[]" value="'+id+'" checked/>';
        let datoCel2 = document.createElement("td");
        datoCel2.textContent = "1";
        let datoCel3 = document.createElement("td");
        datoCel3.textContent = nombres;
        let datoCel4 = document.createElement("td");
        datoCel4.textContent = roundToTwo(precio);
        let datoCel5 = document.createElement("td");
        datoCel5.textContent = roundToTwo(descuento);
        let datoCel6 = document.createElement("td");
        datoCel6.textContent = roundToTwo(importe);
        let datoCel7 = document.createElement("td");
        datoCel7.textContent = roundToTwo(iva);
        let datoCel8 = document.createElement("td");
        datoCel8.textContent = roundToTwo(retencion);
        let datoCel9 = document.createElement("td");
        datoCel9.textContent = roundToTwo(subtotal);

        // Agregar las celdas a la fila de datos
        fila1.appendChild(datoCel1);
        fila1.appendChild(datoCel2);
        fila1.appendChild(datoCel3);
        fila1.appendChild(datoCel4);
        fila1.appendChild(datoCel5);
        fila1.appendChild(datoCel6);
        fila1.appendChild(datoCel7);
        fila1.appendChild(datoCel8);
        fila1.appendChild(datoCel9);
        tdTotal.innerHTML = '<strong>TOTAL ($)</strong> '+ roundToTwo(localStorage.getItem("totalservicios"));
        tdBase.innerHTML = '<strong>TOTAL BASE ($)</strong>  '+roundToTwo(localStorage.getItem("totalbase"));
        tdIva.innerHTML = '<strong>TOTAL IVA ($)</strong>  '+roundToTwo(localStorage.getItem("totaliva"));
        tbodyservicios.appendChild(fila1);
    }
    function eliminarFila(btn,subtotal,importe,iva) {
        // Obtener la fila a eliminar
        var tdTotal = document.getElementById('tdTotal');
        var tdBase = document.getElementById('tdBase');
        var tdIva = document.getElementById('tdIva');
        var totalservicios = localStorage.getItem("totalservicios");
        var totalbase = localStorage.getItem("totalbase");
        var totaliva = localStorage.getItem("totaliva");
        var restaTotal = parseFloat(totalservicios) - parseFloat(subtotal);
        var restaBase = parseFloat(totalbase) - parseFloat(importe);
        var restaIva = parseFloat(totaliva) - parseFloat(iva);
        localStorage.setItem("totalservicios",restaTotal);
        localStorage.setItem("totalbase",restaBase);
        localStorage.setItem("totaliva",restaIva);
        tdTotal.innerHTML = 'TOTAL ($) '+restaTotal;
        tdBase.innerHTML = 'TOTAL ($) '+restaBase;
        tdIva.innerHTML = 'TOTAL ($) '+restaIva;
        var fila = btn.parentNode.parentNode;

        // Eliminar la fila
        fila.parentNode.removeChild(fila);
    }

    function variableservicios(){
        alert(getCookie('servicios'));
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function decode(str) {

        let txt = new DOMParser().parseFromString(str, "text/html");

        return txt.documentElement.textContent;

    }

    function roundToTwo(num) {
        return parseFloat(Math.round(num * 100) / 100).toFixed(2);
    }

</script>
@endpush
