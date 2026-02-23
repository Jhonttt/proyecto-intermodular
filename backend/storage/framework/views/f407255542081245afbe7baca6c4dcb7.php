<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/proyecto-show.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container details">
    <article class="card details-card mt-5" id="details-form-container">

        
        <div class="card__header">
            <div>
                <h1 class="card__title"><?php echo e($proyecto->nombre); ?></h1>

                <p class="text" style="white-space: pre-wrap"><?php echo e($proyecto->descripcion); ?></p>
            </div>

            <section class="section section--curso">
                <p class="text"><b>Ciclo:</b> <?php echo e($proyecto->ciclo); ?></p>
                <p class="text"><b>Año:</b> <?php echo e($proyecto->anio); ?></p>
            </section>

            <?php if($proyecto->checked): ?>
            <span class="estado-badge estado-badge--validado">✔ Validado</span>
            <?php else: ?>
            <span class="estado-badge estado-badge--pendiente">⏳ Pendiente</span>
            <?php endif; ?>
        </div>

        <hr class="divider" />

        
        <section class="section">
            <h3 class="text">
                <b>Autores:</b>
                <?php $__currentLoopData = $proyecto->alumnos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($alumno); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </h3>
        </section>

        <hr class="divider" />

        
        <?php if($proyecto->video_public_url): ?>
        <section class="section">
            <h3 class="text-center mb-3 mt-3">Video del Proyecto</h3>
            <div class="mb-4 d-flex justify-content-center">
                <video controls preload="metadata" style="max-width:640px; width:100%; height:auto; border-radius:8px;">
                    <source src="<?php echo e($proyecto->video_public_url); ?>" type="video/mp4">
                    Tu navegador no soporta vídeo HTML5.
                </video>
            </div>
        </section>
        <hr class="divider" />
        <?php endif; ?>

        
        <?php if($proyecto->documentos_public && count($proyecto->documentos_public) > 0): ?>
        <section class="section">
            <h3 class="section__title"><b>Documentos adjuntos</b></h3>
            <ul class="list">
                <?php $__currentLoopData = $proyecto->documentos_public; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list__item">
                    <a href="<?php echo e($doc['url']); ?>" target="_blank" download>
                        📄 <?php echo e($doc['name']); ?>

                    </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
        <hr class="divider" />
        <?php endif; ?>

        
        <?php if(!empty($proyecto->tags)): ?>
        <section class="section">
            <h3 class="section__title"><b>Tecnologías y Etiquetas</b></h3>
            <ul class="tag-list">
                <?php $__currentLoopData = $proyecto->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="tech-tag"><?php echo e($tag); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
        <hr class="divider" />
        <?php endif; ?>

        
        <?php if($proyecto->observaciones && $proyecto->observaciones !== 'null'): ?>
        <section class="section">
            <h3 class="section__title"><b>Observaciones</b></h3>
            <textarea
                id="observaciones"
                rows="3"
                style="width:100%; background-color:#E4EEF7; border:var(--border-default); border-radius:var(--radius-sm); padding:8px 10px; font-family:var(--font-body); font-size:var(--font-size-base); resize:vertical;"
                <?php echo e($proyecto->checked ? 'disabled' : ''); ?>><?php echo e(old('observaciones', $proyecto->observaciones)); ?></textarea>
            <?php if($proyecto->checked): ?>
            <p class="form-hint">Para modificar las observaciones, cambia el proyecto a pendiente.</p>
            <?php endif; ?>
        </section>
        <hr class="divider" />
        <?php elseif(!$proyecto->checked): ?>
        <section class="section">
            <h3 class="section__title"><b>Observaciones</b></h3>
            <textarea
                id="observaciones"
                rows="3"
                placeholder="Escribe observaciones para el alumno..."
                style="width:100%; background-color:#E4EEF7; border:var(--border-default); border-radius:var(--radius-sm); padding:8px 10px; font-family:var(--font-body); font-size:var(--font-size-base); resize:vertical;"><?php echo e(old('observaciones')); ?></textarea>
        </section>
        <hr class="divider" />
        <?php endif; ?>

        
        <section class="section">
            <h3 class="section__title"><b>Información del Sistema</b></h3>
            <dl class="meta">
                <div class="meta__row">
                    <dt>ID del Proyecto</dt>
                    <dd>#<?php echo e($proyecto->id); ?></dd>
                </div>
                <div class="meta__row">
                    <dt>Fecha de Creación</dt>
                    <dd><?php echo e($proyecto->created_at->format('d/m/Y H:i')); ?></dd>
                </div>
                <div class="meta__row">
                    <dt>Última Actualización</dt>
                    <dd><?php echo e($proyecto->updated_at->format('d/m/Y H:i')); ?></dd>
                </div>
            </dl>
        </section>

        <hr class="divider" />

        
        <footer class="mb-5">

            <div class="mt-3 d-flex gap-2 justify-content-center flex-wrap">
                <?php if(!$proyecto->checked): ?>
                <form id="form-validar" method="POST" action="<?php echo e(route('admin.proyectos.check', $proyecto->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="observaciones" id="obs-hidden">
                    <button type="button" class="btn btn-submit" onclick="validarProyecto()">
                        ✔ Validar
                    </button>
                </form>

                <a href="<?php echo e(route('admin.proyectos.edit', $proyecto->id)); ?>" class="btn btn-primary">
                    ✏ Editar
                </a>

                <form method="POST" action="<?php echo e(route('admin.proyectos.destroy', $proyecto->id)); ?>"
                    onsubmit="return confirm('¿Seguro que deseas eliminar este proyecto?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-danger">🗑 Eliminar</button>
                </form>

                <?php else: ?>

                <form method="POST" action="<?php echo e(route('admin.proyectos.uncheck', $proyecto->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <button class="btn btn-danger">↩ Volver a revisar</button>
                </form>

                <?php endif; ?>

                <a href="<?php echo e(route('admin.proyectos.index')); ?>" class="btn btn-warning">← Volver </a>
            </div>
        </footer>

    </article>
</div>


<div id="modal-eliminar"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center;">
    <div
        style="background:#fff; border-radius:8px; padding:24px; max-width:400px; width:90%; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
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
<script>
    function validarProyecto() {
        const textarea = document.getElementById('observaciones');
        const hidden = document.getElementById('obs-hidden');
        if (textarea) hidden.value = textarea.value;
        document.getElementById('form-validar').submit();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proyecto-intermodular\backend\resources\views/admin/proyectos/show.blade.php ENDPATH**/ ?>