@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<h1 class="text-center">Administra los roles</h1>
@endsection

@section('content')

@if(session('success-create'))
    <div class="alert alert-info text-center" id="success">
        {{ session('success-create') }}
    </div>
@elseif (session('success-update'))
    <div class="alert alert-info text-center" id="success">
        {{ session('success-update') }}
    </div>
@elseif (session('success-delete'))
    <div class="alert alert-info text-center" id="success">
        {{ session('success-delete') }}
    </div>
@endif

<div class="card">
    <div class="card-header">

    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rol</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>

                    <td width="10px"><a href="{{ route('roles.edit', $role) }}" class="btn btn-primary btn-sm mb-2">Editar</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
    <script>
        const successMessage = document.getElementById('success');
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000);
    </script>
@endsection
