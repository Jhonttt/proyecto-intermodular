@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Nombre del proyecto -->
    <h2 class="mb-4">{{ $proyecto->nombre }}</h2>
    
    <!-- Resumen -->
    <div class="mb-3">
        <strong>Resumen:</strong>
        <p>{{ $proyecto->resumen }}</p>
    </div>
    
    <!-- Descripción -->
    <div class="mb-3">
        <strong>Descripción:</strong>
        <p>{{ $proyecto->descripcion }}</p>
    </div>

    <!-- Curso -->
    <div class="mb-3">
        <strong>Curso:</strong> {{ $proyecto->curso }}
    </div>

    <!-- Año -->
    <div class="mb-3">
        <strong>Año:</strong> 
        {{ ($proyecto->created_at->year - 1) }}-{{ $proyecto->created_at->year % 100 }}
    </div>

    <!-- Alumnos -->
    <div class="mb-3">
        <strong>Alumnos:</strong> {{ $proyecto->alumnos }}
    </div>

    <!-- Video del proyecto -->
    @if($proyecto->video_url)
        <div class="mb-4">
            <h5>Vídeo del proyecto</h5>
            <div class="ratio ratio-16x9">
                <!-- Convertir la URL genérica a formato embed  (Las URLs watch?v= son bloqueadas por Youtube) -->
                <iframe 
                    src="{{ str_replace('watch?v=', 'embed/', $proyecto->video_url) }}" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    @endif

    <!-- Tags -->
    @if(!empty($proyecto->tags))
        <div class="mb-3">
            <strong>Tags:</strong>
            @foreach($proyecto->tags as $tag)
                <span class="badge bg-secondary me-1">{{ $tag }}</span>
            @endforeach
        </div>
    @endif

    <!-- Documentos adjuntos -->
    @if(!empty($proyecto->documentos))
        <div class="mb-4">
            <strong>Documentos adjuntos:</strong>
            <ul class="list-group mt-2">
                @foreach($proyecto->documentos as $documento)
                    <li class="list-group-item">
                        <a href="{{ asset('storage/' . $documento) }}" download>
                            {{ basename($documento) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Estado del proyecto -->
    <div class="mt-4">
        <strong>Estado:</strong>
        @if($proyecto->checked)
            <span class="badge bg-success">Validado</span>
        @else
            <span class="badge bg-warning text-dark">Pendiente</span>
        @endif
    </div>

    <!-- Acciones -->
    <div class="mt-3 d-flex gap-2 justify-content-center">
        @if(!$proyecto->checked)
            <form method="POST" action="{{ route('admin.proyectos.check', $proyecto->id) }}">
                @csrf
                @method('PATCH')
                <button class="btn btn-success">
                    Validar
                </button>
            </form>

            <!-- Botón de modificar: falta invocar la acción con la ruta creada  -->
            <a class="btn btn-primary">
            Modificar
            </a>

            <form method="POST" action="{{ route('admin.proyectos.destroy', $proyecto->id) }}"
                onsubmit="return confirm('¿Seguro que deseas eliminar este proyecto?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    Eliminar
                </button>
            </form>

        @else
            <form method="POST" action="{{ route('admin.proyectos.uncheck', $proyecto->id) }}">
                @csrf
                @method('PATCH')
                <button class="btn btn-danger">
                    Volver a revisar
                </button>
            </form>
        @endif
        
    </div>

</div>
@endsection