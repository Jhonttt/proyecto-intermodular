@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('content')
<div class="container text-center mt-5">

    <h1 class="mb-4">Listado de proyectos</h1>

    <form method="GET" class="d-flex justify-content-center gap-2 flex-wrap">
        <input type="text" name="nombre" class="form-control w-auto" placeholder="Blog educativo"
            value="{{ request('nombre') }}">

        <input type="text" name="curso" class="form-control w-auto" placeholder="DAW 2º" value="{{ request('ciclo') }}">

        <input type="text" name="alumnos" class="form-control w-auto" placeholder="Juan Pérez"
            value="{{ request('alumnos') }}">

        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

</div>

<div class="table-responsive container-fluid mt-3">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Ciclo</th>
                <th>Año</th>
                <th>Alumnos</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proyectos as $proyecto)
            <tr>
                <td><a href="{{ route('admin.proyectos.show', $proyecto->id) }}">{{ $proyecto->nombre }}</a></td>
                <td>{{ $proyecto->ciclo }}</td>
                <td>{{ $proyecto->anio }}</td>
                <td>
                    @foreach($proyecto->alumnos as $alumno)
                    {{ $alumno }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>
                    @if ($proyecto->checked)
                    <span class="badge badge-activo">
                        Verificado
                    </span>
                    @else
                    <span class="badge badge-inactivo">
                        Pendiente
                    </span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection