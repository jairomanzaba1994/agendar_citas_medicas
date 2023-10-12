@extends('adminlte::page')

@section('title', 'Ver cita')

@section('content_header')
<h2 class="text-center"><b>CITA #{{ $appointment->id }}</b></h2>
@endsection

@section('content')
    <div class="card">
        <div class="card-header container">
            <div class="row">
                <div class="card-body">
                    <ul>
                        <dd>
                            <strong>Fecha:&nbsp;</strong> {{ $appointment->schedule_date }}
                        </dd>
                        <dd>
                            <strong>Hora de atención:&nbsp;</strong> {{ $appointment->schedule_time }}
                        </dd>
                        @if ($role === 'Paciente' || $role === 'Administrador')
                        <dd>
                            <strong>Doctor:&nbsp;</strong> {{ $appointment->doctor->name }}
                        </dd>
                        @endif
                        @if ($role === 'Doctor' || $role === 'Administrador')
                        <dd>
                            <strong>Paciente:&nbsp;</strong> {{ $appointment->patient->name }}
                        </dd>
                        @endif
                        <dd>
                            <strong>Especialidad:&nbsp;</strong> {{ $appointment->specialty->name }}
                        </dd>
                        <dd>
                            <strong>Estado:&nbsp;</strong>
                            @if ($appointment->status == 'Cancelada')
                                <span class="text-danger">Cancelada</span>
                            @else
                                <span class="text-primary">{{ $appointment->status }}</span>
                            @endif
                        </dd>
                    </ul>

                    @if ($appointment->status === 'Cancelada')
                        <div class="alert bg-light text-primary">
                            <h3><b>Detalles de la cancelación</b></h3>
                            @if ($appointment->cancellation)
                                <ul class="text-primary">
                                    <li>
                                        <strong>Fecha de cancelación:&nbsp;</strong> {{ $appointment->cancellation->created_at }}
                                    </li>
                                    <li>
                                        <strong>La cita fué cancelada por:&nbsp;</strong> {{ $appointment->cancellation->cancelled_by->name }}
                                    </li>
                                    <li>
                                        <strong>Motivo de la cancelación:&nbsp;</strong> {{ $appointment->cancellation->justification }}
                                    </li>
                                </ul>
                            @else
                                <ul class="text-primary">
                                    <li>
                                        La cita fué cancelada antes de su confirmación.
                                    </li>
                                </ul>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('meetings.index') }}" class="btn btn-primary text-center">Volver</a>
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
