<div class="card-body table-responsive">
    <table class="table table-striped table-sm" id="tabla3">
        <thead>
            <tr>
                <th>ID</th>
                @if ($role === 'Paciente')
                    <th>Doctor</th>
                @elseif ($role === 'Doctor')
                    <th>Paciente</th>
                @endif
                <th>Especialidad</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($oldAppointments as $appointment)
                <tr>
                    <td><b>{{ $appointment->id }}</b></td>
                    @if ($role === 'Paciente')
                        <td>{{ $appointment->doctor->name }}</td>
                    @elseif ($role === 'Doctor')
                        <td>{{ $appointment->patient->name }}</td>
                    @endif
                    <td>{{ $appointment->specialty->name }}</td>
                    <td>{{ $appointment->schedule_date }}</td>
                    <td>{{ $appointment->schedule_time }}</td>
                    <td>{{ $appointment->status }}</td>

                    <td width="5px" class="text-center">
                        <a class="btn btn-info btn-sm" href="{{ route('appointments.show', $appointment->id) }}"><b><i class='far fa-eye'></i></b></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
