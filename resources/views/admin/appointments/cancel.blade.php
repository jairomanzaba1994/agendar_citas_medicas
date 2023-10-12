@extends('adminlte::page')

@section('title', 'Cancelar cita')

@section('content_header')
<h2 class="text-center"><b>CANCELAR CITA</b></h2>
@endsection

@section('content')
    @if(session('success-create'))
        <div class="alert alert-success text-center" id="success">
            {{ session('success-create') }}
        </div>
    @elseif (session('success-update'))
        <div class="alert alert-info text-center" id="success">
            {{ session('success-update') }}
        </div>
    @elseif (session('success-delete'))
        <div class="alert alert-secondary text-center" id="success">
            {{ session('success-delete') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header container">
            <div class="row">
                <div class="card-body">

                    @if ($role === 'Paciente')
                        <p>Se cancelará tu cita reservada con el doctor <b>{{ $appointment->doctor->name }}</b>
                            (especialidad <b>{{ $appointment->specialty->name }})</b>
                            para el día <b>{{ $fecha }}</b>
                        </p>
                    @elseif ($role === 'Doctor')
                        <p>Se cancelará la cita médica del paciente <b>{{ $appointment->patient->name }}</b>
                            (especialidad <b>{{ $appointment->specialty->name }})</b>
                            para el día <b>{{ $fecha }}</b>
                            , la hora <b>{{ $appointment->schedule_time }}</b>
                        </p>
                    @else
                        <p>Se cancelará la cita médica del paciente <b>{{ $appointment->patient->name }}</b>
                            que será atendida por el doctor <b>{{ $appointment->doctor->name }}</b>
                            (especialidad <b>{{ $appointment->specialty->name }})</b>
                            para el día <b>{{ $fecha }}</b>
                            , la hora <b>{{ $appointment->schedule_time }}</b>
                        </p>
                    @endif
                        <form action="{{ route('meetings.cancel', $appointment->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="justification">Ponga los motivos de la cancelación:</label>
                                <textarea name="justification" id="justification" rows="3" class="form-control" required></textarea>
                            </div>

                            <div class="card-header text-center">
                                <button class="btn btn-danger" type="submit">Cancelar cita</button>
                                <a class="btn btn-primary" href="{{ route('meetings.index') }}"><b>Volver</b></a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const successMessage = document.getElementById('success');
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000);
    </script>

    <script>
        function confirmarEliminar() {
            return confirm("¿Estás seguro de cancelar la cita?");
        }
    </script>
@endsection
