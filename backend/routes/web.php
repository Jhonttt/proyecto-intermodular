<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('admin.usuarios.create');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('admin.usuarios.edit');
});