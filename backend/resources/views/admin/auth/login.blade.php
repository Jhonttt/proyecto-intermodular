@extends('layouts.app')

@section('content')

    <head>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    </head>
    <div class="main-container" style="display: flex; justify-content: center; padding-top: 60px;">
        <div style="width: min(480px, 100%);">

            <h1>Login Admin</h1>

            {{-- Mensajes de error de sesión --}}
            @if (session('error'))
                <div class="card"
                    style="border-color: var(--danger); background-color: #fdf2f2; margin-bottom: var(--block-spacing);">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span class="material-symbols-outlined md-16 icon-danger">error</span>
                        <small style="color: var(--danger);">{{ session('error') }}</small>
                    </div>
                </div>
            @endif

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="card"
                    style="border-color: var(--danger); background-color: #fdf2f2; margin-bottom: var(--block-spacing);">
                    @foreach ($errors->all() as $error)
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                            <span class="material-symbols-outlined md-16 icon-danger">error</span>
                            <small style="color: var(--danger);">{{ $error }}</small>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="card">
                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div style="margin-bottom: 8px;">
                        <label for="email"
                            style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 4px;">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="{{ $errors->has('email') ? 'input-error' : '' }}" style="width: 95%;" required>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label for="password"
                            style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 4px;">Contraseña</label>
                        <input id="password" type="password" name="password"
                            class="{{ $errors->has('password') ? 'input-error' : '' }}" style="width: 95%;" required >
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <span class="material-symbols-outlined md-16" style="margin-right: 6px;">login</span>
                        Iniciar sesión
                    </button>

                </form>
            </div>

        </div>
    </div>
@endsection
