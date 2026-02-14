<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller {
  /**
   * GET /api/admin/users
   * Listar todos los usuarios
   */
  public function index(Request $request) {
    // Verificar que el usuario autenticado sea admin
    $user = $request->user();
    if ($user->rol !== 'admin') {
      return response()->json([
        'success' => false,
        'message' => 'No autorizado. Solo los administradores pueden acceder.'
      ], 403);
    }

    $usuarios = User::all();

    return response()->json([
      'success' => true,
      'data' => $usuarios
    ], 200);
  }

  /**
   * POST /api/admin/users
   * Crear un nuevo usuario
   */
  public function store(Request $request) {
    // Verificar que el usuario autenticado sea admin
    $user = $request->user();
    if ($user->rol !== 'admin') {
      return response()->json([
        'success' => false,
        'message' => 'No autorizado. Solo los administradores pueden crear usuarios.'
      ], 403);
    }

    // Validar datos con mensajes personalizados
    try {
      $validated = $request->validate([
        'name' => [
          'required',
          'string',
          'max:255',
          'min:2'
        ],
        'email' => [
          'required',
          'email',
          'max:255',
          'unique:users,email'
        ],
        'password' => [
          'required',
          'string',
          'min:8',
          'max:255'
        ],
        'rol' => [
          'required',
          Rule::in(['admin', 'usu'])
        ],
      ], [
        // Mensajes personalizados en español
        'name.required' => 'El nombre es obligatorio.',
        'name.min' => 'El nombre debe tener al menos 2 caracteres.',
        'name.max' => 'El nombre no puede superar los 255 caracteres.',
        
        'email.required' => 'El email es obligatorio.',
        'email.email' => 'El email debe ser una dirección válida.',
        'email.unique' => 'Este email ya está registrado.',
        'email.max' => 'El email no puede superar los 255 caracteres.',
        
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'password.max' => 'La contraseña no puede superar los 255 caracteres.',
        
        'rol.required' => 'El rol es obligatorio.',
        'rol.in' => 'El rol debe ser "admin" o "usu".',
      ]);

    } catch (ValidationException $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error de validación',
        'errors' => $e->errors()
      ], 422);
    }

    // Crear usuario
    try {
      $nuevoUsuario = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'rol' => $validated['rol'],
        'activo' => 1,
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Usuario creado correctamente',
        'data' => $nuevoUsuario
      ], 201);

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error al crear el usuario',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  /**
   * GET /api/admin/users/{id}
   * Obtener un usuario específico
   */
  public function show(Request $request, $id) {
    // Verificar que el usuario autenticado sea admin
    $user = $request->user();
    if ($user->rol !== 'admin') {
      return response()->json([
        'success' => false,
        'message' => 'No autorizado. Solo los administradores pueden ver usuarios.'
      ], 403);
    }

    // Validar que el ID sea numérico
    if (!is_numeric($id)) {
      return response()->json([
        'success' => false,
        'message' => 'ID de usuario inválido'
      ], 400);
    }

    $usuario = User::find($id);

    if (!$usuario) {
      return response()->json([
        'success' => false,
        'message' => 'Usuario no encontrado'
      ], 404);
    }

    return response()->json([
      'success' => true,
      'data' => $usuario
    ], 200);
  }

  /**
   * PUT/PATCH /api/admin/users/{id}
   * Actualizar un usuario
   */
  public function update(Request $request, $id) {
    // Verificar que el usuario autenticado sea admin
    $user = $request->user();
    if ($user->rol !== 'admin') {
      return response()->json([
        'success' => false,
        'message' => 'No autorizado. Solo los administradores pueden actualizar usuarios.'
      ], 403);
    }

    // Validar que el ID sea numérico
    if (!is_numeric($id)) {
      return response()->json([
        'success' => false,
        'message' => 'ID de usuario inválido'
      ], 400);
    }

    $usuario = User::find($id);

    if (!$usuario) {
      return response()->json([
        'success' => false,
        'message' => 'Usuario no encontrado'
      ], 404);
    }

    // Validar datos
    try {
      $validated = $request->validate([
        'name' => [
          'sometimes',
          'string',
          'max:255',
          'min:2'
        ],
        'email' => [
          'sometimes',
          'email',
          'max:255',
          Rule::unique('users')->ignore($id)
        ],
        'password' => [
          'sometimes',
          'string',
          'min:8',
          'max:255'
        ],
        'rol' => [
          'sometimes',
          Rule::in(['admin', 'usu'])
        ],
        'activo' => [
          'sometimes',
          'boolean'
        ],
      ], [
        // Mensajes personalizados
        'name.min' => 'El nombre debe tener al menos 2 caracteres.',
        'name.max' => 'El nombre no puede superar los 255 caracteres.',
        
        'email.email' => 'El email debe ser una dirección válida.',
        'email.unique' => 'Este email ya está registrado.',
        'email.max' => 'El email no puede superar los 255 caracteres.',
        
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'password.max' => 'La contraseña no puede superar los 255 caracteres.',
        
        'rol.in' => 'El rol debe ser "admin" o "usu".',
        
        'activo.boolean' => 'El campo activo debe ser verdadero o falso.',
      ]);

    } catch (ValidationException $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error de validación',
        'errors' => $e->errors()
      ], 422);
    }

    // Actualizar datos
    try {
      if (isset($validated['name'])) {
        $usuario->name = $validated['name'];
      }
      if (isset($validated['email'])) {
        $usuario->email = $validated['email'];
      }
      if (isset($validated['password'])) {
        $usuario->password = Hash::make($validated['password']);
      }
      if (isset($validated['rol'])) {
        $usuario->rol = $validated['rol'];
      }
      if (isset($validated['activo'])) {
        $usuario->activo = $validated['activo'];
      }

      $usuario->save();

      return response()->json([
        'success' => true,
        'message' => 'Usuario actualizado correctamente',
        'data' => $usuario
      ], 200);

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error al actualizar el usuario',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  /**
   * DELETE /api/admin/users/{id}
   * Eliminar un usuario
   */
  public function destroy(Request $request, $id) {
    // Verificar que el usuario autenticado sea admin
    $user = $request->user();
    if ($user->rol !== 'admin') {
      return response()->json([
        'success' => false,
        'message' => 'No autorizado. Solo los administradores pueden eliminar usuarios.'
      ], 403);
    }

    // Validar que el ID sea numérico
    if (!is_numeric($id)) {
      return response()->json([
        'success' => false,
        'message' => 'ID de usuario inválido'
      ], 400);
    }

    $usuario = User::find($id);

    if (!$usuario) {
      return response()->json([
        'success' => false,
        'message' => 'Usuario no encontrado'
      ], 404);
    }

    // Evitar que el admin se elimine a sí mismo
    if ($usuario->id === $user->id) {
      return response()->json([
        'success' => false,
        'message' => 'No puedes eliminarte a ti mismo'
      ], 400);
    }

    try {
      $usuario->delete();

      return response()->json([
        'success' => true,
        'message' => 'Usuario eliminado correctamente'
      ], 200);

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error al eliminar el usuario',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}