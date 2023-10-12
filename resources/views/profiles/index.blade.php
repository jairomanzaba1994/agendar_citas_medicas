@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
<h3 class="text-center">DATOS PERSONALES</h3>
@endsection

@section('content')
    @if(session('success-update'))
        <div class="alert alert-info text-center" id="success">
            {{ session('success-update') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="form-group text-md-left col-md-6">
                            <label for="name" class="col-sm-12">Nombre completo</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $profile->name }}" readonly>
                        </div>

                        <div class="form-group text-md-left col-md-6">
                            <label for="email" class="col-sm-12">Correo eléctronico</label>
                            <input type="text" id="email" name="email" class="form-control" value="{{ $profile->email }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="form-group text-md-left col-md-6">
                            <label for="ci" class="col-sm-12">Cédula</label>
                            <input type="text" class="form-control" id="ci" name="ci" value="{{ $profile->ci }}" readonly>
                        </div>

                        <div class="form-group text-md-left col-md-6">
                            <label for="phone" class="col-sm-12">Número de celular</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ $profile->phone }}" readonly>
                        </div>
                    </div>
                </div>
                @can('profiles.index')
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="form-group text-md-left col-md-6">
                                <label for="date_birth" class="col-sm-12">Fecha de nacimiento</label>
                                <input type="text" class="form-control" id="date_birth" name="date_birth" value="{{ $profile->date_birth }}" readonly>
                            </div>

                            <div class="form-group text-md-left col-md-6">
                                <label for="type_patient" class="col-sm-12">Tipo de paciente</label>
                                @if($profile->type_patient === 0)
                                    <input type="text" id="type_patient" name="type_patient" class="form-control" value="Estudiante" readonly>
                                @elseif($profile->type_patient === 1)
                                    <input type="text" id="type_patient" name="type_patient" class="form-control" value="Trabajador universitario" readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                @endcan

                <div class="form-group text-center">
                        <label for="image" class="col-sm-12 col-form-label">Foto de perfil</label>
                    @if ($profile->profile->photo == NULL)
                        <div class="img-article">
                            <img src="{{ asset('img/user-default.png') }}" class="img">
                        </div>
                    @else
                        <div class="img-article">
                            <img src="{{ asset('storage/' . $profile->profile->photo) }}" class="img">
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <a href="{{ route('profiles.edit', $profile->id) }}"
                        class="btn btn-primary btn text-center">Editar</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login/css/login.css') }}">
@stop

@section('js')
    <script>
        const successMessage = document.getElementById('success');
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000);
    </script>
@endsection
