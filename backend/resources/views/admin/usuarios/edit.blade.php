@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('content')

<div class="usuarios-form-page">

    {{-- Cabecera --}}
    <div class="usuarios-header">
        <div class="usuarios-header-text">
            <h1 style="margin-bottom: 4px;">Editar usuario</h1>
            <p>Modifica los campos que desees actualizar</p>
        </div>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
    </div>

    {{-- Errores --}}
    @if ($errors->any())
    <div class="alert-danger">
        <div class="alert-danger-header">
            <span class="material-icons" style="font-size: 18px; color: var(--color-danger);">error_outline</span>
            <strong>Corrige los siguientes errores:</strong>
        </div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Formulario --}}
    <div class="usuarios-form-panel">

        <div class="usuarios-form-panel-bar">
            Información del usuario
        </div>

        <form method="POST" action="{{ route('admin.usuarios.update', $usuario->id) }}" class="usuarios-form">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="form-field">
                <label>Nombre</label>
                <input type="text" name="name" class="input" value="{{ old('name', $usuario->name) }}"
                    placeholder="Nombre completo">
            </div>

            {{-- Contraseña --}}
            <div class="form-field">
                <label>Nueva contraseña</label>
                <input type="password" name="password" class="input" placeholder="Déjalo vacío para no cambiarla">
                <small style="color: var(--color-text-secondary); font-size: 12px;">
                    Solo rellena este campo si quieres cambiar la contraseña
                </small>
            </div>

            {{-- Rol --}}
            <div class="form-field">
                <label>Rol</label>
                <select name="rol" class="input" style="cursor: pointer; background-color: #fff;">
                    <option value="usu" {{ old('rol', $usuario->rol) === 'usu' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ old('rol', $usuario->rol) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            {{-- Activo --}}
            <div class="form-checkbox">
                <input type="checkbox" name="activo" value="1" {{ old('activo', $usuario->activo) ? 'checked' : '' }}>
                <div class="form-checkbox-label">
                    <p>Usuario activo</p>
                    <p>El usuario podrá iniciar sesión en el sistema</p>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="form-actions">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-submit">Guardar cambios</button>
            </div>

        </form>
    </div>

</div>

@endsection