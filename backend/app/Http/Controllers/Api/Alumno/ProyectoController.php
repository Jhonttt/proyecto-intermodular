<?php

namespace App\Http\Controllers\Api\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller {
    public function index(Request $request) {
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

    public function store(Request $request) {
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
            'video_url' => 'nullable|string',
            'documentos' => 'required|string',
            'tags' => 'nullable|string',
            'checked' => 'boolean',
            'observaciones' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:51200',
        ]);

        $proyecto = Proyecto::create($data);

        // Si viene un video físico, guardarlo y generar thumbnail
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $nombreVideo = time() . '_' . $video->getClientOriginalName();
            $video->storeAs('public/proyectos', $nombreVideo);

            // Actualizar video_url en el proyecto
            $proyecto->video_url = $nombreVideo;

            // Generar thumbnail con FFmpeg
            $videoPath = storage_path('app/public/proyectos/' . $nombreVideo);
            $thumbnailName = pathinfo($nombreVideo, PATHINFO_FILENAME) . '_thumb.jpg';
            $thumbnailPath = storage_path('app/public/proyectos/thumbnails/' . $thumbnailName);

            if (!file_exists(dirname($thumbnailPath))) {
                mkdir(dirname($thumbnailPath), 0755, true);
            }

            exec("ffmpeg -i {$videoPath} -ss 00:00:01 -vframes 1 {$thumbnailPath} 2>&1");

            $proyecto->video_thumbnail = 'proyectos/thumbnails/' . $thumbnailName;
            $proyecto->save();
        }

        return response()->json([
            'proyecto' => $proyecto,
        ], 201);
    }

    public function show(Request $request, $id) {
        if (!is_numeric($id)) {
            return response()->json(['success' => false, 'message' => 'ID inválido'], 400);
        }

        try {
            $proyecto = Proyecto::find($id);

            if (!$proyecto) {
                return response()->json(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
            }

            if (!$proyecto->checked) {
                // Intentar autenticar manualmente aunque la ruta sea pública
                $user = null;
                try {
                    $user = \Laravel\Sanctum\PersonalAccessToken::findToken(
                        $request->bearerToken()
                    )?->tokenable;
                } catch (\Exception $e) {
                }

                if (!$user || $user->id !== $proyecto->user_id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Este proyecto aún no está disponible'
                    ], 403);
                }
            }

            return response()->json(['success' => true, 'data' => $proyecto], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al obtener el proyecto'], 500);
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

    public function destroy(Request $request, $id) {
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

    // Devuelve el proyecto del alumno autenticado (checked o no)
    public function miProyecto(Request $request) {
        $proyecto = Proyecto::where('user_id', $request->user()->id)->first();

        if (!$proyecto) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes ningún proyecto subido'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $proyecto
        ], 200);
    }
}
