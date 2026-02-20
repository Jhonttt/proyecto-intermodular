<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio TFG - IES Lázaro Cárdenas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #004a99;
        }

        /* Color corporativo ficticio */
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <header class="header">
        <div class="container header-content">
            <div class="header-left">
                <strong>
                    <a class="navbar-brand" href="<?php echo e(route('admin.proyectos.index')); ?>">IES Lázaro Cárdenas |
                        Repositorio</a>
                </strong>
            </div>
            <?php if(auth()->guard()->check()): ?>
                <nav class="header-nav" style="display: flex">
                    <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="btn">Usuarios</a>
                    <form id="form-logout" action="<?php echo e(route('admin.logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <a href="#" class="btn btn-danger"
                            onclick="document.getElementById('form-logout').submit()">Cerrar Sesión</a>
                    </form>
                </nav>
            <?php endif; ?>
        </div>
    </header>

    <main class="main-container">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="text-center py-4 mt-5 text-muted">
        &copy; <?php echo e(date('Y')); ?> IES Lázaro Cárdenas - Proyecto Intermodular
    </footer>
</body>

</html>
<?php /**PATH C:\Users\vespertino\Documents\proyecto-intermodular\backend\resources\views/layouts/app.blade.php ENDPATH**/ ?>