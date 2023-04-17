@extends('layouts.app')
@section('title', 'Citas')
@push('styles')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <h2 class="text-center">Información de Consultas </h2>
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
                                        <label for="">Consultas del dia</label>
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
                    <table class="table table-bordered" id="tableConsulta" style="width: 100%">
                        <thead>
                            <tr>
                            <th scope="col">Acciones</th>
                            <th>Paciente</th>
                            <th scope="col">Especialista</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha</th>

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
        tableCita = $("#tableConsulta").DataTable({
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
                "url": '{{ url("/consulta/listar") }}',
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

            ],
            "fixedColumns" : true
        });
    });
</script>
@endpush
