@extends('adminlte::page')

@section('title', 'Horario')

@section('content_header')
<h2 class="text-center"><b>GESTIÓN DE HORARIOS</b></h2>
@endsection

@section('content')
    @if(session('success_create'))
        <div class="alert alert-info text-center" id="success">
            {{ session('success_create') }}
        </div>
    @endif

    @if(session('errors'))
        <div class="alert alert-danger" id="success_errors">
            Los cambios se han guardado pero se encontraron las siguintes novedades
            <ul>
                @foreach(session('errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('doctors.store.schedule', $id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header container">
                <div class="row">
                    <div class="col-sm-6">
                        <input type="submit" value="Guardar cambios" class="btn btn-primary">&nbsp;&nbsp;&nbsp;
                        <a href="{{ route('doctors.show', $id) }}" class="btn btn-secondary">Volver</a>
                    </div>
                    <div class="col-md-6">
                        <b>Doctor:</b>&nbsp;{{ $name_doctor }}
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Día</th>
                            <th class="text-center">Activo</th>
                            <th>Turno mañana</th>
                            <th>Turno tarde</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($schedules as $key => $schedule)
                            <tr>
                                <td>{{ $days[$key] }}</td>
                                <td class="text-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" name="active[]" value="{{ $key }}"
                                        @if($schedule->active) checked @endif>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <select class="form-control" name="morning_start[]">
                                                @for($i=7; $i<=12; $i++)
                                                    <option value="{{ ($i<10 ? '0' : '') . $i }}:00"
                                                    @if(($i<10 ? '0' : '') . $i.':00' === $schedule->morning_start) selected @endif>
                                                    {{ ($i<10 ? '0' : '') . $i }}:00</option>
                                                    @if ($i !== 12)
                                                        <option value="{{ ($i<10 ? '0' : '') . $i }}:30"
                                                        @if(($i<10 ? '0' : '') . $i.':30' === $schedule->morning_start) selected @endif>
                                                        {{ ($i<10 ? '0' : '') . $i }}:30</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-control" name="morning_end[]">
                                                @for($i=7; $i<=12; $i++)
                                                    <option value="{{ ($i<10 ? '0' : '') . $i }}:00"
                                                    @if(($i<10 ? '0' : '') . $i.':00' === $schedule->morning_end) selected @endif>
                                                    {{ ($i<10 ? '0' : '') . $i }}:00</option>
                                                    @if ($i !== 12)
                                                        <option value="{{ ($i<10 ? '0' : '') . $i }}:30"
                                                        @if(($i<10 ? '0' : '') . $i.':30' === $schedule->morning_end) selected @endif>
                                                        {{ ($i<10 ? '0' : '') . $i }}:30</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <select class="form-control" name="afternoon_start[]">
                                                @for($i=12; $i<=17; $i++)
                                                    <option value="{{ $i }}:00"
                                                    @if($i.':00' == $schedule->afternoon_start) selected @endif>
                                                    {{ $i }}:00</option>
                                                    @if ($i !== 17)
                                                        <option value="{{ $i }}:30"
                                                        @if($i.':30' == $schedule->afternoon_start) selected @endif>
                                                        {{ $i }}:30</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-control" name="afternoon_end[]">
                                                @for($i=12; $i<=17; $i++)
                                                    <option value="{{ $i }}:00"
                                                    @if($i.':00' == $schedule->afternoon_end) selected @endif>
                                                    {{ $i }}:00</option>
                                                    @if ($i !== 17)
                                                        <option value="{{ $i }}:30"
                                                        @if($i.':30' == $schedule->afternoon_end) selected @endif>
                                                        {{ $i }}:30</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        const successMessage = document.getElementById('success');
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000);
    </script>

    <script>
        const successMessageErrors = document.getElementById('success_errors');
        setTimeout(function() {
            successMessageErrors.style.display = 'none';
        }, 10000);
    </script>
@endsection
