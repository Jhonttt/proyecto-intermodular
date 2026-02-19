<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\ProyectoControllerAdmin;
use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Alumno\ProyectoController as AlumnoProyectoController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login.index');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware(["auth:sanctum", "admin"])->group(function () {
    Route::prefix('admin')->group(function () {
        // Lista de proyectos panel admin
        Route::get('/proyectos', [ProyectoControllerAdmin::class, 'index'])->name('admin.proyectos.index');

        // Proyecto descripcion para admin
        Route::get('/proyectos/{id}', [ProyectoControllerAdmin::class, 'show'])->name('admin.proyectos.show');
        Route::patch('/proyectos/{id}/check', [ProyectoControllerAdmin::class, 'check'])->name('admin.proyectos.check');
        Route::patch('/proyectos/{id}/uncheck', [ProyectoControllerAdmin::class, 'uncheck'])->name('admin.proyectos.uncheck');
        // Route::get('/proyectos/{id}/edit', [ProyectoControllerAdmin::class, 'edit'])->name('admin.proyectos.edit');
        Route::delete('/proyectos/{id}/destroy', [ProyectoControllerAdmin::class, 'destroy'])->name('admin.proyectos.destroy');
        
        Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
        Route::get('/usuarios/create', [UserController::class, 'create'])->name('admin.usuarios.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store');
        Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('admin.usuarios.edit');
        Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('admin.usuarios.update');
    });
});

Route::get('/create', [AlumnoProyectoController::class, "index"])->name("alumno.proyectos.index");
Route::get('/prueba', function(){
    return view("layouts.admin");
}); //temporal
Route::post('/store', [AlumnoProyectoController::class, 'store'])->name('alumno.proyectos.store');

Route::get("prueba", function () {
    return view("layouts.admin");
});
Route::get("prueba1", function () {
    return view("layouts.alumno");
});