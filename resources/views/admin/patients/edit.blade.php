@extends('adminlte::page')

@section('title', 'Editar paciente')

@section('content_header')
<h2 class="text-center"><b>Editar paciente</b></h2>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('patients.update', $patient) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"><input type="hidden" name="id" id="id" value="{{ $patient->id }}"></div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Nombre:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name='name' minlength="5"
                    maxlength="255" value="{{ $patient->name }}" required>

                    @error('name')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="email">Correo:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name='email'
                        value="{{ $patient->email }}" required>

                    @error('email')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="ci">Cédula:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="ci" name='ci'
                        value="{{ $patient->ci }}" required minlength="10" maxlength="10">

                    @error('ci')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="type_patient">Tipo de paciente:</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline col-sm-2">
                        <label class="form-check-label">Estudiante</label>
                        <input class="form-check-input ml-2" type="radio" name='type_patient' id="type_patient" value="0"
                        {{ ($patient->type_patient == 0) ? 'checked' : '' }} @required(true)>
                    </div>

                    <div class="form-check form-check-inline col-sm-3">
                        <label class="form-check-label">Trabajador universitario</label>
                        <input class="form-check-input ml-2" type="radio" name='type_patient' id="type_patient" value="1"
                        {{ ($patient->type_patient == 1) ? 'checked' : '' }} @required(true)>
                    </div>
                </div>

                @error('type_patient')
                <span class="text-danger">
                    <span>* {{ $message }}</span>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="date_birth">Fecha de nacimiento:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="date_birth" name='date_birth'
                        value="{{ $patient->date_birth }}" required>

                    @error('date_birth')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="phone">Teléfono:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name='phone'
                        value="{{ $patient->phone }}" required minlength="10" maxlength="10">

                    @error('phone')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <input type="submit" value="Modificar paciente" class="btn btn-primary">
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

