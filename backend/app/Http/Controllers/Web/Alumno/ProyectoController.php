<?php

namespace App\Http\Controllers\Web\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Storage;

class ProyectoController extends Controller
{
    // Mostrar formulario de creación
    public function index()
    {
        return view("alumno.proyectos.create");
    }

    // Guardar proyecto
    public function store(Request $request)
    {
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
            'archivo' => 'nullable|file|max:10240|mimes:zip,rar', // 10MB
            'video' => 'required|file|mimes:mp4,mov,avi,mkv,wmv|max:30720', // 30MB
        ]);

        // Subida del video
        $videoPath = null;
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $nombreVideo = time() . '_' . $video->getClientOriginalName();
            $video->storeAs('public/videos', $nombreVideo);
            $videoPath = 'storage/videos/' . $nombreVideo;
        }

        // Subida del archivo ZIP/RAR opcional
        $archivoPath = null;
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $archivo->storeAs('public/documentos', $nombreArchivo);
            $archivoPath = 'storage/documentos/' . $nombreArchivo;
        }

        // Guardar proyecto en la base de datos
        $proyecto = Proyecto::create([
            'nombre' => $request->nombre,
            'resumen' => $request->resumen,
            'descripcion' => $request->descripcion,
            'anio' => $request->anio,
            'ciclo' => $request->ciclo,
            'tags' => $request->tags,
            'alumnos' => $request->alumnos,
            'video' => $videoPath,
            'archivo' => $archivoPath,
            'checked' => false,
            'observaciones' => null,
        ]);

        return response()->json([
            'message' => 'Proyecto guardado correctamente',
            'data' => $proyecto
        ], 201);
    }
}
