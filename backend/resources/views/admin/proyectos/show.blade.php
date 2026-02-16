@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">{{ $proyecto->nombre }}</h2>

    <div class="mb-3">
        <strong>Curso:</strong> {{ $proyecto->curso }}
    </div>

    <div class="mb-3">
        <strong>Alumnos:</strong> {{ $proyecto->alumnos }}
    </div>

    <div class="mb-3">
        <strong>Resumen:</strong>
        <p>{{ $proyecto->resumen }}</p>
    </div>

    <div class="mb-3">
        <strong>descripcion:</strong>
        <p>{{ $proyecto->descripcion }}</p>
    </div>

    @if($proyecto->video_url)
        <div class="mb-4">
            <h5>Vídeo del proyecto</h5>
            <div class="ratio ratio-16x9">
                <iframe 
                    src="{{ $proyecto->video_url }}" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    @endif

    <div class="mt-4">
        <strong>Estado:</strong>
        @if($proyecto->checked)
            <span class="badge bg-success">Validado</span>
        @else
            <span class="badge bg-warning text-dark">Pendiente</span>
        @endif
    </div>

    @if(!$proyecto->checked)
        <form method="POST" action="{{ route('admin.proyectos.check', $proyecto->id) }}" class="mt-3">
            @csrf
            @method('PATCH')
            <button class="btn btn-success">
                Marcar como validado
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('admin.proyectos.uncheck', $proyecto->id) }}" class="mt-3">
            @csrf
            @method('PATCH')
            <button class="btn btn-danger">
                Quitar validación
            </button>
        </form>
    @endif

</div>
@endsection