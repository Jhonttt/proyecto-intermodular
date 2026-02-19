<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        $usuarios = User::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create() {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'rol' => 'required|in:admin,usu',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'rol' => $request->rol,
        'activo' => $request->has('activo') ? 1 : 0,
    ]);

    return redirect()
        ->route('admin.usuarios.index')
        ->with('success', 'Usuario creado correctamente.');
}


    public function edit($id) {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'rol' => 'required|in:admin,usu',
        'activo' => 'required|boolean',
    ]);

    $usuario = User::findOrFail($id);

    $usuario->update([
        'rol' => $request->rol,
        'activo' => $request->activo,
    ]);

    return redirect()
        ->route('admin.usuarios.index')
        ->with('success', 'Usuario actualizado correctamente.');
}

}