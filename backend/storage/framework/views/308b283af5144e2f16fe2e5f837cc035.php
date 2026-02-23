<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
<link rel="stylesheet" href="<?php echo e(asset('css/users.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container text-center mt-5">

    <h1 class="mb-4">Listado de proyectos</h1>

    <form method="GET" class="d-flex justify-content-center gap-2 flex-wrap">
        <input type="text" name="nombre" class="form-control w-auto" placeholder="Blog educativo"
            value="<?php echo e(request('nombre')); ?>">

        <input type="text" name="curso" class="form-control w-auto" placeholder="DAW 2º" value="<?php echo e(request('ciclo')); ?>">

        <input type="text" name="alumnos" class="form-control w-auto" placeholder="Juan Pérez"
            value="<?php echo e(request('alumnos')); ?>">

        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

</div>

<div class="table-responsive container-fluid mt-3">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Ciclo</th>
                <th>Año</th>
                <th>Alumnos</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><a href="<?php echo e(route('admin.proyectos.show', $proyecto->id)); ?>"><?php echo e($proyecto->nombre); ?></a></td>
                <td><?php echo e($proyecto->ciclo); ?></td>
                <td><?php echo e($proyecto->anio); ?></td>
                <td>
                    <?php $__currentLoopData = $proyecto->alumnos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($alumno); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td>
                    <?php if($proyecto->checked): ?>
                    <span class="badge badge-activo">
                        Verificado
                    </span>
                    <?php else: ?>
                    <span class="badge badge-inactivo">
                        Pendiente
                    </span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    
    <div class="d-flex justify-content-between align-items-center mt-3 px-2 mb-3">
        <small class="text-muted">
            Mostrando <?php echo e($proyectos->firstItem()); ?>–<?php echo e($proyectos->lastItem()); ?> de <?php echo e($proyectos->total()); ?> proyectos
        </small>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                
                <?php if($proyectos->onFirstPage()): ?>
                <li class="page-item disabled"><span class="page-link">«</span></li>
                <?php else: ?>
                <li class="page-item"><a class="page-link" href="<?php echo e($proyectos->previousPageUrl()); ?>">«</a></li>
                <?php endif; ?>

                
                <?php $__currentLoopData = $proyectos->getUrlRange(1, $proyectos->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="page-item <?php echo e($page == $proyectos->currentPage() ? 'active' : ''); ?>">
                    <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if($proyectos->hasMorePages()): ?>
                <li class="page-item"><a class="page-link" href="<?php echo e($proyectos->nextPageUrl()); ?>">»</a></li>
                <?php else: ?>
                <li class="page-item disabled"><span class="page-link">»</span></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>  

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Renzito\Desktop\proyecto-intermodular\backend\resources\views/admin/proyectos/index.blade.php ENDPATH**/ ?>