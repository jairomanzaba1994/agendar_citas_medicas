@extends('adminlte::page')

@section('title', 'Ver paciente')

@section('content_header')
<h2 class="text-center"><b>Datos del paciente</b></h2>
@endsection

@section('content')
<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre completo</th>
                    <th>Correo</th>
                    <th>Cédula</th>
                    <th>Tipo</th>
                    <th>FDN</th>
                    <th>Teléfono</th>
                    <th>Foto</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <td><b>{{ $patient->id }}</b></td>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->email }}</td>
                            <td>{{ $patient->ci }}</td>
                            <td>{{ $patient->type_patient === 0 ? 'Estudiante' : 'Trabajador universitario' }}</td>
                            <td>{{ $patient->date_birth }}</td>
                            <td>{{ $patient->phone }}</td>
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
    <div class="card-header text-center">
        <a class="btn btn-primary" href="{{ route('patients.index') }}"><b>Volver</b></a>
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
    <link rel="stylesheet" href="{{ asset('css/fotos/css/foto.css') }}">
@endsection
