<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">


<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Listado de proyectos</h1>
    <div class="badge bg-primary fs-5">Total Proyectos: <?php echo e($proyectos->count()); ?></div>
</div>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
        <input type="text" name="nombre" class="form-control" placeholder="Blog educativo" value="<?php echo e(request('nombre')); ?>">
    </div>
    <div class="col-md-3">
        <input type="text" name="curso" class="form-control" placeholder="DAW 2º" value="<?php echo e(request('curso')); ?>">
    </div>
    <div class="col-md-3">
        <input type="text" name="alumno" class="form-control" placeholder="Juan Pérez" value="<?php echo e(request('alumnos')); ?>">
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
    </div>
</form>

<hr>


<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Curso</th>
                <th>Alumno</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($proyecto->nombre); ?></td>
                    <td><?php echo e($proyecto->curso); ?></td>
                    <td><?php echo e($proyecto->alumnos); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vespertino\Desktop\proyectoClase\proyecto-intermodular\backend\resources\views/admin/proyectos/index.blade.php ENDPATH**/ ?>