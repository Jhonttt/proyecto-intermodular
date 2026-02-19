@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-body">

            <h2 class="mb-4">Crear usuario</h2>

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.usuarios.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name"
                           class="form-control"
                           value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                           class="form-control"
                           value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select">
                        <option value="admin">Admin</option>
                        <option value="usu">Usuario</option>
                    </select>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="activo"
                           class="form-check-input"
                           value="1" checked>
                    <label class="form-check-label">
                        Usuario activo
                    </label>
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
