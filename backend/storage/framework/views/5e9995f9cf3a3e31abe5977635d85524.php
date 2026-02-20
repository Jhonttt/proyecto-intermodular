<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
</head>

<?php $__env->startSection('content'); ?>

    <div class="login-center">

        <div class="container">

            <div class="card login-box">
                <h1>Administración</h1>


                <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
                    <?php echo csrf_field(); ?>

                    
                    <?php if(session('error')): ?>
                        <div
                            style="border-color: var(--danger); background-color: #fdf2f2; margin-bottom: var(--block-spacing);">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span class="material-symbols-outlined md-16 icon-danger">error</span>
                                <small style="color: var(--danger);"><?php echo e(session('error')); ?></small>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($errors->any()): ?>
                        <div
                            style="border-color: var(--danger); background-color: #fdf2f2; margin-bottom: var(--block-spacing);">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                                    <span class="material-symbols-outlined md-16 icon-danger">error</span>
                                    <small style="color: var(--danger);"><?php echo e($error); ?></small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <div style="margin-bottom: var(--spacing-md)">
                        <label for="correo"
                            style="display: block; margin-bottom: 5px; font-weight: var(--font-weight-medium);">Correo
                            Electrónico</label>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                            class="<?php echo e($errors->has('email') ? 'input-error' : ''); ?> input" placeholder="ejemplo@correo.com"
                            required>
                    </div>

                    <div style="margin-bottom: var(--spacing-md);">
                        <label for="passwd"
                            style="display: block; margin-bottom: 5px; font-weight: var(--font-weight-medium);">Contraseña</label>
                        <input id="password" type="password" name="password"
                            class="<?php echo e($errors->has('password') ? 'input-error' : ''); ?> input" placeholder="********"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <span class="material-symbols-outlined md-16" style="margin-right: 6px;">login</span>
                        Iniciar sesión
                    </button>

                </form>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proyecto-intermodular\backend\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>