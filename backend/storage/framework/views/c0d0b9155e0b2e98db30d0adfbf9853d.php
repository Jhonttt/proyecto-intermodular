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
    <link rel="stylesheet" href="<?php echo e(asset('backend\resources\css\app.css')); ?>">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">IES Lázaro Cárdenas | Repositorio</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-link text-light">Hola, <?php echo e(auth()->user()->name ?? 'Usuario'); ?></span>
                <form action="<?php echo e(route("admin.logout")); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="nav-link btn btn-danger btn-sm text-white ms-3">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="main-container">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="text-center py-4 mt-5 text-muted">
        &copy; <?php echo e(date('Y')); ?> IES Lázaro Cárdenas - Proyecto Intermodular
    </footer>
</body>

</html><?php /**PATH C:\Users\vespertino\Documents\proyecto-intermodular\backend\resources\views/layouts/app.blade.php ENDPATH**/ ?>