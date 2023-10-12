@extends('layouts.base')

@section('styles')
    @vite('public/css/login/css/login.css')
@endsection

@section('title', 'Crear cuenta')

@section('content')

    <form method="POST" class="copiaform" action="{{ route('register') }}">
        @csrf
        <h2>Crear cuenta</h2>
        <div class="content-login container-fluid">
            <div class="row">
                <div class="mb-3">
                    <label for="name" class="form-label"><b>Nombre completo</b></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger">
                            <span>*{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label"><b>Correo</b></label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger">
                            <span>*{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ci" class="form-label"><b>Cédula</b></label>
                    <input type="text" class="form-control" id="ci" name="ci" value="{{ old('ci') }}" maxlength="10" minlength="10" required>
                    @error('ci')
                        <span class="text-danger">
                            <span>*{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type_patient" class="form-label"><b>Tipo de paciente</b></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type_patient" value="0"
                        {{ old('type_patient') == '0' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="type_patient">Estudiante</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type_patient" value="1"
                        {{ old('type_patient') == '1' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="type_patient">Trabajador universitario</label>
                    </div>
                    @error('type_patient')
                        <span class="text-danger">
                            <span>*{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="date_birth" class="form-label"><b>Fecha de nacimiento</b></label>
                    <input type="date" class="form-control" id="date_birth" name="date_birth" value="{{ old('date_birth') }}" placeholder="dd/mm/aaaa" required>
                    @error('date_birth')
                        <span class="text-danger">
                            <span>*{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label"><b>Número de celular</b></label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                    @error('phone')
                        <span class="text-danger">
                            <span>*{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label"><b>Contraseña</b></label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <span class="text-danger">
                            <span>*{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password"><b>confirmar contraseña</b></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="text-center">
            <input type="submit" value="Registrarse" class="button">
        </div>

        <p class="text-center">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="link"><b>Iniciar sesión</b></a></p>

    </form>
@endsection
