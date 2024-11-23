<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class RegisterController extends Controller
{
    // Muestra el formulario de registro
    public function showRegistrationForm()
    {
        return view('auth.register'); 
    }

    public function register(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|in:cliente,empresa,admin',
    ]);

    // Determinar el estado de aprobación según el rol
    $approved = $request->role === 'empresa' ? 0 : 1;

    // Crear el usuario
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'is_active' => 0,
        'approved' => $approved, // Establecemos la aprobación
    ]);

    // Redirigir al inicio con un mensaje de éxito
    return redirect()->route('login')->with('status', 'Usuario registrado exitosamente');
}


}
