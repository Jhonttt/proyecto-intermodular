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

    public function check($id) {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->checked = true;
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

    // La ruta 'admin.proyectos.edit' no existe aún
    // public function edit($id)
    // {
    //     $proyecto = Proyecto::findOrFail($id);

    //     return view('admin.proyectos.edit', compact('proyecto'));
    // }

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
