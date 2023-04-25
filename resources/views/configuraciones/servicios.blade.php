@extends('layouts.app')
@section('title', 'Servicios')
@push('styles')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <h2 class="text-center">Información servicios </h2>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <a href="{{route('create.servicios')}}" class="btn btn-primary"><i class="bi bi-plus-circle" disabled></i> Ingresar servicio</a>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableServicios" style="width: 100%">
                        <thead>
                            <tr>
                            <th scope="col">Acciones</th>
                            <th>Nombre</th>
                            <th scope="col">precio</th>
                            <th scope="col">descuento</th>
                            <th scope="col">Importe</th>
                            <th scope="col">Retencion</th>
                            <th scope="col">Iva</th>
                            <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
                "url": '{{ url("/servicios/listar") }}',
                "type": "post",
                "data": function (d){
                    d._token = $("input[name=_token]").val();
                    d.vista = 'servicios';
                }
            },
            //"columnDefs": [{ targets: [3], "orderable": false}],
            "columns": [
                {width: '',data: 'action', name: 'action', orderable: false, searchable: false},
                {width: '',data: 'nombre'},
                {width: '',data: 'precio'},
                {width: '',data: 'descuento'},
                {width: '',data: 'importe'},
                {width: '',data: 'retencion'},
                {width: '',data: 'iva'},
                {width: '',data: 'subtotal'},
            ],
            "fixedColumns" : true
        });
    });
</script>
@endpush
