@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Usuarios</title>
    </head>

    <body>
        <h1>Listado de usuarios</h1>

        <a href="{{ url('/admin/usuarios/create') }}">
            Crear usuario
        </a>


        @if ($usuarios->isEmpty())
            <p>No hay usuarios en la base de datos.</p>
        @else
            <ul>

                @foreach ($usuarios as $usuario)
                    <li>
                        {{ $usuario->name }} — {{ $usuario->email }}

                        @if ($usuario->activo)
                            <span>(Activo)</span>
                        @else
                            <span>(Inactivo)</span>
                        @endif

                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}">Editar</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </body>

    </html>
@endsection