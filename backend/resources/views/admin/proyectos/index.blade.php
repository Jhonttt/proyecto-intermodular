@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">

        <h1 class="mb-4">Listado de proyectos</h1>

        <form method="GET" class="d-flex justify-content-center gap-2 flex-wrap">
            <input type="text" name="nombre" class="form-control w-auto" placeholder="Blog educativo"
                value="{{ request('nombre') }}">

            <input type="text" name="curso" class="form-control w-auto" placeholder="DAW 2º" value="{{ request('ciclo') }}">

            <input type="text" name="alumnos" class="form-control w-auto" placeholder="Juan Pérez"
                value="{{ request('alumnos') }}">

            <input type="text" name="estado" class="form-control w-auto" placeholder="Pendiente"
                value="{{ request('checked') }}">

            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

    </div>

    <div class="table-responsive">
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
                        <td>{{ $proyecto->nombre }}</td>
                        <td>{{ $proyecto->ciclo }}</td>
                        <td>{{ $proyecto->anio }}</td>
                        <td>@foreach($proyecto->alumnos as $alumno)
                            {{ $alumno }}
                        @endforeach
                        </td>
                        <td>{{ $proyecto->checked ? 'Verificado' : 'Pendiente' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection