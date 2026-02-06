<form method="POST" action="{{ route('admin.usuarios.update', $usuario->id) }}">
    @csrf
    @method('PUT')

    <label>Rol</label>
    <select name="rol">
        <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="alumno" {{ $usuario->rol == 'alumno' ? 'selected' : '' }}>Alumno</option>
    </select>

    <label>Activo</label>
    <select name="activo">
        <option value="1" {{ $usuario->activo ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ !$usuario->activo ? 'selected' : '' }}>No</option>
    </select>

    <button type="submit">Guardar</button>
</form>
