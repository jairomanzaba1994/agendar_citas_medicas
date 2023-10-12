@extends('adminlte::page')

@section('title', 'Editar especialidad')

@section('content_header')
<h2 class="text-center"><b>Editar especialidad</b></h2>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('specialties.update', $specialty) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"><input type="hidden" name="id" id="id" value="{{ $specialty->id }}"></div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Nombre:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name='name' value="{{ $specialty->name }}">

                    @error('name')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Descripción:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="description" name='description'>{{ $specialty->description }}</textarea>

                    @error('description')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <input type="submit" value="Modificar especialidad" class="btn btn-primary">
                <a href="{{ route('specialties.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

