@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/proyecto-show.css') }}">
@endsection

@section('content')
    <div class="container details">
        <article class="card details-card mt-5" id="details-form-container">

            {{-- Header: Título + Descripción + Ciclo/Año + Estado --}}
            <div class="card__header">
                <div>
                    <h1 class="card__title">{{ $proyecto->nombre }}</h1>

                    @if($proyecto->resumen)
                        <p class="text" style="margin-bottom: 8px;">
                            <em>{{ $proyecto->resumen }}</em>
                        </p>
                    @endif

                    <p class="text" style="white-space: pre-wrap">{{ $proyecto->descripcion }}</p>
                </div>

                <section class="section section--curso">
                    <p class="text"><b>Ciclo:</b> {{ $proyecto->ciclo }}</p>
                    <p class="text"><b>Año:</b> {{ $proyecto->anio }}</p>
                </section>

                @if($proyecto->checked)
                    <span class="estado-badge estado-badge--validado">✔ Validado</span>
                @else
                    <span class="estado-badge estado-badge--pendiente">⏳ Pendiente</span>
                @endif
            </div>

            <hr class="divider" />

            {{-- Alumnos --}}
            <section class="section">
                <h3 class="text">
                    <b>Autores:</b>
                    @foreach($proyecto->alumnos as $alumno)
                        {{ $alumno }}@if(!$loop->last), @endif
                    @endforeach
                </h3>
            </section>

            <hr class="divider" />

            {{-- Video --}}
            @if($proyecto->video_public_url)
                <section class="section">
                    <h3 class="text-center mb-3 mt-3">Video del Proyecto</h3>
                    <div class="mb-4 d-flex justify-content-center">
                        <video controls preload="metadata" style="max-width:640px; width:100%; height:auto; border-radius:8px;">
                            <source src="{{ $proyecto->video_public_url }}" type="video/mp4">
                            Tu navegador no soporta vídeo HTML5.
                        </video>
                    </div>
                </section>
                <hr class="divider" />
            @endif

            {{-- Documentos --}}
            @if($proyecto->documentos_public && count($proyecto->documentos_public) > 0)
                <section class="section">
                    <h3 class="section__title"><b>Documentos adjuntos</b></h3>
                    <ul class="list">
                        @foreach($proyecto->documentos_public as $doc)
                            <li class="list__item">
                                <a href="{{ $doc['url'] }}" target="_blank" download>
                                    📄 {{ $doc['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </section>
                <hr class="divider" />
            @endif

            {{-- Tags --}}
            @if(!empty($proyecto->tags))
                <section class="section">
                    <h3 class="section__title"><b>Tecnologías y Etiquetas</b></h3>
                    <ul class="tag-list">
                        @foreach($proyecto->tags as $tag)
                            <li class="tech-tag">{{ $tag }}</li>
                        @endforeach
                    </ul>
                </section>
                <hr class="divider" />
            @endif

            {{-- Observaciones --}}
            <section class="section">
                <h3 class="section__title"><b>Observaciones</b></h3>
                @if($proyecto->checked && $proyecto->observaciones && $proyecto->observaciones !== 'null')
                    <div class="alert alert-info">
                        <p class="text" style="white-space: pre-wrap">{{ $proyecto->observaciones }}</p>
                    </div>
                @else
                    {{ $proyecto->checked ? 'disabled' : '' }}
                    <p class="p-3 rounded" style="background-color: #cff4fc;">
                        {{ old('observaciones', $proyecto->observaciones !== 'null' ? $proyecto->observaciones : '') }}
                    </p>
                    @if($proyecto->checked)
                        <p class="form-hint">Para modificar las observaciones, cambia el proyecto a pendiente.</p>
                    @endif
                @endif
            </section>

            <hr class="divider" />

            {{-- Metadatos --}}
            <section class="section">
                <h3 class="section__title"><b>Información del Sistema</b></h3>
                <dl class="meta">
                    <div class="meta__row">
                        <dt>ID del Proyecto</dt>
                        <dd>#{{ $proyecto->id }}</dd>
                    </div>
                    <div class="meta__row">
                        <dt>Fecha de Creación</dt>
                        <dd>{{ $proyecto->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div class="meta__row">
                        <dt>Última Actualización</dt>
                        <dd>{{ $proyecto->updated_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>
            </section>

            <hr class="divider" />

            {{-- Acciones --}}
            <footer class="mb-5">

                <div class="mt-3 d-flex gap-2 justify-content-center flex-wrap">
                    @if(!$proyecto->checked)
                        <form id="form-validar" method="POST" action="{{ route('admin.proyectos.check', $proyecto->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="observaciones" id="obs-hidden">
                            <button type="button" class="btn btn-submit" onclick="validarProyecto()">
                                ✔ Validar
                            </button>
                        </form>

                        <a href="{{ route('admin.proyectos.edit', $proyecto->id) }}" class="btn btn-primary">
                            ✏ Editar
                        </a>

                        <form method="POST" action="{{ route('admin.proyectos.destroy', $proyecto->id) }}"
                            onsubmit="return confirm('¿Seguro que deseas eliminar este proyecto?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">🗑 Eliminar</button>
                        </form>

                    @else

                        <form method="POST" action="{{ route('admin.proyectos.uncheck', $proyecto->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger">↩ Volver a revisar</button>
                        </form>

                    @endif

                    <a href="{{ route('admin.proyectos.index') }}" class="btn btn-warning">← Volver </a>
                </div>
            </footer>

        </article>
    </div>

    <script>
        function validarProyecto() {
            const textarea = document.getElementById('observaciones');
            const hidden = document.getElementById('obs-hidden');
            if (textarea) hidden.value = textarea.value;
            document.getElementById('form-validar').submit();
        }
    </script>
@endsection