<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\ProyectoControllerAdmin;
use App\Http\Controllers\Web\Admin\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login.index');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Lista de proyectos panel admin
Route::get('/proyectos', [ProyectoControllerAdmin::class, 'index'])->name('admin.proyectos.index');

// Proyecto descripción para admin
Route::get('/proyectos/{id}', [ProyectoControllerAdmin::class, 'show'])->name('admin.proyectos.show');
Route::patch('/proyectos/{id}/check', [ProyectoControllerAdmin::class, 'check'])->name('admin.proyectos.check');
Route::patch('/admin/proyectos/{id}/uncheck', [ProyectoControllerAdmin::class, 'uncheck'])->name('admin.proyectos.uncheck');