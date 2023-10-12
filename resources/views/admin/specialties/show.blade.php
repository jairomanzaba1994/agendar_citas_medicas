@extends('adminlte::page')

@section('title', 'Ver especialidad')

@section('content_header')
<h2 class="text-center"><b>Información de la especialidad</b></h2>
@endsection

@section('content')
<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($specialties as $specialty)
                    <tr>
                        <td><b>{{ $specialty->id }}</b></td>
                        <td>{{ $specialty->name }}</td>
                        <td>{{ $specialty->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-header text-center">
        <a class="btn btn-primary" href="{{ route('specialties.index') }}"><b>Volver</b></a>
    </div>
</div>
@endsection
