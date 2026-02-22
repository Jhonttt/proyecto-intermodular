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
            <h1 style="margin-bottom: 4px;">Crear usuario</h1>
            <p>Rellena los datos para registrar un nuevo usuario</p>
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

        <form method="POST" action="{{ route('admin.usuarios.store') }}" class="usuarios-form">
            @csrf

            {{-- Nombre --}}
            <div class="form-field">
                <label>Nombre</label>
                <input type="text" name="name" class="input" value="{{ old('name') }}" placeholder="Nombre completo">
            </div>

            {{-- Email --}}
            <div class="form-field">
                <label>Email</label>
                <input type="email" name="email" class="input" value="{{ old('email') }}" placeholder="correo@ejemplo.com">
            </div>

            {{-- Contraseña --}}
            <div class="form-field">
                <label>Contraseña</label>
                <input type="password" name="password" class="input" placeholder="Mínimo 6 caracteres">
            </div>

            {{-- Rol --}}
            <div class="form-field">
                <label>Rol</label>
                <select name="rol" class="input" style="cursor: pointer; background-color: #fff;">
                    <option value="usu" {{ old('rol') === 'usu' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ old('rol') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            {{-- Activo --}}
            <div class="form-checkbox">
                <input type="checkbox" name="activo" value="1" checked>
                <div class="form-checkbox-label">
                    <p>Usuario activo</p>
                    <p>El usuario podrá iniciar sesión en el sistema</p>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="form-actions">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-submit">Guardar usuario</button>
            </div>

        </form>
    </div>

</div>

@endsection