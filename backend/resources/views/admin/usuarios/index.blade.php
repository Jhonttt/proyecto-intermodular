@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('content')
<div class="usuarios-page">

    {{-- Cabecera --}}
    <div class="usuarios-header">
        <div class="usuarios-header-text">
            <h1 style="margin-bottom: 4px;">Usuarios</h1>
            <p>Gestiona los usuarios del sistema</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
            Crear usuario
        </a>
    </div>

    {{-- Mensaje success --}}
    @if (session('success'))
    <div class="alert-success">
        <span class="material-icons" style="font-size: 18px;">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert-danger" style="display:flex; align-items:center; gap:8px;">
        <span class="material-icons" style="font-size: 18px;">error</span>
        {{ session('error') }}
    </div>
    @endif

    {{-- Filtros --}}
    <form method="GET" class="d-flex gap-2 flex-wrap mb-3">
        <input
            type="text"
            name="search"
            class="input"
            style="width: auto; flex: 1; min-width: 200px;"
            placeholder="Buscar por nombre o email..."
            value="{{ request('search') }}">
        <select name="rol" class="input" style="width: auto;">
            <option value="">Todos los roles</option>
            <option value="admin" {{ request('rol') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="usu" {{ request('rol') === 'usu' ? 'selected' : '' }}>Usuario</option>
        </select>
        <select name="activo" class="input" style="width: auto;">
            <option value="">Todos los estados</option>
            <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Limpiar</a>
    </form>

    @if ($usuarios->isEmpty())
    <div class="usuarios-empty">
        <span class="material-icons">group</span>
        <p>No hay usuarios que coincidan con los filtros.</p>
    </div>

    @else

    <div class="usuarios-panel">
        <div class="usuarios-panel-bar">
            {{ $usuarios->total() }} usuario{{ $usuarios->total() !== 1 ? 's' : '' }} encontrado{{ $usuarios->total() !== 1 ? 's' : '' }}
        </div>

        <table class="usuarios-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr>
                    <td class="col-nombre">{{ $usuario->name }}</td>
                    <td class="col-email">{{ $usuario->email }}</td>
                    <td>
                        @if ($usuario->rol === 'admin')
                        <span class="badge badge-admin">
                            <span class="material-icons" style="font-size: 12px;">shield</span>
                            Admin
                        </span>
                        @else
                        <span class="badge badge-usuario">
                            <span class="material-icons" style="font-size: 12px;">person</span>
                            Usuario
                        </span>
                        @endif
                    </td>
                    <td>
                        @if ($usuario->activo)
                        <span class="badge badge-activo">
                            <span class="badge-dot"></span>
                            Activo
                        </span>
                        @else
                        <span class="badge badge-inactivo">
                            <span class="badge-dot"></span>
                            Inactivo
                        </span>
                        @endif
                    </td>
                    <td class="text-center" style="display: flex; gap: 8px; justify-content: flex-center; justify-content: center;">
                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-primary"
                            style="font-size: 12px; padding: 6px 14px;">
                            Editar
                        </a>
                        <button type="button" class="btn btn-danger" style="font-size: 12px; padding: 6px 14px;"
                            onclick="abrirModal('{{ $usuario->id }}', '{{ $usuario->name }}')">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginación --}}
        @if ($usuarios->lastPage() > 1)
        <div class="d-flex justify-content-between align-items-center p-3">
            <small class="text-muted">
                Mostrando {{ $usuarios->firstItem() }}–{{ $usuarios->lastItem() }} de {{ $usuarios->total() }} usuarios
            </small>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item {{ $usuarios->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $usuarios->previousPageUrl() }}">«</a>
                    </li>
                    @foreach ($usuarios->getUrlRange(1, $usuarios->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $usuarios->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                    @endforeach
                    <li class="page-item {{ !$usuarios->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $usuarios->nextPageUrl() }}">»</a>
                    </li>
                </ul>
            </nav>
        </div>
        @endif
    </div>

    @endif
</div>

{{-- Modal confirmación --}}
<div id="modal-eliminar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:8px; padding:24px; max-width:400px; width:90%; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
        <h3 style="margin-bottom:8px;">Eliminar usuario</h3>
        <p style="color:#6A737B; margin-bottom:24px;">
            ¿Seguro que quieres eliminar a <strong id="modal-nombre"></strong>? Esta acción no se puede deshacer.
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
        document.getElementById('modal-form').action = '/admin/usuarios/' + id + '/destroy';
        const modal = document.getElementById('modal-eliminar');
        modal.style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('modal-eliminar').style.display = 'none';
    }

    // Cerrar al hacer click fuera
    document.getElementById('modal-eliminar').addEventListener('click', function(e) {
        if (e.target === this) cerrarModal();
    });
</script>
@endsection