<div class="card-body table-responsive">
    <table class="table table-striped table-sm" id="tabla2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Especialidad</th>
                @if ($role === 'Paciente')
                    <th>Doctor</th>
                @elseif ($role === 'Doctor')
                    <th>Paciente</th>
                @endif
                <th>Fecha</th>
                <th>Hora</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pendientAppointments as $appointment)
                <tr>
                    <td><b>{{ $appointment->id }}</b></td>
                    <td>{{ $appointment->specialty->name }}</td>
                    @if ($role === 'Paciente')
                        <td>{{ $appointment->doctor->name }}</td>
                    @elseif ($role === 'Doctor')
                        <td>{{ $appointment->patient->name }}</td>
                    @endif
                    <td>{{ $appointment->schedule_date }}</td>
                    <td>{{ $appointment->schedule_time }}</td>
                    <td class="button-cell">
                        @if ($role === 'Doctor' || $role === 'Administrador')
                            <form action="{{ route('meetings.confirm', $appointment->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-check"></i></button>
                            </form>
                        @endif
                        @if ($role === 'Administrador')
                            <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-info btn-sm" style="white-space: nowrap;"><i class='far fa-eye'></i></a>
                        @endif
                        <form action="{{ route('meetings.cancel', $appointment->id) }}" method="POST" onsubmit="return confirmarEliminar(event)">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
