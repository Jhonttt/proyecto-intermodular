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
        <strong>Curso:</strong> {{ $proyecto->ciclo }}
    </div>

    <!-- Año -->
    <div class="mb-3">
        <strong>Año:</strong> {{ $proyecto->anio }}
    </div>

    <!-- Alumnos -->
    <div class="mb-3">
        <strong>Alumnos:</strong>
        @foreach($proyecto->alumnos as $alumno)
        {{ $alumno }}@if(!$loop->last), @endif
        @endforeach
    </div>

    <!-- Video del proyecto -->
    @if($proyecto->video_public_url)
    <div class="mb-4">
        <h5>Vídeo del proyecto</h5>
        <video class="w-100" controls preload="metadata">
            <source src="{{ $proyecto->video_public_url }}" type="video/mp4">
            Tu navegador no soporta vídeo HTML5.
        </video>
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
    @if($proyecto->documentos_public)
    <div class="mb-4">
        <strong>Documentos adjuntos:</strong>
        <ul class="list-group mt-2">
            @foreach($proyecto->documentos_public as $doc)
            <li class="list-group-item">
                <a href="{{ $doc['url'] }}" target="_blank" download>
                    {{ $doc['name'] }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-3">
        <label class="form-label">Observaciones</label>

        <textarea
            id="observaciones"
            class="form-control"
            style="background-color: #E4EEF7"
            rows="3"
            {{ $proyecto->checked ? 'disabled' : '' }}>{{ old('observaciones', $proyecto->observaciones) }}</textarea>

        @if($proyecto->checked)
        <div class="form-text text-muted">
            Para modificar las observaciones, cambia el proyecto a pendiente.
        </div>
        @endif
    </div>

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
        <form id="form-validar" method="POST"
            action="{{ route('admin.proyectos.check', $proyecto->id) }}">
            @csrf
            @method('PATCH')

            <input type="hidden" name="observaciones" id="obs-hidden">

            <button type="button" class="btn btn-success" onclick="validarProyecto()">
                Validar
            </button>
        </form>

        <script>
            function validarProyecto() {
                const textarea = document.getElementById('observaciones');
                const hidden = document.getElementById('obs-hidden');

                if (textarea) {
                    hidden.value = textarea.value;
                }

                document.getElementById('form-validar').submit();
            }
        </script>

        <a href="{{ route('admin.proyectos.edit', $proyecto->id) }}"
            class="btn btn-primary">
            Editar
        </a>

        <form method="POST" action="{{ route('admin.proyectos.destroy', $proyecto->id) }}">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger"
                onclick="abrirModal('{{ $proyecto->id }}', '{{ $proyecto->nombre }}')">
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

{{-- Modal confirmación eliminar proyecto --}}
<div id="modal-eliminar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:8px; padding:24px; max-width:400px; width:90%; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
        <h3 style="margin-bottom:8px;">Eliminar proyecto</h3>
        <p style="color:#6A737B; margin-bottom:24px;">
            ¿Seguro que quieres eliminar <strong id="modal-nombre"></strong>? Esta acción no se puede deshacer.
        </p>
        <div style="display:flex; justify-content:flex-end; gap:8px;">
            <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            <form id="modal-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<script>
    function abrirModal(id, nombre) {
        document.getElementById('modal-nombre').textContent = nombre;
        document.getElementById('modal-form').action = '/admin/proyectos/' + id;
        const modal = document.getElementById('modal-eliminar');
        modal.style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('modal-eliminar').style.display = 'none';
    }

    document.getElementById('modal-eliminar').addEventListener('click', function(e) {
        if (e.target === this) cerrarModal();
    });
</script>
@endsection