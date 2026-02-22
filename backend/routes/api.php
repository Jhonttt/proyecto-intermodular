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

Route::get('/proyectos', [ProyectoController::class, 'index'])->name('api.proyectos.index.public');

// Servir vídeos
Route::get('/video/{filename}', function ($filename) {
    $path = storage_path('app/public/proyectos/' . $filename);
    if (!file_exists($path)) abort(404);
    
    return response()->file($path, [
        'Access-Control-Allow-Origin' => '*',
        'Cross-Origin-Resource-Policy' => 'cross-origin',
    ]);
});

// Descargar documentos
Route::get('/documento/{filename}', function ($filename) {
    $path = storage_path('app/public/proyectos/documentos/' . $filename);

    if (!file_exists($path)) {
        return response()->json(['message' => 'Documento no encontrado'], 404);
    }

    return response()->download($path, $filename, [
        'Access-Control-Allow-Origin' => 'http://localhost:4200',
    ]);
})->where('filename', '.*');


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

    // Proyectos
    Route::prefix('proyectos')->group(function () {
        Route::get('/mi-proyecto', [ProyectoController::class, 'miProyecto'])->name('api.proyectos.mio');
        Route::post('', [ProyectoController::class, 'store'])->name('api.proyectos.store');
        Route::put('/{id}', [ProyectoController::class, 'update'])->name('api.proyectos.update');
        Route::patch('/{id}', [ProyectoController::class, 'update'])->name('api.proyectos.patch');
        Route::delete('/{id}', [ProyectoController::class, 'destroy'])->name('api.proyectos.destroy');
    });

    // Admin - Usuarios
    Route::prefix('admin')->group(function () {
        Route::prefix('users')->group(function () {
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