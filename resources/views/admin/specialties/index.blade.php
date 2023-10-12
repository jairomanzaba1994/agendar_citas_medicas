@extends('adminlte::page')

@section('title', 'Especialidades')

@section('content_header')
<h2 class="text-center"><b>ESPECIALIDADES</b></h2>
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
        <div class="card-header container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-left pb-3">
                    <a class="btn btn-primary" href="{{ route('specialties.create') }}"><b>Agregar especialidad</b></a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-right">
                    <form action="{{ route('specialties.index') }}" method="GET">
                        <div class="mb-3 row">
                            <div class="col-md-10 text-md-right pb-1">
                                <input type="text" name="filterValue" id="filterValue" placeholder="Buscar por nombre de especialidad" class="form-control rounded border-primary text-secondary">
                            </div>
                            <div class="col-md-2 text-md-right">
                                <button type="submit" class="btn btn-info"><b>Buscar</b></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-center" colspan="3">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($specialties as $specialty)
                        <tr>
                            <td><b>{{ $specialty->id }}</b></td>
                            <td>{{ $specialty->name }}</td>
                            <td>{{ Str::limit($specialty->description, 65, '...') }}</td>

                            <td width="2px"><a href="{{ route('specialties.show', $specialty->id) }}"
                                class="btn btn-primary btn-sm mb-2">Mostrar</a></td>

                            <td width="5px"><a href="{{ route('specialties.edit', $specialty->id) }}"
                                class="btn btn-primary btn-sm mb-2">Editar</a></td>

                            <td width="5px">
                                <form action="{{ route('specialties.destroy', $specialty->id) }}" method="POST" onsubmit="return confirmarEliminar(event)">
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
                {{ $specialties->appends(["filterValue" => $filterValue])->links() }}
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
