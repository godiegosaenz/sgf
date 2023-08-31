@extends('layouts.app')
@section('title', 'Citas')
@push('styles')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <h2 class="text-center">Información de Citas </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Filtros
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="">Citas del dia</label>
                                        <input class="form-control form-control-sm" type="date" id="fecha" name="fecha" value="<?php echo date("Y-m-d");?>">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <br>
                                    <button id="btnActualizar" class="btn btn-primary btn-sm">Actualizar</button>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>

                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableCita" style="width: 100%">
                        <thead>
                            <tr>
                            <th scope="col">Acciones</th>
                            <th>Paciente</th>
                            <th scope="col">Especialista</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Motivo</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed top-0 end-0">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="ToastCancelCita">
            <div class="toast-header bg-danger text-light pt-3 pb-3">
                <h5 class="my-0">Estas seguro de cancelar la cita.</h5>
              </div>
            <div class="toast-body">
                <button id="buttonSI" type="button" class="btn btn-primary btn-sm"><i class="bi bi-check-circle-fill"></i> Si</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast"><i class="bi bi-x-circle-fill"></i> No</button>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modaleliminar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="exampleModalToggleLabel">¿Estas seguro que quieres eliminar una cita?</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="alertModalEliminar" class="alert alert-danger" role="alert" style="display: none;">
                </div>
              <button id="btnSi" class="btn btn-success">SI</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NO</button>
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
        tableCita = $("#tableCita").DataTable({
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
                "url": '{{ url("/cita/listar") }}',
                "type": "post",
                "data": function (d){
                    d._token = $("input[name=_token]").val();
                    d.fecha =  $("input[name=fecha]").val();
                }
            },
            //"columnDefs": [{ targets: [3], "orderable": false}],
            "columns": [
                {width: '',data: 'action', name: 'action', orderable: false, searchable: false},
                {width: '',data: 'paciente'},
                {width: '',data: 'especialista'},
                {width: '',data: 'estado'},
                {width: '',data: 'fechahora'},
                {width: '',data: 'motivo'},

            ],
            "fixedColumns" : true
        });
    });
</script>
<script>

    function mostrarToasCancelarCita(id){
        new bootstrap.Toast(document.querySelector('#ToastCancelCita')).show();
        let buttonSI = document.getElementById('buttonSI');
        buttonSI.addEventListener('click', function(e) {
            cancelarCita(id);
        });
    }
    let token = "{{csrf_token()}}";
    function cancelarCita(id){
        axios.post('{{route('cancel.cita')}}',{
            id: id,
            _token: token
        }).then(function(res) {
            console.log(res);
            if(res.status==200) {
                if(res.data.respuesta == true){
                    tableCita.ajax.reload();
                    new bootstrap.Toast(document.querySelector('#ToastCancelCita')).hide();
                }else{

                }
            }
        }).catch(function(err) {
            console.log(err);
            /*if(err.response.status == 500){

                console.log('error al consultar al servidor');
            }

            if(err.response.status == 419){
                console.log('Es posible que tu session haya caducado, vuelve a iniciar sesion');
            }*/
        }).then(function() {

        });
    }
    let btnActualizar = document.getElementById('btnActualizar');
    btnActualizar.addEventListener('click',function(){
        tableCita.ajax.reload();
    })
    function modalEliminarCita(idcita){
        var btnSi = document.getElementById('btnSi');
        btnSi.setAttribute('onclick','eliminarCita('+idcita+')');
        var modaleliminar = new bootstrap.Modal(document.getElementById('modaleliminar'), {
        keyboard: false
        })
        modaleliminar.show();
    }
    function eliminarCita(idcita){

        axios.post('{{route('delete.cita')}}',{
            id: idcita,
            _token: token
        }).then(function(res) {

            if(res.status==200) {
                var alertModalEliminar = document.getElementById('alertModalEliminar');
                if(res.data.respuesta == 'eliminado'){
                    tableCita.ajax.reload();
                    alertModalEliminar.removeAttribute('style');
                    alertModalEliminar.setAttribute('class','alert alert-info');
                    alertModalEliminar.innerHTML = res.data.message;
                    //var modal = bootstrap.Modal.getInstance(modaleliminar)
                    //modal.hide();
                }else if('validacion'){
                    alertModalEliminar.removeAttribute('style');
                    alertModalEliminar.setAttribute('class','alert alert-warning');
                    alertModalEliminar.innerHTML = res.data.message;

                    //console.log(res.data.message);
                }else if('error'){
                    alert('error');
                    alertModalEliminar.setAttribute('alert alert-danger');
                    alertModalEliminar.innerHtml = res.data.message;
                }
            }else{
                console.log('error');
            }
        }).catch(function(err) {

        }).then(function() {

        });
    }

</script>
@endpush
