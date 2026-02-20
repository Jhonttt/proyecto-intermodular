<?php

namespace App\Http\Controllers\Api\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $proyectos = Proyecto::where('checked', true)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $proyectos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los proyectos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->rol !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $data = $request->validate([
            'nombre' => 'required|string',
            'resumen' => 'required|string',
            'descripcion' => 'required|string',
            'ciclo' => 'required|string',
            'anio' => 'required|string',
            'alumnos' => 'required|string',
            'video_url' => 'required|string',
            'documentos' => 'required|string',
            'tags' => 'nullable|string',
            'checked' => 'boolean',
            'observaciones' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:51200', // 50MB
        ]);

        $proyecto = Proyecto::create($data);

        // Si viene un video físico, guardarlo en storage/app/public/videos
        $videoPath = null;
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $nombreVideo = time() . '_' . $video->getClientOriginalName();
            $video->storeAs('public/videos', $nombreVideo);
            $videoPath = url('storage/videos/' . $nombreVideo);
        }

        return response()->json([
            'proyecto' => $proyecto,
            'video_path' => $videoPath
        ], 201);

        
    }

    public function show(Request $request, $id)
    {
        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'message' => 'ID de proyecto inválido'
            ], 400);
        }

        try {
            $proyecto = Proyecto::find($id);

            if (!$proyecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $proyecto
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el proyecto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     public function update(Request $request, $id) {
        $user = $request->user();
        if ($user->rol !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return response()->json(['message' => 'No encontrado'], 404);
        }

        $data = $request->validate([
            'nombre' => 'sometimes|string',
            'resumen' => 'sometimes|string',
            'descripcion' => 'sometimes|string',
            'ciclo' => 'sometimes|string',
            'anio' => 'required|string',
            'alumnos' => 'sometimes|string',
            'video_url' => 'sometimes|string',
            'documentos' => 'sometimes|string',
            'tags' => 'sometimes|string',
            'checked' => 'sometimes|boolean',
            'observaciones' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:51200',
        ]);

        $proyecto->update($data);

         // Subida de video físico
        $videoPath = null;
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $nombreVideo = time() . '_' . $video->getClientOriginalName();
            $video->storeAs('public/videos', $nombreVideo);
            $videoPath = url('storage/videos/' . $nombreVideo);
        }

        return response()->json([
            'proyecto' => $proyecto,
            'video_path' => $videoPath
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        if ($user->rol !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return response()->json(['message' => 'No encontrado'], 404);
        }

        $proyecto->delete();

        return response()->json(['message' => 'Proyecto eliminado'], 200);
    }
}
