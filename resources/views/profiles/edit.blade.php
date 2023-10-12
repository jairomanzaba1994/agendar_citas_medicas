@extends('adminlte::page')

@section('title', 'Editar perfil')

@section('content_header')
<h3 class="text-center">EDITAR PERFIL</h3>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('profiles.update', $profile) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"><input type="hidden" name="id" id="id" value="{{ $profile->id }}"></div>
            <div class="container-fluid">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="form-group text-md-left col-md-6">
                            <label for="name" class="col-sm-12">Nombre completo</label>
                            <input type="text" class="form-control" id="name" name="name" minlength="5"
                            maxlength="255" value="{{ $profile->user->name }}">

                            @error('name')
                            <span class="text-danger">
                                <span>*{{ $message }}</span>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group text-md-left col-md-6">
                            <label for="email" class="col-sm-12">Correo eléctronico</label>
                            <input type="text" id="email" name="email" class="form-control" value="{{ $profile->user->email }}">

                            @error('email')
                            <span class="text-danger">
                                <span>*{{ $message }}</span>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="form-group text-md-left col-md-6">
                            <label for="ci" class="col-sm-12">Cédula</label>
                            <input type="text" class="form-control" id="ci" name="ci" value="{{ $profile->user->ci }}" required minlength="10" maxlength="10">

                            @error('ci')
                            <span class="text-danger">
                                <span>*{{ $message }}</span>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group text-md-left col-md-6">
                            <label for="phone" class="col-sm-12">Número de celular</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ $profile->user->phone }}" required minlength="10" maxlength="10">

                            @error('phone')
                            <span class="text-danger">
                                <span>*{{ $message }}</span>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>@error('date_birth')
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
                @can('profiles.edit')
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="form-group text-md-left col-md-6">
                                <label for="date_birth" class="col-sm-12">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="date_birth" name="date_birth" value="{{ $profile->user->date_birth }}">

                                @error('date_birth')
                                <span class="text-danger">
                                    <span>*{{ $message }}</span>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group text-md-left col-md-6">
                                <label for="type_patient" class="col-sm-12">Tipo de paciente</label>
                                <div class="form-control">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">Estudiante</label>
                                        <input class="form-check-input ml-2" type="radio" name='type_patient' id="type_patient" value="0"
                                        {{ ($profile->user->type_patient === 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">Trabajador universitario</label>
                                        <input class="form-check-input ml-2" type="radio" name='type_patient' id="type_patient" value="1"
                                        {{ ($profile->user->type_patient === 1) ? 'checked' : '' }}>
                                    </div>
                                    @error('type_patient')
                                    <span class="text-danger">
                                        <span>* {{ $message }}</span>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="photo" class="col-sm-12">Foto de perfil</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-input-file" id="photo" name='photo' accept="image/*">
                        </div>
                        <div class="col-sm-12 text-center">
                            @if ($profile->photo)
                            <br>
                                <label class="text-center">Foto actual</label>
                                <div class="img-article text-center">
                                    <img src="{{ asset('storage/' . $profile->photo) }}" class="img">
                                </div>
                                @error('photo')
                                    <span class="text-danger">
                                        <span>*{{ $message }}</span>
                                    </span>
                                @enderror
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <input type="submit" value="Guardar cambios" class="btn btn-primary">
                <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login/css/login.css') }}">
@stop
