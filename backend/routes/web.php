<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Web\Admin\ProyectoController;

Route::prefix('admin')->group(function () {
    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('admin.usuarios.update');

    // Proyectos
    Route::get('/proyectos/{id}', [ProyectoController::class, 'show'])
        ->name('admin.proyectos.show');

    Route::patch('/proyectos/{id}/check', [ProyectoController::class, 'check'])
        ->name('admin.proyectos.check');
});