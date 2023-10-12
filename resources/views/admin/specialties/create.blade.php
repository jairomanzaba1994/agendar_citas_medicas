@extends('adminlte::page')

@section('title', 'Crear especialidad')

@section('content_header')
<h2 class="text-center"><b>Crear nueva especialidad</b></h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('specialties.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row"">
                <label class="col-sm-2 col-form-label" for="name">Nombre:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name='name' value="{{ ucwords(strtolower(old('name'))) }}">

                    @error('name')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="description">Descripción:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" id="description">{{old('description')}}</textarea>

                    @error('description')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <input type="submit" value="Crear especialidad" class="btn btn-primary">
                <a href="{{ route('specialties.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
