@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('content')
<div class="usuarios-page">

    {{-- Cabecera --}}
    <div class="usuarios-header">
        <div class="usuarios-header-text">
            <h1 style="margin-bottom: 4px;">Usuarios</h1>
            <p>Gestiona los usuarios del sistema</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
            Crear usuario
        </a>
    </div>

    {{-- Mensaje success --}}
    @if (session('success'))
    <div class="alert-success">
        <span class="material-icons" style="font-size: 18px;">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    @if ($usuarios->isEmpty())
    {{-- Estado vacío --}}
    <div class="usuarios-empty">
        <span class="material-icons">group</span>
        <p>No hay usuarios en la base de datos.</p>
    </div>

    @else

    {{-- Tabla --}}
    <div class="usuarios-panel">

        <div class="usuarios-panel-bar">
            {{ $usuarios->count() }} usuario{{ $usuarios->count() !== 1 ? 's' : '' }} registrado{{ $usuarios->count()
            !== 1 ? 's' : '' }}
        </div>

        <table class="usuarios-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr>
                    <td class="col-nombre">{{ $usuario->name }}</td>
                    <td class="col-email">{{ $usuario->email }}</td>

                    <td>
                        @if ($usuario->rol === 'admin')
                        <span class="badge badge-admin">
                            <span class="material-icons" style="font-size: 12px;">shield</span>
                            Admin
                        </span>
                        @else
                        <span class="badge badge-usuario">
                            <span class="material-icons" style="font-size: 12px;">person</span>
                            Usuario
                        </span>
                        @endif
                    </td>

                    <td>
                        @if ($usuario->activo)
                        <span class="badge badge-activo">
                            <span class="badge-dot"></span>
                            Activo
                        </span>
                        @else
                        <span class="badge badge-inactivo">
                            <span class="badge-dot"></span>
                            Inactivo
                        </span>
                        @endif
                    </td>

                    <td class="text-right">
                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-primary"
                            style="font-size: 12px; padding: 6px 14px;">
                            Editar
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif

</div>

@endsection