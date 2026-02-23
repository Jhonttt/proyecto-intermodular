<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    //Muestra el formulario de login
    public function showLogin() {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        //Validar formulario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //Intentar el login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            //Comprobar si es admin
            if (empty($user->rol) || $user->rol !== 'admin') {
                Auth::logout();
                $request->session()->flush();
                return redirect()->route("admin.login.index")->withErrors([
                    'email' => 'No tienes permisos para acceder al panel de administración.',
                ]);
            }

            //Comprobar si es un usuario activo
            if (isset($user->is_active) && !$user->is_active) {
                Auth::logout();
                $request->session()->flush();
                return redirect()->route("admin.login.index")->withErrors([
                    'email' => 'Tu cuenta está inactiva. Contacta con un administrador.',
                ]);
            }

            //Si todo OK, redirige al panel
            return redirect()->route('admin.proyectos.index');
        }

        // Distinguir entre correo no encontrado y contraseña incorrecta
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route("admin.login.index")->withInput()->withErrors([
                'email' => 'No existe ninguna cuenta con ese correo.',
            ]);
        }

        return redirect()->route("admin.login.index")->withInput()->withErrors([
            'password' => 'La contraseña es incorrecta.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->flush();

        return redirect()->route('admin.login.index');
    }
}