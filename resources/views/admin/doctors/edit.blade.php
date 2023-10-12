@extends('adminlte::page')

@section('title', 'Editar doctor')

@section('content_header')
<h2 class="text-center"><b>Editar Doctor</b></h2>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('doctors.update', $doctor) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"><input type="hidden" name="id" id="id" value="{{ $doctor->id }}"></div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Nombre:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name='name' value="{{ old('name', $doctor->name) }}">

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
                    <select name="specialties[]" id="specialties" class="especialidades form-control text-info" multiple="multiple" required>
                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty->id }}" {{ in_array($specialty->id, old('specialties', [])) ? 'selected' : '' }}>
                                {{ $specialty->name }}
                            </option>
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
                        value="{{ old('email', $doctor->email) }}">

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
                        value="{{ old('ci', $doctor->ci) }}" required maxlength="10" minlength="10">

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
                        value="{{ old('phone', $doctor->phone) }}" maxlength="10" minlength="10">

                    @error('phone')
                    <span class="text-danger">
                        <span>*{{ $message }}</span>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <input type="submit" value="Modificar paciente" class="btn btn-primary">
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
        $(document).ready(()=> {});
        $('#specialties').val( @json($specialty_ids) );
    </script>

    <script>
    $(document).ready(function() {
        $('.especialidades').select2();
    });
    </script>
@endsection
