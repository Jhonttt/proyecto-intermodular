<?php $__env->startSection('content'); ?>
<h1>Login Admin</h1>

<!-- Mostrar errores si los hubiera -->
<?php if($errors->any()): ?>
<div>
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
    <?php echo csrf_field(); ?>

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required>

    <label for="password">Contraseña</label>
    <input id="password" type="password" name="password" required>

    <button type="submit">Iniciar sesión</button>
</form>

</body>

</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proyecto-intermodular\backend\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>