@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('admin.usuarios.update', $usuario->id) }}">
    @csrf
    @method('PUT')

    <label>Rol</label>
    <select name="rol">
        <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="usu" {{ $usuario->rol == 'usu' ? 'selected' : '' }}>Usuario</option>
    </select>

    <label>Activo</label>
    <select name="activo">
        <option value="1" {{ $usuario->activo ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ !$usuario->activo ? 'selected' : '' }}>No</option>
    </select>

    <button type="submit">Guardar</button>
</form>
@endsection