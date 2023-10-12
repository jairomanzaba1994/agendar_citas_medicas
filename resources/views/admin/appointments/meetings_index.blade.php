@extends('adminlte::page')

@section('title', 'Citas')

@section('content_header')
    @if ($role === 'Administrador')
        <h2 class="text-center"><b>CITAS</b></h2>
    @else
        <h2 class="text-center"><b>MIS CITAS</b></h2>
    @endif
@endsection

@section('content')
    @if (session('notification'))
        <div class="alert alert-success text-center" id="success">
            {{ session('notification') }}
        </div>
    @endif

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
        @can('appointments.store')
            <div class="card-header container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <a class="btn btn-primary" href="{{ route('appointments.index') }}"><b>Agendar cita</b></a>
                    </div>
                </div>
            </div>
        @endcan
        <br>
        <div class="container-fluid">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mis-citas" type="button" role="tab" aria-selected="true">
                        @if ($role === 'Administrador')
                            <b>Citas</b>
                        @else
                            <b>Mis citas</b>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#citas-pendientes" type="button" role="tab" aria-selected="false"><b>Citas pendientes</b></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#historial" type="button" role="tab" aria-selected="false"><b>Historial</b></button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="mis-citas" role="tabpanel" >
                    @include('admin.appointments.confirmed_appointments')
                </div>
                <div class="tab-pane fade" id="citas-pendientes" role="tabpanel" >
                    @include('admin.appointments.pendient_appointments')
                </div>
                <div class="tab-pane fade" id="historial" role="tabpanel">
                    @include('admin.appointments.old_appointments')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('css/fotos/css/foto.css') }}">
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

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

    <script>
        $(document).ready(function () {
            $('#tabla1').DataTable({
                "paging": true,
                "pageLength": 10,
            });
        });
        $(document).ready(function () {
            $('#tabla2').DataTable({
                "paging": true,
                "pageLength": 10,
            });
        });
        $(document).ready(function () {
            $('#tabla3').DataTable({
                "paging": true,
                "pageLength": 10,
            });
        });
    </script>
@endsection
