@extends('layouts.app')
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
                            <th>Historia clinica</th>
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
    <div class="modal fade" id="modaleliminar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="exampleModalToggleLabel">¿Estas seguro que quieres eliminar un paciente?</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <button id="btnSi" class="btn btn-success">SI</button>
              <button id="btnNo" class="btn btn-danger">NO</button>
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
        tablePersona = $("#tablePersona").DataTable({
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
                    d.formulario = "persona";
                }
            },
            //"columnDefs": [{ targets: [3], "orderable": false}],
            "columns": [
                {width: '',data: 'action', name: 'action', orderable: false, searchable: false},
                {width: '',data: 'secuencia_historia_clinica'},
                {width: '',data: 'foto', name: 'foto', orderable: false, searchable: false},
                {width: '',data: 'cedula'},
                {width: '',data: 'nombres'},
                {width: '',data: 'apellidos'},
            ],
            "fixedColumns" : true
        });
    })

    function modalEliminarPaciente(idpaciente){
        var btnSi = document.getElementById('btnSi');
        btnSi.setAttribute('onclick','eliminarPaciente('+idpaciente+')');
        var modaleliminar = new bootstrap.Modal(document.getElementById('modaleliminar'), {
        keyboard: false
        })
        modaleliminar.show();
    }
    let token = "{{csrf_token()}}";
    function eliminarPaciente(idpaciente){
        axios.post('{{route('eliminar.persona')}}',{
            id: idpaciente,
            _token: token
        }).then(function(res) {
            console.log(res);
            if(res.status==200) {
                if(res.data.respuesta == true){
                    tablePersona.ajax.reload();
                }else{

                }
            }
        }).catch(function(err) {
            console.log(err);
        }).then(function() {

        });
    }
</script>
@endpush
