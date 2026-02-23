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
        <strong>Curso:</strong> <?php echo e($proyecto->ciclo); ?>

    </div>

    <!-- Año -->
    <div class="mb-3">
        <strong>Año:</strong> <?php echo e($proyecto->anio); ?>

    </div>

    <!-- Alumnos -->
    <div class="mb-3">
        <strong>Alumnos:</strong>
        <?php $__currentLoopData = $proyecto->alumnos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($alumno); ?><?php if(!$loop->last): ?>, <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Video del proyecto -->
    <?php if($proyecto->video_public_url): ?>
    <div class="mb-4">
        <h5>Vídeo del proyecto</h5>
        <video class="w-100" controls preload="metadata">
            <source src="<?php echo e($proyecto->video_public_url); ?>" type="video/mp4">
            Tu navegador no soporta vídeo HTML5.
        </video>
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
    <?php if($proyecto->documentos_public): ?>
    <div class="mb-4">
        <strong>Documentos adjuntos:</strong>
        <ul class="list-group mt-2">
            <?php $__currentLoopData = $proyecto->documentos_public; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item">
                <a href="<?php echo e($doc['url']); ?>" target="_blank" download>
                    <?php echo e($doc['name']); ?>

                </a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Observaciones</label>

        <textarea
            id="observaciones"
            class="form-control"
            style="background-color: #E4EEF7"
            rows="3"
            <?php echo e($proyecto->checked ? 'disabled' : ''); ?>><?php echo e(old('observaciones', $proyecto->observaciones)); ?></textarea>

        <?php if($proyecto->checked): ?>
        <div class="form-text text-muted">
            Para modificar las observaciones, cambia el proyecto a pendiente.
        </div>
        <?php endif; ?>
    </div>

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
        <form id="form-validar" method="POST"
            action="<?php echo e(route('admin.proyectos.check', $proyecto->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>

            <input type="hidden" name="observaciones" id="obs-hidden">

            <button type="button" class="btn btn-success" onclick="validarProyecto()">
                Validar
            </button>
        </form>

        <script>
            function validarProyecto() {
                const textarea = document.getElementById('observaciones');
                const hidden = document.getElementById('obs-hidden');

                if (textarea) {
                    hidden.value = textarea.value;
                }

                document.getElementById('form-validar').submit();
            }
        </script>

        <a href="<?php echo e(route('admin.proyectos.edit', $proyecto->id)); ?>"
            class="btn btn-primary">
            Editar
        </a>

        <form method="POST" action="<?php echo e(route('admin.proyectos.destroy', $proyecto->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="button" class="btn btn-danger"
                onclick="abrirModal('<?php echo e($proyecto->id); ?>', '<?php echo e($proyecto->nombre); ?>')">
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


<div id="modal-eliminar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:8px; padding:24px; max-width:400px; width:90%; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
        <h3 style="margin-bottom:8px;">Eliminar proyecto</h3>
        <p style="color:#6A737B; margin-bottom:24px;">
            ¿Seguro que quieres eliminar <strong id="modal-nombre"></strong>? Esta acción no se puede deshacer.
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
        document.getElementById('modal-form').action = '/admin/proyectos/' + id;
        const modal = document.getElementById('modal-eliminar');
        modal.style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('modal-eliminar').style.display = 'none';
    }

    document.getElementById('modal-eliminar').addEventListener('click', function(e) {
        if (e.target === this) cerrarModal();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proyecto-intermodular\backend\resources\views/admin/proyectos/show.blade.php ENDPATH**/ ?>