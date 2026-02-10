<?php

namespace App\Http\Controllers\Web\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
     public function store(Request $request)
    {
      // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'resumen' => 'required|string',
            'descripción' => 'required|string',
            'curso' => 'required|string|max:255',
            'alumnos' => 'required|string',
            'video_url' => 'nullable|url',
            'archivo' => 'required|file|max:30720', // 30 MB en KB
        ]);

        //Guardar archivo
        $rutaArchivo = $request->file('archivo')->store('proyectos');

        //Guardar en BD
        $proyecto = Proyecto::create([
            'nombre' => $request->nombre,
            'resumen' => $request->resumen,
            'descripción' => $request->descripción,
            'curso' => $request->curso,
            'alumnos' => $request->alumnos,
            'video_url' => $request->video_url,
            'checked' => false,           //false por defecto
            'observaciones' => null,
        ]);

        return response()->json([
            'message' => 'Proyecto guardado correctamente',
            'data'    => $proyecto
        ], 201);
    }
}
