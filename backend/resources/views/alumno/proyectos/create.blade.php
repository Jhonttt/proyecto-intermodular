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
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required maxlength="100">
            </div>

            {{-- Resumen --}}

            <div class="mb-3">
                <label class="form-label">Resumen</label>
                <input type="text" name="resumen" class="form-control" value="{{ old('resumen') }}" required>
            </div>

            {{-- Descripcion --}}

            <div class="mb-3">
                <label class="form-label">Descripción completa</label>
                <textarea name="descripcion" class="form-control" rows="5" required minlength="25" maxlength="200" style="resize: none;">{{ old('descripcion') }}</textarea>
            </div>

            {{-- Curso --}}

            <div class="mb-3">
                <label class="form-label">Curso académico</label>
                <select name="curso" class="form-select" required>
                    <option value="">Selecciona un curso</option>
                    <option value="2023/2024" @selected(old('curso') == '2023/2024')>2023/2024</option>
                    <option value="2024/2025" @selected(old('curso') == '2024/2025')>2024/2025</option>
                    <option value="2025/2026" @selected(old('curso') == '2025/2026')>2025/2026</option>
                </select>
            </div>

            {{-- Ciclo formativo --}}

            <div class="mb-3">
                <label class="form-label">Ciclo formativo</label>

                <select name="ciclo" class="form-select" required>
                    <option value="">Selecciona un ciclo</option>

                    <option value="DAW" @selected(old('ciclo') == 'DAW')>
                        Desarrollo de Aplicaciones Web
                    </option>

                    <option value="DAM" @selected(old('ciclo') == 'DAM')>
                        Desarrollo de Aplicaciones Multiplataforma
                    </option>

                    <option value="ASIR" @selected(old('ciclo') == 'ASIR')>
                        Administración de Sistemas Informáticos en Red
                    </option>

                    <option value="AF" @selected(old('ciclo') == 'AF')>
                        Administración y Finanzas
                    </option>

                    <option value="AD" @selected(old('ciclo') == 'AD')>
                        Asistencia a la Dirección
                    </option>

                    <option value="AUT" @selected(old('ciclo') == 'AUT')>
                        Automoción
                    </option>
                </select>
            </div>

            {{-- Alumnos --}}

            <div class="mb-3">
                <label class="form-label">Alumnos participantes</label>
                <textarea name="alumnos" class="form-control" rows="3"
                    placeholder="Ej: Nombre1 Apellido1, Nombre2 Apellido2..." required style="resize: none;">{{ old('alumnos') }}</textarea>
            </div>

            {{-- Tags (opcional) --}}

            <div class="mb-3">
                <label class="form-label">Tags (opcional, máximo 5)</label>
                <input type="text" name="tags" class="form-control" value="{{ old('tags') }}" placeholder="Laravel, Angular...">
                <div class="form-text">
                    Separados por comas (máximo 5)
                </div>
            </div>

            {{-- Vídeo --}} 

            <div class="mb-3">
                <label class="form-label">Vídeo del proyecto</label>
                <input type="file" name="video" class="form-control" accept="video/*" required>
                <div class="form-text">
                    Máximo 30MB
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Archivo del proyecto (opcional)</label>
                <input type="file" name="archivo" class="form-control">
                <div class="form-text">
                    Máximo 30MB
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Enviar proyecto
            </button>

        </form>
    </div>
@endsection