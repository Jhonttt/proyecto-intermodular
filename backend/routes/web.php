<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;

Route::get('/', [ProyectoController::class, 'index'])->name('home');

// Para probar el layout de admin
Route::get('/test-admin', function () {
    return view('layouts.admin'); 
});

// Para probar el layout de alumno
Route::get('/test-alumno', function () {
    return view('layouts.alumno');
});
