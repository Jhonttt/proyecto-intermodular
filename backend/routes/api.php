<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProyectoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/proyectos', [ProyectoController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});