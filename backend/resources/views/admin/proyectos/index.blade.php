@extends('layouts.app')

@section('content')
    <h1>Listado de proyectos</h1>

    <form method="GET">
        <input type="text" name="nombre" placeholder="Blog educativo" value="{{ request('nombre') }}">
        <input type="text" name="curso" placeholder="DAW 2º" value="{{ request('curso') }}">
        <input type="text" name="alumno" placeholder="Juan Pérezº" value="{{ request('alumnos') }}">
        <button type="submit">Filtrar</button>
    </form>


<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Ciclo</th>
                <th>Año</th>
                <th>Alumnos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proyectos as $proyecto)
                <tr>
                    <td>{{ $proyecto->nombre }}</td>
                    <td>{{ $proyecto->ciclo }}</td>
                    <td>{{ $proyecto->anio }}</td>
                    <!-- añadir alumnos y estado -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection