<?php $__env->startSection('content'); ?>
        <h1>Listado de usuarios</h1>

        <a href="<?php echo e(url('/admin/usuarios/create')); ?>">
            Crear usuario
        </a>


        <?php if($usuarios->isEmpty()): ?>
            <p>No hay usuarios en la base de datos.</p>
        <?php else: ?>
            <ul>

                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <?php echo e($usuario->name); ?> — <?php echo e($usuario->email); ?>


                        <?php if($usuario->activo): ?>
                            <span>(Activo)</span>
                        <?php else: ?>
                            <span>(Inactivo)</span>
                        <?php endif; ?>

                        <a href="<?php echo e(route('admin.usuarios.edit', $usuario->id)); ?>">Editar</a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vespertino\Documents\proyecto-intermodular\backend\resources\views/admin/usuarios/index.blade.php ENDPATH**/ ?>