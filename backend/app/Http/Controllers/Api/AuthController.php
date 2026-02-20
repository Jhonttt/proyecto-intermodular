<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function login(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->activo) {
            Auth::logout();
            return response()->json([
                'message' => 'Usuario inactivo'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login Exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'rol' => $user->rol
            ]
        ], 200);
    }

    public function logout(Request $request) {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout Exitoso'
        ], 200);

    }
}