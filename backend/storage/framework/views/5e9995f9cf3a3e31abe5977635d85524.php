<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <h1>Login Admin</h1>

    <!-- Mostrar errores si los hubiera -->


    <form method="POST" action="<?php echo e(route('login.verify')); ?>">
        <?php echo csrf_field(); ?>

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required>

        <label for="password">Contraseña</label>
        <input id="password" type="password" name="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>

</body>

</html><?php /**PATH C:\xampp\htdocs\proyecto-intermodular\backend\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>