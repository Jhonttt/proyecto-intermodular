<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script>
        // Recarga si el usuario llegó usando el botón atrás
        if (performance.navigation.type === 2) {
            window.location.reload();
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>

        <form action="<?php echo e(route('login')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo e(old('email')); ?>"
                    required 
                    autocomplete="email"
                    placeholder="tu@email.com"
                >
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                >
            </div>

            <button type="submit" class="btn">Ingresar</button>
        </form>
    </div>
</body>
</html><?php /**PATH C:\Users\vespertino\Documents\proyecto-intermodular\backend\resources\views/login.blade.php ENDPATH**/ ?>