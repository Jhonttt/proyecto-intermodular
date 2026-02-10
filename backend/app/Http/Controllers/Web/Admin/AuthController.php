<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //Muestra el formulario de login
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    
    public function login(Request $request)
    {
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
            if (!isset($user->role) || $user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'No tienes permisos para acceder al panel de administración.',
                ]);
            }

            //Comprobar si es un usuario activo
            if (isset($user->is_active) && !$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta está inactiva. Contacta con un administrador.',
                ]);
            }

            //Si todo OK, redirige al panel
            return redirect()->route('admin.dashboard');
        }

        //En caso de credenciales incorrectas, avisa del error
        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ]);
    }

    /**
     * Valida email y contraseña, autentifica con Laravel
     * Bloquea usuarios no admin e inactivos
     * Regenera sesión
     * Redirige al dashboard
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
