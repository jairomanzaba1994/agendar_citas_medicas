@extends('adminlte::page')

@section('title', 'Ver doctor')

@section('content_header')
<h2 class="text-center"><b>DATOS DEL DOCTOR</b></h2>
@endsection

@section('content')
<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th>ID</th>
                        <th>Nombre completo</th>
                        <th>Especialidades</th>
                        <th>Correo</th>
                        <th>Cédula</th>
                        <th>Teléfono</th>
                        <th>Foto</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($doctors as $doctor)
                    <tr>
                        <td><b>{{ $doctor->id }}</b></td>
                        <td>{{ $doctor->name }}</td>
                        <td>
                            @foreach($specialties as $specialty)
                                {{ $specialty->name }}
                                @if(!$loop->last){{ ', ' }}@endif
                            @endforeach
                        </td>
                        <td>{{ $doctor->email }}</td>
                        <td>{{ $doctor->ci }}</td>
                        <td>{{ $doctor->phone }}</td>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#fotoModal" class="no-border">
                                <div class="img-boton">
                                    @if ($profile[0]->photo == NULL)
                                        <img src="{{ asset('img/user-default.png') }}" class="img-fluid">
                                    @else
                                        <img src="{{ asset('storage/' . $profile[0]->photo) }}" class="img-fluid" alt="Foto">
                                    @endif
                                </div>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-body table-responsive">
        <h3 class="text-center"><b>Horario de atención</b></h3>
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Activo</th>
                    <th>Turno mañana</th>
                    <th>Turno tarde</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($schedules as $key => $schedule)
                    <tr>
                        <td>{{ $days[$schedule->day] }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                @if($schedule->active) checked @endif @disabled(true)>
                            </div>
                        </td>
                        <td>
                            {{ $schedule->morning_start }} - {{ $schedule->morning_end }}
                        </td>
                        <td>
                            {{ $schedule->afternoon_start }} - {{ $schedule->afternoon_end }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-header text-center">
        <a href="{{ route('doctors.index.schedule', $doctor->id, $doctor->name) }}" class="btn btn-primary">Modificar horario</a>
        <a class="btn btn-secondary" href="{{ route('doctors.index') }}"><b>Volver</b></a>
    </div>
</div>

<div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalLabel">Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                    @if ($profile[0]->photo == NULL)
                        <img src="{{ asset('img/user-default.png') }}" class="img-panel">
                    @else
                        <img src="{{ asset('storage/' . $profile[0]->photo) }}" class="img-panel" alt="Foto">
                    @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/fotos/css/foto.css') }}">
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
