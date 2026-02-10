<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-8">
        <h1>Explorar Proyectos</h1>
        <p class="text-muted">Consulta los trabajos de otros compañeros para inspirarte.</p>
    </div>
    <div class="col-md-4 text-end">
        <button class="btn btn-success">Subir mi TFG</button>
    </div>
</div>

<div class="card p-4 mb-4">
    <form class="row g-3">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Buscar por título o autor...">
        </div>
        <div class="col-md-4">
            <select class="form-select">
                <option selected>Todos los ciclos (ASIR, DAW, DAM...)</option>
                <option>DAW</option>
                <option>ASIR</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
</div>

<div class="row">
    <?php $__currentLoopData = range(1, 6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <span class="badge bg-info text-dark mb-2">DAW</span>
                <h5 class="card-title">Sistema de Gestión de Biblioteca</h5>
                <p class="card-text text-muted">Autor: Juan Pérez</p>
                <a href="#" class="btn btn-outline-primary btn-sm">Ver detalles</a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proyecto-intermodular\backend\resources\views/layouts/alumno.blade.php ENDPATH**/ ?>