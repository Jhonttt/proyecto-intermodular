<h1>Listado de proyectos</h1>

<form method="GET">
    <input type="text" name="nombre" placeholder="Blog educativo" value="<?php echo e(request('nombre')); ?>">
    <input type="text" name="curso" placeholder="DAW 2º" value="<?php echo e(request('curso')); ?>">
    <input type="text" name="alumno" placeholder="Juan Pérezº" value="<?php echo e(request('alumnos')); ?>">
    <button type="submit">Filtrar</button>
</form>

<hr>

<?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p>
        <?php echo e($proyecto->nombre); ?> |
        <?php echo e($proyecto->curso); ?> |
        <?php echo e($proyecto->alumnos); ?>

    </p>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\Users\vespertino\Desktop\proyectoClase\proyecto-intermodular\backend\resources\views/admin/proyectos/index.blade.php ENDPATH**/ ?>