@extends('adminlte::page')

@section('title', 'Crear cita')

@section('content_header')
    <h2 class="text-center"><b>Registrar nueva cita</b></h2>
@endsection

@section('content')

@if (session('notification'))
    <div class="alert alert-success text-center" id="horario">
        {{ session('notification') }}
    </div>

    <script>
        const successMessage = document.getElementById('horario');
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000);
    </script>
@endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('appointments.store') }}" enctype="multipart/form-data">
            @csrf
                <div class="container-fluid">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="form-group text-md-left col-md-6">
                                <label class="col-sm-12" for="specialty_id">Selecionar una especialidad</label>
                                <select class="form-control js-example-basic-single" name="specialty_id" id="specialty" required>
                                    <option selected>-- Seleccione una especialidad --</option>
                                    @foreach ($specialties as $specialty)
                                        <option value="{{ $specialty->id }}" @if(old('specialty_id')==$specialty->id) selected @endif>
                                            {{ $specialty->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('specialty_id')
                                <span class="text-danger">
                                    <span>*{{ $message }}</span>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group text-md-left col-md-6">
                                <label class="col-sm-12" for="doctor_id">Selecionar un doctor</label>
                                <select class="form-control js-example-basic-single" name="doctor_id" id="doctor" value="{{ old('doctor_id') }}" required></select>
                                @error('doctor_id')
                                <span class="text-danger">
                                    <span>*{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="row justify-content-center">
                            <div class="form-group text-md-left col-md-6">
                                <label class="col-sm-12 text-center" for="schedule_date">Selecionar una fecha</label>
                                <input type="date" class="form-control" name="schedule_date" id="dateselect"
                                    value="{{ old('schedule_date', date('Y-m-d')) }}" required min="<?php echo date('Y-m-d'); ?>"
                                    max="<?php echo date('Y-m-d', strtotime('+3 week')); ?>">
                                    @error('schedule_date')
                                    <span class="text-danger">
                                        <span>*{{ $message }}</span>
                                    </span>
                                    @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <h6 class="text-center"><b>Horas de atención</b></h6>
                        <div class="text-center">
                            <mark class="text-center">
                                <small class="text-warning display-5 text-center">
                                    Selecciona una especialidad, luego un doctor y una fecha para ver las horas disponibles.
                                </small>
                            </mark>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <h6 class=""><b id="titleMorning"></b></h6>
                                <div class="col text-center" id="timesMorning"></div>
                            </div>

                            <div class="col-md-6 text-center">
                                <h6 class=""><b id="titleAfternoon"></b></h6>
                                <div class="col text-center" id="timesAfternoon"></div>
                            </div>
                        </div>
                    </div>
                    <p class="text-center">
                        @error('schedule_time')
                        <span class="text-danger text-center">
                            <span>*{{ $message }}</span>
                        </span>
                        @enderror
                    </p>
                </div>

                <div class="text-center">
                    <input type="submit" value="Crear cita" class="btn btn-primary">
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
    
    <script src="{{ asset('/js/appointments/create.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
