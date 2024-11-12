<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Redirige a 'dashboard' después de un inicio de sesión exitoso
    protected $redirectTo = '/dashboard';

    public function showLoginForm()
    {
        return view('auth.login'); // Apunta a la vista del login
    }

    public function login(Request $request)
    {
        // Valida los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Intenta autenticar al usuario
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Redirige al dashboard si la autenticación es exitosa
            return redirect()->intended($this->redirectTo);
        }

        // Redirige de nuevo al formulario de login con un mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login'); // Redirige al formulario de login después de cerrar sesión
    }
}
