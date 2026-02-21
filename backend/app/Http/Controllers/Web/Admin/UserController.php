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

    public function store(Request $request) {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'rol' => 'required|in:admin,usu',
        ]);

        User::create([
            'name' => $validator["name"],
            'email' => $validator["email"],
            'password' => bcrypt($validator["password"]),
            'rol' => $validator["rol"],
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

    public function update(Request $request, $id) {
        $usuario = User::findOrFail($id);

        $data = $request->validate([
            'name'     => 'required|string',
            'password' => 'nullable|min:6',
            'rol'      => 'required|in:admin,usu',
            'activo'   => 'nullable|boolean',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $data['activo'] = $request->has('activo') ? 1 : 0;

        $usuario->update($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }
}
