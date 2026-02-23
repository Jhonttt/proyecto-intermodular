@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
<link rel="stylesheet" href="{{ asset('css/not-found.css') }}">
@endpush

@section('content')

<div class="not-found-page">
    <span class="material-icons not-found-icon">search_off</span>
    <h1 class="not-found-code">404</h1>
    <h2 class="not-found-title">Página no encontrada</h2>
    <p class="not-found-text">
        La página que buscas no existe o no tienes permisos para acceder a ella.
    </p>
    <a href="{{ url('/admin/proyectos') }}" class="btn btn-primary">← Volver al inicio</a>
</div>

@endsection