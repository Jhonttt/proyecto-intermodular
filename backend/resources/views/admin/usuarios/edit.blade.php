@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-body">

            <h2 class="mb-4">Editar usuario</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('admin.usuarios.update', $usuario->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select">
                        <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="usu" {{ $usuario->rol == 'usu' ? 'selected' : '' }}>Usuario</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Activo</label>
                    <select name="activo" class="form-select">
                        <option value="1" {{ $usuario->activo ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ !$usuario->activo ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    Guardar
                </button>

                <a href="{{ route('admin.usuarios.index') }}"
                   class="btn btn-secondary ms-2">
                    Volver
                </a>

            </form>

        </div>
    </div>

</div>

@endsection
