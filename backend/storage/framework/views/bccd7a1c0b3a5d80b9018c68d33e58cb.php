<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <!-- Nombre del proyecto -->
    <h2 class="mb-4"><?php echo e($proyecto->nombre); ?></h2>
    
    <!-- Resumen -->
    <div class="mb-3">
        <strong>Resumen:</strong>
        <p><?php echo e($proyecto->resumen); ?></p>
    </div>
    
    <!-- Descripción -->
    <div class="mb-3">
        <strong>Descripción:</strong>
        <p><?php echo e($proyecto->descripcion); ?></p>
    </div>

    <!-- Curso -->
    <div class="mb-3">
        <strong>Curso:</strong> <?php echo e($proyecto->curso); ?>

    </div>

    <!-- Año -->
    <div class="mb-3">
        <strong>Año:</strong> 
        <?php echo e(($proyecto->created_at->year - 1)); ?>-<?php echo e($proyecto->created_at->year % 100); ?>

    </div>

    <!-- Alumnos -->
    <div class="mb-3">
        <strong>Alumnos:</strong> <?php echo e($proyecto->alumnos); ?>

    </div>

    <!-- Video del proyecto -->
    <?php if($proyecto->video_url): ?>
        <div class="mb-4">
            <h5>Vídeo del proyecto</h5>
            <div class="ratio ratio-16x9">
                <!-- Convertir la URL genérica a formato embed  (Las URLs watch?v= son bloqueadas por Youtube) -->
                <iframe 
                    src="<?php echo e(str_replace('watch?v=', 'embed/', $proyecto->video_url)); ?>" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    <?php endif; ?>

    <!-- Tags -->
    <?php if(!empty($proyecto->tags)): ?>
        <div class="mb-3">
            <strong>Tags:</strong>
            <?php $__currentLoopData = $proyecto->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="badge bg-secondary me-1"><?php echo e($tag); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <!-- Documentos adjuntos -->
    <?php if(!empty($proyecto->documentos)): ?>
        <div class="mb-4">
            <strong>Documentos adjuntos:</strong>
            <ul class="list-group mt-2">
                <?php $__currentLoopData = $proyecto->documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $documento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item">
                        <a href="<?php echo e(asset('storage/' . $documento)); ?>" download>
                            <?php echo e(basename($documento)); ?>

                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Estado del proyecto -->
    <div class="mt-4">
        <strong>Estado:</strong>
        <?php if($proyecto->checked): ?>
            <span class="badge bg-success">Validado</span>
        <?php else: ?>
            <span class="badge bg-warning text-dark">Pendiente</span>
        <?php endif; ?>
    </div>

    <!-- Acciones -->
    <div class="mt-3 d-flex gap-2 justify-content-center">
        <?php if(!$proyecto->checked): ?>
            <form method="POST" action="<?php echo e(route('admin.proyectos.check', $proyecto->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <button class="btn btn-success">
                    Validar
                </button>
            </form>

            <!-- Botón de modificar: falta invocar la acción con la ruta creada  -->
            <a class="btn btn-primary">
            Modificar
            </a>

            <form method="POST" action="<?php echo e(route('admin.proyectos.destroy', $proyecto->id)); ?>"
                onsubmit="return confirm('¿Seguro que deseas eliminar este proyecto?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="btn btn-danger">
                    Eliminar
                </button>
            </form>

        <?php else: ?>
            <form method="POST" action="<?php echo e(route('admin.proyectos.uncheck', $proyecto->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <button class="btn btn-danger">
                    Volver a revisar
                </button>
            </form>
        <?php endif; ?>
        
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Renzito\Desktop\proyecto-intermodular\backend\resources\views/admin/proyectos/show.blade.php ENDPATH**/ ?>