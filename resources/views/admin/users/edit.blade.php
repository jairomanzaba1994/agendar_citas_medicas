@extends('adminlte::page')

@section('title', 'Editar usuario')

@section('content_header')
    <h1 class="text-center">Establecer roles</h1>
@endsection

@section('content')

@if (session('success-update'))
    <div class="alert alert-info text-center" id="success">
        {{ session('success-update') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        <p>Nombre completo:</p>
        <p class="form-control">{{ $user->name }}</p>

        <h5>Roles</h5>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            @foreach ($roles as $role)
            <div>
                <label>
                    <input type="radio" name="role" id="role"
                    value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                    class="mr-1 mb-3">
                    {{ $role->name }}
                </label>
            </div>
            @endforeach
            <input type="submit" value="Establecer rol" class="btn btn-primary">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver</a>
        </form>
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
