@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de usuarios</h1>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
            Crear usuario
        </a>
    </div>

    {{-- Mensaje success --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($usuarios->isEmpty())
        <div class="alert alert-info">
            No hay usuarios en la base de datos.
        </div>
    @else

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
</thead>

                    <tbody>
                        @foreach ($usuarios as $usuario)
                           <tr>
    <td>{{ $usuario->name }}</td>
    <td>{{ $usuario->email }}</td>

    <td>
        @if ($usuario->rol === 'admin')
            <span class="badge bg-primary">Admin</span>
        @else
            <span class="badge bg-secondary">Usuario</span>
        @endif
    </td>

    <td>
        @if ($usuario->activo)
            <span class="badge bg-success">Activo</span>
        @else
            <span class="badge bg-danger">Inactivo</span>
        @endif
    </td>

    <td>
        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
           class="btn btn-sm btn-warning">
            Editar
        </a>
    </td>
</tr>
 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endif

</div>

@endsection
