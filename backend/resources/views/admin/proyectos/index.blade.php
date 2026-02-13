@extends('layouts.app')

@section('content')
    <h1>Listado de proyectos</h1>

    <form method="GET">
        <input type="text" name="nombre" placeholder="Blog educativo" value="{{ request('nombre') }}">
        <input type="text" name="curso" placeholder="DAW 2º" value="{{ request('curso') }}">
        <input type="text" name="alumno" placeholder="Juan Pérezº" value="{{ request('alumnos') }}">
        <button type="submit">Filtrar</button>
    </form>

    <hr>

    @foreach ($proyectos as $proyecto)
        <p>
            {{ $proyecto->nombre }} |
            {{ $proyecto->curso }} |
            {{ $proyecto->alumnos }}
        </p>
    @endforeach
@endsection
