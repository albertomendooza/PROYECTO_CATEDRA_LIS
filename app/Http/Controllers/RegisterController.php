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

    // Maneja el registro del usuario
    public function register(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string',
        ]);

        // Crear nuevo usuario
        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password); 
        $user->role = $request->role;
        $user->is_active = 1; // Valor predeterminado para 'is_active'
        $user->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->updated_at = $user->created_at; 

        $user->save();

        return redirect()->route('dashboard')->with('status', 'Usuario registrado exitosamente');
    }
}
