<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de usuarios</h1>
        <a href="<?php echo e(route('admin.usuarios.create')); ?>" class="btn btn-primary">
            Crear usuario
        </a>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($usuarios->isEmpty()): ?>
        <div class="alert alert-info">
            No hay usuarios en la base de datos.
        </div>
    <?php else: ?>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
</thead>

                    <tbody>
                        <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
    <td><?php echo e($usuario->name); ?></td>
    <td><?php echo e($usuario->email); ?></td>

    <td>
        <?php if($usuario->rol === 'admin'): ?>
            <span class="badge bg-primary">Admin</span>
        <?php else: ?>
            <span class="badge bg-secondary">Usuario</span>
        <?php endif; ?>
    </td>

    <td>
        <?php if($usuario->activo): ?>
            <span class="badge bg-success">Activo</span>
        <?php else: ?>
            <span class="badge bg-danger">Inactivo</span>
        <?php endif; ?>
    </td>

    <td>
        <a href="<?php echo e(route('admin.usuarios.edit', $usuario->id)); ?>"
           class="btn btn-sm btn-warning">
            Editar
        </a>
    </td>
</tr>
 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vespertino\Documents\proyecto-intermodular\backend\resources\views/admin/usuarios/index.blade.php ENDPATH**/ ?>