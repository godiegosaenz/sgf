@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.bootstrap5.min.css">
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
        <div class="row mt-3">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered" style="width:100%" id="tableUsuario">
                    <thead>
                        <tr>
                            <th scope="col">Accion</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">correo</th>
                            <th scope="col">Roles</th>
                            <th scope="col">Fecha de creacion</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
        tablePersona = $("#tableUsuario").DataTable({
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
                "url": '{{ url("usuario/listar") }}',
                "type": "post",
                "data": function (d){
                    d._token = $("input[name=_token]").val();
                }
            },
            //"columnDefs": [{ targets: [3], "orderable": false}],
            "columns": [
                {width: '',data: 'action', name: 'action', orderable: false, searchable: false},
                {width: '',data: 'name', name: 'foto', orderable: false, searchable: false},
                {width: '',data: 'email'},
                {width: '',data: 'roles'},
                {width: '',data: 'created_at'},
            ],
            "fixedColumns" : true
        });
    })
</script>
@endpush
