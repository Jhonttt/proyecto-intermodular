<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\ProyectoController as ApiProyectoController;
use App\Http\Controllers\Web\Alumno\ProyectoController as AlumnoProyectoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/proyectos', [AlumnoProyectoController::class, 'index']);
    Route::post('/proyectos', [AlumnoProyectoController::class, 'store']);
    Route::get('/proyectos/{id}', [AlumnoProyectoController::class, 'show']);
    Route::put('/proyectos/{id}', [AlumnoProyectoController::class, 'update']);
    Route::delete('/proyectos/{id}', [AlumnoProyectoController::class, 'destroy']);
});
    

Route::prefix('admin')->group(function () {
    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('admin.usuarios.update');
});

Route::get('/create', [ApiProyectoController::class, "index"])->name("alumno.proyectos.index");
Route::post('/store', [ApiProyectoController::class, 'store'])->name('alumno.proyectos.store');



// Route::post('/login', [AuthController::class, 'login']);

// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
// Route::get('/proyectos', [ProyectoController::class, 'index']);
// Route::post('/logout', [AuthController::class, 'logout']);
// });
