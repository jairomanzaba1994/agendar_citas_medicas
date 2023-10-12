@extends('adminlte::page')

@section('title', 'Crear paciente')

@section('content_header')
<h2 class="text-center"><b>Crear nuevo paciente</b></h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('patients.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row"">
                <label class="col-sm-2 col-form-label" for="name">Nombre:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name='name' minlength="5"
                    maxlength="255" value="{{ ucwords(strtolower(old('name'))) }}" required>

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
                        value="{{ old('email') }}" required>

                    @error('email')
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
                        {{ old('type_patient') == '0' ? 'checked' : '' }} required>
                    </div>

                    <div class="form-check form-check-inline col-sm-3">
                        <label class="form-check-label">Trabajador universitario</label>
                        <input class="form-check-input ml-2" type="radio" name='type_patient' id="type_patient" value="1"
                        {{ old('type_patient') == '1' ? 'checked' : '' }} required>
                    </div>
                </div>

                @error('type_patient')
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="ci">Cédula:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="ci" name='ci'
                        value="{{ old('ci') }}" required minlength="10" maxlength="10">

                    @error('ci')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="date_birth">Fecha de nacimiento:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="date_birth" name='date_birth'
                        value="{{ old('date_birth') }}" required>

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
                        value="{{ old('phone') }}" required minlength="10" maxlength="10">

                    @error('phone')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="password">Contraseña:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name='password'
                        value="{{ old('password') }}" required>

                    @error('password')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="password_confirmation">Confirmar contraseña:</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="password_confirmation" name='password_confirmation'
                        value="" required>
                </div>

                @error('password_confirmation')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
            </div>

            <div class="text-center">
                <input type="submit" value="Crear paciente" class="btn btn-primary">
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
