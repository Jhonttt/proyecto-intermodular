<h1>Crear usuario</h1>

<form method="POST" action="<?php echo e(route('admin.usuarios.store')); ?>">
    <?php echo csrf_field(); ?>


    <div>
        <label>Nombre</label><br>
        <input type="text" name="name">
    </div>

    <br>

    <div>
        <label>Email</label><br>
        <input type="email" name="email">
    </div>

    <br>

    <div>
        <label>Contraseña</label><br>
        <input type="password" name="password">
    </div>

    <br>

    <div>
        <label>Rol</label><br>
        <select name="rol">
            <option value="admin">Admin</option>
            <option value="usu">Usuario</option>
        </select>
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="activo" value="1" checked>
            Usuario activo
        </label>
    </div>

    <br>

    <button type="submit">Guardar</button>
</form>

<br>

<a href="<?php echo e(url('/admin/usuarios')); ?>">Volver al listado</a>
<?php /**PATH C:\xampp\htdocs\proyecto-intermodular\backend\resources\views/admin/usuarios/create.blade.php ENDPATH**/ ?>
