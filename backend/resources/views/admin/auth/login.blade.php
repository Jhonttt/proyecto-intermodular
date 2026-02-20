@extends('layouts.app')

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

@section('content')

    <div class="login-center">

        <div class="container">

            <div class="card login-box">
                <h1>Administración</h1>


                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    {{-- Mensajes de error de sesión --}}
                    @if (session('error'))
                        <div
                            style="border-color: var(--danger); background-color: #fdf2f2; margin-bottom: var(--block-spacing);">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span class="material-symbols-outlined md-16 icon-danger">error</span>
                                <small style="color: var(--danger);">{{ session('error') }}</small>
                            </div>
                        </div>
                    @endif

                    {{-- Errores de validación --}}
                    @if ($errors->any())
                        <div
                            style="border-color: var(--danger); background-color: #fdf2f2; margin-bottom: var(--block-spacing);">
                            @foreach ($errors->all() as $error)
                                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                                    <span class="material-symbols-outlined md-16 icon-danger">error</span>
                                    <small style="color: var(--danger);">{{ $error }}</small>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div style="margin-bottom: var(--spacing-md)">
                        <label for="correo"
                            style="display: block; margin-bottom: 5px; font-weight: var(--font-weight-medium);">Correo
                            Electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="{{ $errors->has('email') ? 'input-error' : '' }} input" placeholder="ejemplo@correo.com"
                            required>
                    </div>

                    <div style="margin-bottom: var(--spacing-md);">
                        <label for="passwd"
                            style="display: block; margin-bottom: 5px; font-weight: var(--font-weight-medium);">Contraseña</label>
                        <input id="password" type="password" name="password"
                            class="{{ $errors->has('password') ? 'input-error' : '' }} input" placeholder="********"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <span class="material-symbols-outlined md-16" style="margin-right: 6px;">login</span>
                        Iniciar sesión
                    </button>

                </form>
            </div>

        </div>
    </div>
@endsection
