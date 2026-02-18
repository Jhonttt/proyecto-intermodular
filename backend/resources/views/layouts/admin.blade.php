@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Panel de Administración</h1>
    <div class="badge bg-primary fs-5">Total Proyectos: 154</div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active">Proyectos Pendientes</a>
            <a href="#" class="list-group-item list-group-item-action">Gestionar Usuarios</a>
            <a href="#" class="list-group-item list-group-item-action">Configuración Ciclos</a>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-white"><strong>Validación de TFGs</strong></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Proyecto</th>
                            <th>Alumno</th>
                            <th>Ciclo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>05/02/2026</td>
                            <td>App de Nutrición AI</td>
                            <td>Marta García</td>
                            <td>DAM</td>
                            <td>
                                <button class="btn btn-sm btn-success">Validar</button>
                                <button class="btn btn-sm btn-danger">Rechazar</button>
                            </td>
                        </tr>
                        {{-- Más filas --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection