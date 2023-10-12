@extends('adminlte::page')

@section('title', 'Crear doctor')

@section('content_header')
<h2 class="text-center"><b>Crear nuevo Doctor</b></h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('doctors.store') }}" enctype="multipart/form-data">
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

            <div class="form-group row"">
                <label class="col-sm-2 col-form-label" for="specialties">Especialidades:</label>
                <div class="col-sm-10">
                    <select name="specialties[]" id="specialties" class="js-example-basic-multiple form-control" multiple="multiple" required>
                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty->id }}" {{ in_array($specialty->id, old('specialties', [])) ? 'selected' : '' }}>{{ $specialty->name }}</option>
                        @endforeach
                    </select>

                    @error('specialties')
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
                <label class="col-sm-2 col-form-label" for="ci">Cédula:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="ci" name='ci'
                        value="{{ old('ci') }}" minlength="10" maxlength="10" required>

                    @error('ci')
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
                        value="{{ old('phone') }}" minlength="10" maxlength="10" required>

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
                        value="" required>

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

            <input type="hidden" name="date_birth" id="date_birth" value="">

            <div class="text-center">
                <input type="submit" value="Crear doctor" class="btn btn-primary">
                <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection


@section('css')
<link href="{{ mix('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@stop

@section('js')
    <script src="{{ mix('node_modules/select2/dist/js/select2.min.js') }}"></script>

    <script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    </script>
@endsection

