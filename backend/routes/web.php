<?php

use App\Http\Controllers\Web\Alumno\ProyectoController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Web\Admin\ProyectoControllerAdmin;

Route::prefix('admin')->group(function () {
    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('admin.usuarios.update');
});


Route::post('/store', [ProyectoController::class, 'store'])->name('alumno.proyectos.store');
Route::get('/create', function () {
    return view("alumno.proyectos.create");
});

// Proyectos
Route::get('/proyectos/{id}', [ProyectoControllerAdmin::class, 'show'])
    ->name('admin.proyectos.show');

Route::patch('/proyectos/{id}/check', [ProyectoControllerAdmin::class, 'check'])
    ->name('admin.proyectos.check');

Route::patch('/admin/proyectos/{id}/uncheck', [ProyectoControllerAdmin::class, 'uncheck'])
    ->name('admin.proyectos.uncheck');

/* Asocio controlador Proyecto a index */
Route::get('/proyectos', [ProyectoControllerAdmin::class, 'index'])
    ->name('admin.proyectos.index');
