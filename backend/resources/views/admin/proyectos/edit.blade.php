@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
<link rel="stylesheet" href="{{ asset('css/details.css') }}">
@endpush

@section('content')
<div class="proyectos-form-page">

    {{-- Cabecera --}}
    <div class="proyectos-header">
        <div class="proyectos-title">
            <h1>Editar proyecto</h1>
            <p>Modifica los campos que desees actualizar</p>
        </div>
    </div>

    {{-- Errores --}}
    @if ($errors->any())
    <div class="alert-danger">
        <div class="alert-danger-header">
            <span class="material-icons" style="font-size: 18px; color: var(--color-danger);"></span>
            <strong>Corrige los siguientes errores:</strong>
        </div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Formulario --}}
    <div class="proyectos-form">
        <form method="POST"
            action="{{ route('admin.proyectos.update', $proyecto->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="form-field mb-3">
                <label class="form-label d-block">Nombre</label>
                <input type="text"
                    name="nombre"
                    style="width: 600px"
                    maxlength="100"
                    value="{{ old('nombre', $proyecto->nombre) }}">
            </div>

            {{-- Descripción --}}
            <div class="form-field mb-3">
                <label class="form-label d-block">Descripción</label>
                <textarea name="descripcion"
                    style="width: 600px; resize: vertical; max-height: 200px;"
                    rows="5"
                    minlength="25"
                    maxlength="200">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
            </div>

            {{-- Ciclo --}}
            <div class="mb-3">
                <label class="form-label d-block">Ciclo formativo</label>

                <select name="ciclo">

                    <option value="">Selecciona un ciclo</option>

                    <option value="DAW"
                        @selected(str_contains(old('ciclo', $proyecto->ciclo), 'DAW') && str_contains(old('ciclo', $proyecto->ciclo), '1'))>
                        Desarrollo de Aplicaciones Web
                    </option>

                    <option value="DAM"
                        @selected(str_contains(old('ciclo', $proyecto->ciclo), 'DAM') && str_contains(old('ciclo', $proyecto->ciclo), '1'))>
                        Desarrollo de Aplicaciones Multiplataforma
                    </option>

                    <option value="ASIR"
                        @selected(str_contains(old('ciclo', $proyecto->ciclo), 'ASIR') && str_contains(old('ciclo', $proyecto->ciclo), '1'))>
                        Administración de Sistemas Informáticos en Red
                    </option>

                    <option value="AF"
                        @selected(str_contains(old('ciclo', $proyecto->ciclo), 'AF') && str_contains(old('ciclo', $proyecto->ciclo), '1'))>
                        Administración y Finanzas
                    </option>

                    <option value="AD"
                        @selected(str_contains(old('ciclo', $proyecto->ciclo), 'AD') && str_contains(old('ciclo', $proyecto->ciclo), '1'))>
                        Asistencia a la Dirección
                    </option>

                    <option value="AUT"
                        @selected(str_contains(old('ciclo', $proyecto->ciclo), 'AUT') && str_contains(old('ciclo', $proyecto->ciclo), '1'))>
                        Automoción
                    </option>


                </select>
            </div>

            {{-- Año --}}
            <div class="form-field mb-3">
                <label class="form-label d-block">Año académico</label>
                <select name="anio">
                    <option value="">Selecciona un curso</option>
                    <option value="2023/2024" @selected(old('anio', $proyecto->anio) == '2022/2023')>2022/2023</option>
                    <option value="2023/2024" @selected(old('anio', $proyecto->anio) == '2023/2024')>2023/2024</option>
                    <option value="2024/2025" @selected(old('anio', $proyecto->anio) == '2024/2025')>2024/2025</option>
                    <option value="2025/2026" @selected(old('anio', $proyecto->anio) == '2025/2026')>2025/2026</option>
                </select>
            </div>

            {{-- Alumno --}}
            <div class="form-field mb-3">
                <label class="form-label d-block">Alumnos</label>
                <div id="alumnos-wrapper" class="d-flex gap-1 flex-wrap">
                    @foreach($proyecto->alumnos as $index => $alumno)
                    <input type="text"
                        class="mb-1"
                        name="alumnos[]"
                        value="{{ $alumno }}">
                    @endforeach
                </div>

                <button type="button" class="btn btn-sm btn-outline-dark" onclick="addAlumno()">
                    ➕
                </button>

                <script>
                    function addAlumno() {
                        const wrapper = document.getElementById('alumnos-wrapper');
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'alumnos[]';
                        input.className = 'mb-1';
                        wrapper.appendChild(input);
                    }
                </script>
            </div>

            {{-- Vídeo --}}
            <div class="mb-3">
                <label class="form-label d-block">Cambiar vídeo del proyecto</label>
                <label class="dropzone-video" for="input-video">
                    <span class="dropzone__icon">🎬</span>
                    <span><span class="dropzone__link">Selecciona un vídeo</span> o arrástralo aquí</span>
                    <input id="input-video" type="file" name="video" accept="video/*" style="display:none">
                </label>
            </div>

            {{-- Tags --}}
            <div class="form-field mb-3">
                <label class="form-label d-block">Tags</label>
                <div id="tags-wrapper" class="d-flex gap-1 flex-wrap">
                    @foreach($proyecto->tags as $index => $tag)
                    <input type="text"
                        name="tags[]"
                        class="mb-1"
                        value="{{ $tag }}">
                    @endforeach
                </div>

                <button type="button" class="btn btn-sm btn-outline-dark" onclick="addTag()">
                    ➕
                </button>

                <div class="form-text">Separados por comas</div>

                <script>
                    function addTag() {
                        const wrapper = document.getElementById('tags-wrapper');
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'tags[]';
                        input.className = 'mb-1';
                        wrapper.appendChild(input);
                    }
                </script>
            </div>

            {{-- Documentos --}}
            @if(!empty($proyecto->documentos))
            <div class="mb-3">
                <label class="form-label d-block">Documentos actuales</label>

                <ul class="list-group" id="lista-documentos">
                    @foreach($proyecto->documentos as $doc)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ basename($doc) }}</span>

                        <button type="button"
                            class="btn btn-sm btn-outline-danger"
                            onclick="marcarParaBorrar(this, '{{ $doc }}')">
                            🗑️
                        </button>
                    </li>
                    @endforeach
                </ul>

                <small class="text-muted">
                    Los documentos se eliminarán al guardar los cambios
                </small>
            </div>
            @endif

            <div class="mb-3">
                <label class="form-label d-block">Añadir documentos</label>
                <label class="dropzone-docs" for="input-docs">
                    <span class="dropzone__icon">📄</span>
                    <span><span class="dropzone__link">Selecciona los PDFs</span> o arrástralos aquí</span>
                    <input id="input-docs" type="file" name="documentos[]" multiple style="display:none">
                </label>
            </div>

            <script>
                function marcarParaBorrar(boton, documento) {
                    // Quitar de la lista visual
                    boton.closest('li').remove();

                    // Añadir input oculto REAL
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'documentos_eliminar[]';
                    input.value = documento;

                    document.querySelector('form').appendChild(input);
                }
            </script>

            {{-- Botones --}}
            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('admin.proyectos.show', $proyecto->id) }}" class="btn btn-secondary">
                    Cancelar
                </a>
                <button class="btn btn-primary">Guardar cambios</button>
            </div>

        </form>
    </div>
</div>
@endsection