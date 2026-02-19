<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <h2 class="mb-4"><?php echo e($proyecto->nombre); ?></h2>

    <div class="mb-3">
        <strong>Curso:</strong> <?php echo e($proyecto->curso); ?>

    </div>

    <div class="mb-3">
        <strong>Alumnos:</strong> <?php echo e($proyecto->alumnos); ?>

    </div>

    <div class="mb-3">
        <strong>Resumen:</strong>
        <p><?php echo e($proyecto->resumen); ?></p>
    </div>

    <div class="mb-3">
        <strong>descripcion:</strong>
        <p><?php echo e($proyecto->descripcion); ?></p>
    </div>

    <?php if($proyecto->video_url): ?>
        <div class="mb-4">
            <h5>Vídeo del proyecto</h5>
            <div class="ratio ratio-16x9">
                <iframe 
                    src="<?php echo e($proyecto->video_url); ?>" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <strong>Estado:</strong>
        <?php if($proyecto->checked): ?>
            <span class="badge bg-success">Validado</span>
        <?php else: ?>
            <span class="badge bg-warning text-dark">Pendiente</span>
        <?php endif; ?>
    </div>

    <?php if(!$proyecto->checked): ?>
        <form method="POST" action="<?php echo e(route('admin.proyectos.check', $proyecto->id)); ?>" class="mt-3">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <button class="btn btn-success">
                Marcar como validado
            </button>
        </form>
    <?php else: ?>
        <form method="POST" action="<?php echo e(route('admin.proyectos.uncheck', $proyecto->id)); ?>" class="mt-3">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <button class="btn btn-danger">
                Quitar validación
            </button>
        </form>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proyecto-intermodular\backend\resources\views/admin/proyectos/show.blade.php ENDPATH**/ ?>