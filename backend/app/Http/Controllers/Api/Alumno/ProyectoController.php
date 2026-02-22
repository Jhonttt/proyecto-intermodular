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

        $data = $request->validate([
            'nombre'        => 'required|string',
            'resumen'       => 'required|string',
            'descripcion'   => 'required|string',
            'ciclo'         => 'required|string',
            'anio'          => 'required|string',
            'alumnos'       => 'required|string',
            'video_url'     => 'nullable|string',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg|max:5120',
            'tags'          => 'nullable|string',
            'checked'       => 'boolean',
            'observaciones' => 'nullable|string',
            'video'         => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:51200',
            'documentos'    => 'nullable|array',
            'documentos.*'  => 'file|mimes:pdf|max:10240',
        ]);

        unset($data['documentos']);

        if (isset($data['alumnos'])) {
            $data['alumnos'] = array_map('trim', explode(',', $data['alumnos']));
        }

        if (isset($data['tags']) && $data['tags']) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }

        $proyecto = Proyecto::create(array_merge($data, ['user_id' => $user->id]));

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $nombreVideo = time() . '_' . $video->getClientOriginalName();
            $video->storeAs('proyectos', $nombreVideo, 'public');
            $proyecto->video_url = $nombreVideo;

            // Thumbnail generado desde Angular
            if ($request->hasFile('thumbnail')) {
                $thumb = $request->file('thumbnail');
                $thumbnailName = pathinfo($nombreVideo, PATHINFO_FILENAME) . '_thumb.jpg';
                $thumb->storeAs('proyectos/thumbnails', $thumbnailName, 'public');
                $proyecto->video_thumbnail = 'proyectos/thumbnails/' . $thumbnailName;
            }

            $proyecto->save();
        }

        if ($request->hasFile('documentos')) {
            $rutas = [];
            foreach ($request->file('documentos') as $doc) {
                $nombre = time() . '_' . $doc->getClientOriginalName();
                $doc->storeAs('proyectos/documentos', $nombre, 'public');
                $rutas[] = 'proyectos/documentos/' . $nombre;
            }
            $proyecto->documentos = $rutas;
            $proyecto->save();
        }

        $user->update(['proyecto_subido' => true]);

        // En store(), cambia la última línea:
        return response()->json([
            'success' => true,
            'message' => 'Proyecto creado correctamente',
            'data' => $proyecto
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
            'nombre'        => 'sometimes|string',
            'resumen'       => 'sometimes|string',
            'descripcion'   => 'sometimes|string',
            'ciclo'         => 'sometimes|string',
            'anio'          => 'required|string',
            'alumnos'       => 'sometimes|string',
            'video_url'     => 'sometimes|string',
            'tags'          => 'sometimes|string',
            'checked'       => 'sometimes|boolean',
            'observaciones' => 'nullable|string',
            'video'         => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:51200',
            'documentos'    => 'nullable|array',
            'documentos.*'  => 'file|mimes:pdf|max:10240',
        ]);

        unset($data['documentos']);

        if (isset($data['alumnos'])) {
            $data['alumnos'] = array_map('trim', explode(',', $data['alumnos']));
        }

        if (isset($data['tags']) && $data['tags']) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }

        $proyecto->update($data);

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $nombreVideo = time() . '_' . $video->getClientOriginalName();
            $video->storeAs('proyectos', $nombreVideo, 'public');
            $proyecto->video_url = $nombreVideo;
            $proyecto->save();
        }

        if ($request->hasFile('documentos')) {
            $rutas = [];
            foreach ($request->file('documentos') as $doc) {
                $nombre = time() . '_' . $doc->getClientOriginalName();
                $doc->storeAs('proyectos/documentos', $nombre, 'public');
                $rutas[] = 'proyectos/documentos/' . $nombre;
            }
            $proyecto->documentos = $rutas;
            $proyecto->save();
        }

        return response()->json(['proyecto' => $proyecto], 200);
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

    public function miProyecto(Request $request) {
        $proyecto = Proyecto::where('user_id', $request->user()->id)->first();

        if (!$proyecto) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes ningún proyecto subido'
            ], 404);
        }

        return response()->json(['success' => true, 'data' => $proyecto], 200);
    }
}
