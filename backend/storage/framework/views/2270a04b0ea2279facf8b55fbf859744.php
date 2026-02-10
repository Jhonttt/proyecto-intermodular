<form method="POST" action="<?php echo e(route('admin.usuarios.update', $usuario->id)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <label>Rol</label>
    <select name="rol">
        <option value="admin" <?php echo e($usuario->rol == 'admin' ? 'selected' : ''); ?>>Admin</option>
        <option value="alumno" <?php echo e($usuario->rol == 'alumno' ? 'selected' : ''); ?>>Alumno</option>
    </select>

    <label>Activo</label>
    <select name="activo">
        <option value="1" <?php echo e($usuario->activo ? 'selected' : ''); ?>>Sí</option>
        <option value="0" <?php echo e(!$usuario->activo ? 'selected' : ''); ?>>No</option>
    </select>

    <button type="submit">Guardar</button>
</form>
<?php /**PATH C:\xampp\htdocs\proyecto-intermodular\backend\resources\views/admin/usuarios/edit.blade.php ENDPATH**/ ?>