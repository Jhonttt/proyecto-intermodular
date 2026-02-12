<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoControllerAdmin extends Controller
{
    /**
     * Mostrar el listado de proyectos y los filtros por:
     * -curso
     * -nombre
     * -alumno
     */
    public function index(Request $request)
    {
        $query = Proyecto::query();
        //Filtro por curso
        if ($request->filled('curso')) {
            $query->where('curso', 'like', '%' . $request->curso . '%');
        }
        //Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        //Filtro por alumno
        if ($request->filled('alumnos')) {
            $query->where('alumnos', 'like', '%' . $request->alumnos . '%');
        }

        $proyectos = $query->paginate(10)->withQueryString();

        return view('admin.proyectos.index', compact('proyectos'));
    }
    public function show($id)
    {
        $proyecto = Proyecto::findOrFail($id);

        return view('admin.proyects.show', compact('proyecto'));
    }

    public function check($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->checked = true;
        $proyecto->save();

        return redirect()
            ->route('admin.proyectos.show', $id)
            ->with('success', 'Proyecto validado correctamente');
    }
}
