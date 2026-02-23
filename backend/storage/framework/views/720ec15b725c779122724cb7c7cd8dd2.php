<?php $__env->startSection('content'); ?>

    <div class="container mt-4">

        <h2 class="mb-4">Subir nuevo proyecto</h2>

        

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('alumno.proyectos.store')); ?>" method="POST" enctype="multipart/form-data">
            
            <?php echo csrf_field(); ?>

            

            <div class="mb-3">
                <label class="form-label">Nombre del proyecto</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo e(old('nombre')); ?>" required maxlength="100">
            </div>

            

            <div class="mb-3">
                <label class="form-label">Resumen</label>
                <input type="text" name="resumen" class="form-control" value="<?php echo e(old('resumen')); ?>" required>
            </div>

            

            <div class="mb-3">
                <label class="form-label">Descripción completa</label>
                <textarea name="descripcion" class="form-control" rows="5" required minlength="25" maxlength="200" style="resize: none;"><?php echo e(old('descripcion')); ?></textarea>
            </div>

            

            <div class="mb-3">
                <label class="form-label">Curso académico</label>
                <select name="curso" class="form-select" required>
                    <option value="">Selecciona un curso</option>
                    <option value="2023/2024" <?php if(old('curso') == '2023/2024'): echo 'selected'; endif; ?>>2023/2024</option>
                    <option value="2024/2025" <?php if(old('curso') == '2024/2025'): echo 'selected'; endif; ?>>2024/2025</option>
                    <option value="2025/2026" <?php if(old('curso') == '2025/2026'): echo 'selected'; endif; ?>>2025/2026</option>
                </select>
            </div>

            

            <div class="mb-3">
                <label class="form-label">Ciclo formativo</label>

                <select name="ciclo" class="form-select" required>
                    <option value="">Selecciona un ciclo</option>

                    <option value="DAW" <?php if(old('ciclo') == 'DAW'): echo 'selected'; endif; ?>>
                        Desarrollo de Aplicaciones Web
                    </option>

                    <option value="DAM" <?php if(old('ciclo') == 'DAM'): echo 'selected'; endif; ?>>
                        Desarrollo de Aplicaciones Multiplataforma
                    </option>

                    <option value="ASIR" <?php if(old('ciclo') == 'ASIR'): echo 'selected'; endif; ?>>
                        Administración de Sistemas Informáticos en Red
                    </option>

                    <option value="AF" <?php if(old('ciclo') == 'AF'): echo 'selected'; endif; ?>>
                        Administración y Finanzas
                    </option>

                    <option value="AD" <?php if(old('ciclo') == 'AD'): echo 'selected'; endif; ?>>
                        Asistencia a la Dirección
                    </option>

                    <option value="AUT" <?php if(old('ciclo') == 'AUT'): echo 'selected'; endif; ?>>
                        Automoción
                    </option>
                </select>
            </div>

            

            <div class="mb-3">
                <label class="form-label">Alumnos participantes</label>
                <textarea name="alumnos" class="form-control" rows="3"
                    placeholder="Ej: Nombre1 Apellido1, Nombre2 Apellido2..." required style="resize: none;"><?php echo e(old('alumnos')); ?></textarea>
            </div>

            

            <div class="mb-3">
                <label class="form-label">Tags (opcional, máximo 5)</label>
                <input type="text" name="tags" class="form-control" value="<?php echo e(old('tags')); ?>" placeholder="Laravel, Angular...">
                <div class="form-text">
                    Separados por comas (máximo 5)
                </div>
            </div>

             

            <div class="mb-3">
                <label class="form-label">Vídeo del proyecto</label>
                <input type="file" name="video" class="form-control" accept="video/*" required>
                <div class="form-text">
                    Máximo 30MB
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Archivo del proyecto (opcional)</label>
                <input type="file" name="archivo" class="form-control">
                <div class="form-text">
                    Máximo 30MB
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Enviar proyecto
            </button>

        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Renzito\Desktop\proyecto-intermodular\backend\resources\views/alumno/proyectos/create.blade.php ENDPATH**/ ?>