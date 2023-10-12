@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1 class="text-center">Bienvenid@ al panel de administración</h1>
@stop

@section('content')
    <br>
    <h5 class="text-center">¡Hola! <b>{{ Auth::user()->name }}</b> desde aquí podras administrar tus citas y realizarles un seguimiento.</h5>
    <br>
    <div class="text-center">
        <img src="{{ Auth::user()->profile->photo ? asset('storage/' . Auth::user()->profile->photo)
                : asset('img/user-default.png') }}" alt="Profile" class="img-profile-admi rounded-circle">
    </div>
<br><br>
    <div class="text-center container-fluid">
        @can('appointments.index')
        <a href="{{ route('appointments.index') }}" class="btn btn-info mb-2"><b>Agendar cita</b></a>
        @endcan
        <a href="{{ route('meetings.index') }}" class="btn btn-info mb-2"><b>Ver citas programadas</b></a>
        @can('schedules.index')
        <a href="{{ route('schedules.index') }}" class="btn btn-info mb-2"><b>Gestionar horario</b></a>
        @endcan
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="{{ asset('css/base/css/general.css') }}" rel="stylesheet">
    <link href="{{ mix('vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
@stop
