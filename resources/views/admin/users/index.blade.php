@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
<h1 class="text-center">Lista de usuarios</h1>
@endsection

@section('content')

@if (session('success-delete'))
    <div class="alert alert-info text-center" id="success">
        {{ session('success-delete') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-left">
            <form action="{{ route('users.index') }}" method="GET">
                <div class="mb-3 row">
                    <div class="col-md-10 text-md-left pb-1">
                        <input type="text" name="filterValue" id="filterValue" placeholder="Buscar por nombre del usuario" class="form-control rounded border-primary text-secondary">
                    </div>
                    <div class="col-md-2 text-md-left">
                        <button type="submit" class="btn btn-info"><b>Buscar</b></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre completo</th>
                    <th scope="col">Email</th>
                    <th class="text-center" colspan="2" scope="col">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th><b>{{ $user->id }}</b></th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td width="10px"><a href="{{ route('users.edit', $user) }}"
                            class="btn btn-primary btn-sm mb-2">Editar</a>
                    </td>

                    <td width="10px">
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirmarEliminar(event)">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Eliminar" class="btn btn-danger btn-sm">
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mt-3">
            {{ $users->links() }}
        </div>

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

    <script>
        function confirmarEliminar() {
            return confirm("¿Estás seguro de que deseas eliminar el registro?");
        }
    </script>
@endsection
