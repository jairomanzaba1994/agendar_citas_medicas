@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login/css/login.css') }}">
@endsection

@section('title', 'Ingresar')

@section('content')

<form method="POST" class="form" action="{{ route('login') }}">
    @csrf
    <h2>Iniciar sesión</h2>
    <div class="content-login container-fluid">
        <div class="input-content">
            <input type="text" name="email" placeholder="Correo eléctronico"
            value="{{ old('email') }}" autofocus>

            @error('email')
            <span class="text-danger">
                <span>* {{ $message }}</span>
            </span>
            @enderror
        </div>

        <div class="input-content">
            <input type="password" name="password" placeholder="Contraseña" value="">

            @error('password')
            <span class="text-danger">
                <span>* {{ $message }}</span>
            </span>
            @enderror
        </div>
    </div>

    <a href="{{ route('password.request') }}" class="password-reset"><b>Olvidé mi contraseña</b></a>

    <div class="text-center">
        <input type="submit" value="Iniciar sesión" class="button">
    </div>

    <p>¿No tienes una cuenta? <a href="{{ route('register') }}" class="link"><b>Crear cuenta</b></a></p>
</form>
@endsection
