<?php

namespace App\Http\Controllers\Web\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller {
    public function index() {
        return view("alumno.proyectos.create");
    }

    public function store(Request $request) {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'resumen' => 'required|string',
            'descripcion' => 'required|string',
            'anio' => 'required|string|max:255',
            'ciclo' => 'required|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'alumnos' => 'required|array',
            'alumnos.*' => 'string',
            'archivo' => 'nullable|file|max:30720',
            'video' => 'required|file|mimes:mp4,mov,avi,mkv,wmv|max:30720',
        ]);

        //Guardar archivo
        $rutaArchivo = $request->file('video')->store('proyectos');
      
        //Coger el video_url que se genero
        // $video = x;

        //Guardar en BD
        $proyecto = Proyecto::create([
            'nombre' => $request->nombre,
            'resumen' => $request->resumen,
            'descripcion' => $request->descripcion,
            'anio' => $request->anio,
            'ciclo' => $request->ciclo,
            'tags' => $request->tags,
            'alumnos' => $request->alumnos,
            'video' => $request->video_url,
            'checked' => false,
            'observaciones' => null,
        ]);

        return response()->json([
            'message' => 'Proyecto guardado correctamente',
            'data' => $proyecto
        ], 201);
    }
}