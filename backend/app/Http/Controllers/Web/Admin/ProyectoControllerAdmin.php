<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProyectoControllerAdmin extends Controller {
    /**
     * Mostrar el listado de proyectos y los filtros por:
     * -nombre
     * -ciclo
     * -alumno
     */
    public function index(Request $request) {
        $query = Proyecto::query();

        //Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        //Filtro por ciclo
        if ($request->filled('ciclo')) {
            $query->where('ciclo', 'like', '%' . $request->ciclo . '%');
        }
        //Filtro por alumno/alumnos
        if ($request->filled('alumnos')) {

            $buscar = trim($request->alumnos);

            // Quitar acentos y pasar a minúsculas
            $buscar = mb_strtolower($buscar);
            $buscar = strtr($buscar, [
                'á' => 'a',
                'é' => 'e',
                'í' => 'i',
                'ó' => 'o',
                'ú' => 'u',
                'Á' => 'a',
                'É' => 'e',
                'Í' => 'i',
                'Ó' => 'o',
                'Ú' => 'u'
            ]);

            $query->whereRaw(
                "
                JSON_SEARCH(
                    LOWER(
                        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
                            alumnos,
                            'á','a'),
                            'é','e'),
                            'í','i'),
                            'ó','o'),
                            'ú','u'
                        )
                    ),
                    'all',
                    ?,
                    NULL,
                    '$[*]'
                ) IS NOT NULL",
                ["%{$buscar}%"]
            );
            /*             $query->whereRaw(
                            "JSON_SEARCH(alumnos COLLATE utf8mb4_0900_ai_ci, 'one', ?, NULL, '$[*]') IS NOT NULL",
                            ["%{$buscar}%"] 
                        ); SOLO COMPATIBLE CON MYSQL 8+*/
        }

        $proyectos = $query->paginate(10)->withQueryString(); //Paginado de 10

        return view('admin.proyectos.index', compact('proyectos'));
    }

    public function show($id) {
        $proyecto = Proyecto::findOrFail($id);

        return view('admin.proyectos.show', compact('proyecto'));
    }

    public function check(Request $request, $id) {

        $request->validate([
            'observaciones' => 'nullable|string|max:2000',
        ]);

        $proyecto = Proyecto::findOrFail($id);

        $proyecto->checked = true;
        $proyecto->observaciones = $request->observaciones;
        $proyecto->save();

        return redirect()
            ->route('admin.proyectos.show', $id)
            ->with('success', 'Proyecto validado correctamente');
    }

    public function uncheck($id) {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->checked = false;
        $proyecto->save();

        return redirect()->back();
    }

    public function edit($id) {
         $proyecto = Proyecto::findOrFail($id);

         return view('admin.proyectos.edit', compact('proyecto'));
    }

    public function update(Request $request, $id) {
        $proyecto = Proyecto::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ciclo' => 'required|string|max:255',
            'anio' => 'required|string|max:255',
            'alumnos' => 'required|array',
            'alumnos.*' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
            'video' => 'nullable|file|mimes:mp4,mov,avi,mkv,wmv|max:30720',
            'documentos' => 'nullable',
            'documentos.*' => 'file|max:10240|mimes:pdf,docx,pptx,zip,rar',
            'documentos_eliminar' => 'nullable|array',
            'documentos_eliminar.*' => 'string',
        ]);

        $proyecto->nombre = $validated['nombre'];
        $proyecto->descripcion = $validated['descripcion'];
        $proyecto->ciclo = $validated['ciclo'];
        $proyecto->anio = $validated['anio'];
        $proyecto->alumnos = array_values(
            array_filter($validated['alumnos'], fn ($a) => trim($a) !== '')
        );
        $proyecto->tags = array_values(
            array_filter($validated['tags'] ?? [], fn ($t) => trim($t) !== '')
        );

        if ($request->hasFile('video')) {

            if ($proyecto->video_url) {
                Storage::disk('public')->delete('proyectos/' . $proyecto->video_url);
            }

            $path = $request->file('video');

            $nombre = $path->getClientOriginalName();

            $path->storeAs('proyectos', $nombre, 'public');

            $proyecto->video_url = $nombre;
            
        }

        $documentosActuales = $proyecto->documentos ?? [];

        $documentosEliminar = $request->input('documentos_eliminar', []);

        if (!empty($documentosEliminar)) {
            foreach ($documentosEliminar as $doc) {
                Storage::disk('public')->delete($doc);
            }

            $documentosActuales = array_values(
                array_diff($documentosActuales, $documentosEliminar)
            );
        }

        if ($request->hasFile('documentos')) {
            foreach ($request->file('documentos') as $file) {
                $originalName = $file->getClientOriginalName();

                $file->storeAs(
                    'proyectos/documentos',
                    $originalName,
                    'public'
                );

                $documentosActuales[] = $originalName;
            }
        }

        $proyecto->documentos = $documentosActuales;

        $proyecto->save();

        return redirect()
            ->route('admin.proyectos.show', $proyecto->id)
            ->with('success', 'Proyecto actualizado correctamente');
    }

    public function destroy($id) {
        $proyecto = Proyecto::findOrFail($id);

        // Eliminar video
        if ($proyecto->video_url) {
            Storage::disk('public')->delete('proyectos/' . $proyecto->video_url);
        }

        // Eliminar thumbnail
        if ($proyecto->video_thumbnail) {
            Storage::disk('public')->delete($proyecto->video_thumbnail);
        }

        // Eliminar documentos
        if ($proyecto->documentos) {
            foreach ($proyecto->documentos as $doc) {
                Storage::disk('public')->delete($doc);
            }
        }

        $proyecto->delete();

        return redirect()
            ->route('admin.proyectos.index')
            ->with('success', 'Proyecto eliminado correctamente');
    }
}
