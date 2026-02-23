<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
<link rel="stylesheet" href="<?php echo e(asset('css/users.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="usuarios-page">

    
    <div class="usuarios-header">
        <div class="usuarios-header-text">
            <h1 style="margin-bottom: 4px;">Usuarios</h1>
            <p>Gestiona los usuarios del sistema</p>
        </div>
        <a href="<?php echo e(route('admin.usuarios.create')); ?>" class="btn btn-primary">
            Crear usuario
        </a>
    </div>

    
    <?php if(session('success')): ?>
    <div class="alert-success">
        <span class="material-icons" style="font-size: 18px;">check_circle</span>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert-danger" style="display:flex; align-items:center; gap:8px;">
        <span class="material-icons" style="font-size: 18px;">error</span>
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    
    <form method="GET" class="d-flex gap-2 flex-wrap mb-3">
        <input
            type="text"
            name="search"
            class="input"
            style="width: auto; flex: 1; min-width: 200px;"
            placeholder="Buscar por nombre o email..."
            value="<?php echo e(request('search')); ?>">
        <select name="rol" class="input" style="width: auto;">
            <option value="">Todos los roles</option>
            <option value="admin" <?php echo e(request('rol') === 'admin' ? 'selected' : ''); ?>>Admin</option>
            <option value="usu" <?php echo e(request('rol') === 'usu' ? 'selected' : ''); ?>>Usuario</option>
        </select>
        <select name="activo" class="input" style="width: auto;">
            <option value="">Todos los estados</option>
            <option value="1" <?php echo e(request('activo') === '1' ? 'selected' : ''); ?>>Activo</option>
            <option value="0" <?php echo e(request('activo') === '0' ? 'selected' : ''); ?>>Inactivo</option>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="btn btn-secondary">Limpiar</a>
    </form>

    <?php if($usuarios->isEmpty()): ?>
    <div class="usuarios-empty">
        <span class="material-icons">group</span>
        <p>No hay usuarios que coincidan con los filtros.</p>
    </div>

    <?php else: ?>

    <div class="usuarios-panel">
        <div class="usuarios-panel-bar">
            <?php echo e($usuarios->total()); ?> usuario<?php echo e($usuarios->total() !== 1 ? 's' : ''); ?> encontrado<?php echo e($usuarios->total() !== 1 ? 's' : ''); ?>

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
                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="col-nombre"><?php echo e($usuario->name); ?></td>
                    <td class="col-email"><?php echo e($usuario->email); ?></td>
                    <td>
                        <?php if($usuario->rol === 'admin'): ?>
                        <span class="badge badge-admin">
                            <span class="material-icons" style="font-size: 12px;">shield</span>
                            Admin
                        </span>
                        <?php else: ?>
                        <span class="badge badge-usuario">
                            <span class="material-icons" style="font-size: 12px;">person</span>
                            Usuario
                        </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($usuario->activo): ?>
                        <span class="badge badge-activo">
                            <span class="badge-dot"></span>
                            Activo
                        </span>
                        <?php else: ?>
                        <span class="badge badge-inactivo">
                            <span class="badge-dot"></span>
                            Inactivo
                        </span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center" style="display: flex; gap: 8px; justify-content: flex-center; justify-content: center;">
                        <a href="<?php echo e(route('admin.usuarios.edit', $usuario->id)); ?>" class="btn btn-primary"
                            style="font-size: 12px; padding: 6px 14px;">
                            Editar
                        </a>
                        <button type="button" class="btn btn-danger" style="font-size: 12px; padding: 6px 14px;"
                            onclick="abrirModal('<?php echo e($usuario->id); ?>', '<?php echo e($usuario->name); ?>')">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        
        <?php if($usuarios->lastPage() > 1): ?>
        <div class="d-flex justify-content-between align-items-center p-3">
            <small class="text-muted">
                Mostrando <?php echo e($usuarios->firstItem()); ?>–<?php echo e($usuarios->lastItem()); ?> de <?php echo e($usuarios->total()); ?> usuarios
            </small>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item <?php echo e($usuarios->onFirstPage() ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e($usuarios->previousPageUrl()); ?>">«</a>
                    </li>
                    <?php $__currentLoopData = $usuarios->getUrlRange(1, $usuarios->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="page-item <?php echo e($page == $usuarios->currentPage() ? 'active' : ''); ?>">
                        <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="page-item <?php echo e(!$usuarios->hasMorePages() ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e($usuarios->nextPageUrl()); ?>">»</a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>

    <?php endif; ?>
</div>


<div id="modal-eliminar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:8px; padding:24px; max-width:400px; width:90%; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
        <h3 style="margin-bottom:8px;">Eliminar usuario</h3>
        <p style="color:#6A737B; margin-bottom:24px;">
            ¿Seguro que quieres eliminar a <strong id="modal-nombre"></strong>? Esta acción no se puede deshacer.
        </p>
        <div style="display:flex; justify-content:flex-end; gap:8px;">
            <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            <form id="modal-form" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Renzito\Desktop\proyecto-intermodular\backend\resources\views/admin/usuarios/index.blade.php ENDPATH**/ ?>