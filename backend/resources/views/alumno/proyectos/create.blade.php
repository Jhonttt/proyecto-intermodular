@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h2 class="mb-4">Subir nuevo proyecto</h2>

        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('alumno.proyectos.store') }}" method="POST" enctype="multipart/form-data">
            
            @csrf

            {{-- Nombre --}}
            <div class="mb-3">
                <label class="form-label">Nombre del proyecto</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            {{-- Resumen --}}
            <div class="mb-3">
                <label class="form-label">Resumen</label>
                <input type="text" name="resumen" class="form-control" value="{{ old('resumen') }}" required>
            </div>

            {{-- Descripción --}}
            <div class="mb-3">
                <label class="form-label">Descripción completa</label>
                <textarea name="descripción" class="form-control" rows="5" required>{{ old('descripción') }}</textarea>
            </div>

            {{-- Curso --}}
            <div class="mb-3">
                <label class="form-label">Curso académico</label>
                <select name="curso" class="form-select" required>
                    <option value="">-- Selecciona un curso --</option>
                    <option value="2023/2024" @selected(old('curso') == '2023/2024')>2023/2024</option>
                    <option value="2024/2025" @selected(old('curso') == '2024/2025')>2024/2025</option>
                    <option value="2025/2026" @selected(old('curso') == '2025/2026')>2025/2026</option>
                </select>
            </div>

            {{-- Alumnos --}}
            <div class="mb-3">
                <label class="form-label">Alumnos participantes</label>
                <textarea name="alumnos" class="form-control" rows="3"
                    placeholder="Ej: Nombre1 Apellido1, Nombre2 Apellido2..." required>{{ old('alumnos') }}</textarea>
            </div>

            {{-- Vídeo --}}
            <div class="mb-3">
                <label class="form-label">URL del vídeo</label>
                <input type="url" name="video_url" class="form-control" value="{{ old('video_url') }}">
            </div>

            <!-- Archivo -->
            <div class="mb-3">
                <label class="form-label">Archivo del proyecto</label>
                <input type="file" name="archivo" class="form-control" required>
                <div class="form-text">
                    Máximo 30MB
                </div>
            </div>


            <button type="submit" class="btn btn-primary">
                @csrf
                Enviar proyecto
            </button>

        </form>
    </div>
@endsection