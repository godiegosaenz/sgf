@extends('layouts.app')
@section('title', 'Editando Roles')
@push('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.bootstrap5.min.css">
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">

            <div class="col-md-11">
                <div class="row mb-1">
                    <h2>Edicion de roles</h2>
                </div>
                <form action="{{ route('update.roles') }}" method="post">
                    @csrf
                    @method('PATCH')
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
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name"> Roles *</label>
                                <select class="form-select {{$errors->has('name') ? 'is-invalid' : ''}}" aria-label="Default select example" id="name" name="name">
                                    <option value="{{$Role->name}}">{{$Role->name}}</option>
                                </select>
                                <div class="invalid-feedback">
                                    @if($errors->has('name'))
                                        {{$errors->first('name')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <label for="tipo_cita"> Permisos *</label>
                            @foreach ($Permission as $p)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $p->name }}"  name="permissions[]" {{ $Role->permissions->contains($p->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    {{$p->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary"><i class="bi bi-clipboard2-check"></i> Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
