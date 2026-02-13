<?php

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Api\ProyectoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post('/login', [AuthController::class, 'login'])->name('login.verify');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/proyectos', [ProyectoController::class, 'index']);
    Route::post('/proyectos', [ProyectoController::class, 'store']);
    Route::get('/proyectos/{id}', [ProyectoController::class, 'show']);
    Route::put('/proyectos/{id}', [ProyectoController::class, 'update']);
    Route::delete('/proyectos/{id}', [ProyectoController::class, 'destroy']);
    });
    





// Route::post('/login', [AuthController::class, 'login']);

// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
// Route::get('/proyectos', [ProyectoController::class, 'index']);
// Route::post('/logout', [AuthController::class, 'logout']);
// });
