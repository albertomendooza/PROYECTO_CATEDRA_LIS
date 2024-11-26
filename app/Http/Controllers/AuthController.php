<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Redirige al dashboard después de un inicio de sesión exitoso
    protected $redirectTo = '/';

    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Apunta a la vista del login
    }

    /**
     * Maneja el inicio de sesión.
     */
    public function login(Request $request)
    {
        // Valida los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Verifica si el usuario existe
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            // Si el usuario no existe, lanza un error
            return back()->withErrors([
                'email' => 'No se encontró una cuenta con este correo electrónico.',
            ])->withInput($request->only('email', 'remember'));
        }

        if (!$user->approved) {
            // Si el usuario no está aprobado, lanza un error
            return back()->withErrors([
                'email' => 'Tu cuenta no ha sido aprobada aún. Por favor, espera la aprobación del administrador.',
            ])->withInput($request->only('email', 'remember'));
        }

        // Intenta autenticar al usuario
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Redirige al dashboard si la autenticación es exitosa
            return redirect()->intended($this->redirectTo);
        }

        // Si las credenciales son incorrectas, lanza un error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * Maneja el cierre de sesión.
     */
    public function logout()
    {
        Auth::logout(); // Cierra la sesión del usuario actual
        return redirect('/login'); // Redirige al formulario de login
    }
}
