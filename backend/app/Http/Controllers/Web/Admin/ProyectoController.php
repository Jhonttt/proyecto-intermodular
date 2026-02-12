<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
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
