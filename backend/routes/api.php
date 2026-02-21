<?php

use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Alumno\ProyectoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ============================================
// RUTAS PÚBLICAS (sin autenticación)
// ============================================
Route::post("/login", [AuthController::class, "login"])->name("api.login");

// GET proyectos público (para el home)
Route::get('/proyectos', [ProyectoController::class, 'index'])->name('api.proyectos.index.public');

// ============================================
// RUTAS PROTEGIDAS (requieren autenticación)
// ============================================
Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [AuthController::class, "logout"])->name("api.logout");

    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    })->name("api.user");

    // Crear, editar, eliminar proyectos (solo autenticados)
    Route::prefix("proyectos")->group(function () {
        Route::get('/mi-proyecto', [ProyectoController::class, 'miProyecto'])->name('api.proyectos.mio'); // ← AÑADIR ANTES de las otras
        Route::post('/', [ProyectoController::class, 'store'])->name('api.proyectos.store');
        Route::put('/{id}', [ProyectoController::class, 'update'])->name('api.proyectos.update');
        Route::patch('/{id}', [ProyectoController::class, 'update'])->name('api.proyectos.patch');
        Route::delete('/{id}', [ProyectoController::class, 'destroy'])->name('api.proyectos.destroy');
    });

    // Admin - Usuarios
    Route::prefix('admin')->group(function () {
        Route::prefix("users")->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('api.admin.users.index');
            Route::post('/', [UserController::class, 'store'])->name('api.admin.users.store');
            Route::get('/{id}', [UserController::class, 'show'])->name('api.admin.users.show');
            Route::put('/{id}', [UserController::class, 'update'])->name('api.admin.users.update');
            Route::patch('/{id}', [UserController::class, 'update'])->name('api.admin.users.patch');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('api.admin.users.destroy');
        });
    });
});

Route::get('/proyectos/{id}', [ProyectoController::class, 'show'])->name('api.proyectos.show.public');
Route::post('/proyectos', [ProyectoController::class, 'store']);
                


// Route::get('/create', [AlumnoProyectoController::class, "index"])->name("alumno.proyectos.index");
// Route::post('/store', [AlumnoProyectoController::class, 'store'])->name('alumno.proyectos.store');

// Route::post('/login', [AuthController::class, 'login']);

// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
// Route::get('/proyectos', [ProyectoController::class, 'index']);
// Route::post('/logout', [AuthController::class, 'logout']);
// });
