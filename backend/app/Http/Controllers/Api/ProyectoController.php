<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index(Request $request)
        {
            $user = $request->user();

            // Solo ADMIN
            if ($user->rol !== 'admin') {
                return response()->json(['message' => 'No autorizado'], 403);
            }

            $proyectos = Proyecto::all();
            return response()->json($proyectos, 200);
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
                'curso' => 'required|string',
                'alumnos' => 'required|string',
                'video_url' => 'nullable|url',
                'checked' => 'boolean',
                'observaciones' => 'nullable|string',
            ]);

            $proyecto = Proyecto::create($data);

            return response()->json($proyecto, 201);
        }


    public function show(Request $request, $id)
        {
            $user = $request->user();
            if ($user->rol !== 'admin') {
                return response()->json(['message' => 'No autorizado'], 403);
            }

            $proyecto = Proyecto::find($id);
            if (!$proyecto) {
                return response()->json(['message' => 'No encontrado'], 404);
            }

            return response()->json($proyecto, 200);
        }
    

    public function update(Request $request, $id)
        {
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
                'curso' => 'sometimes|string',
                'alumnos' => 'sometimes|string',
                'video_url' => 'nullable|url',
                'checked' => 'sometimes|boolean',
                'observaciones' => 'nullable|string',
            ]);

            $proyecto->update($data);

            return response()->json($proyecto, 200);
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
