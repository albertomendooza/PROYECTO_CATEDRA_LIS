<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retorna la vista de registro estándar (solo cliente o empresa)
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Validar el registro estándar
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:cliente,empresa'], // Restringir roles en el registro estándar
        ]);

        // Crear el usuario con los datos validados
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Solo cliente o empresa permitido
            'is_active' => false, // Los nuevos usuarios no estarán activos por defecto
            'approved' => false, // Los usuarios necesitan aprobación
        ]);

        // Disparar el evento de registro
        event(new Registered($user));

        // Loguear al usuario recién registrado
        Auth::login($user);

        // Redirigir al usuario a la página principal
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the admin registration view.
     *
     * @return \Illuminate\View\View
     */
    public function createAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }
    
        // Pasar un indicador para diferenciar el formulario de administrador
        return view('auth.register', ['isAdmin' => true]);
    }
    

    /**
     * Handle admin user creation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(Request $request)
    {
        // Verificar autorización para crear usuarios
        $this->authorize('create', User::class);

        // Validar el formulario de creación
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:cliente,empresa,admin'], // Permitir todos los roles
        ]);

        // Crear el usuario con los datos proporcionados
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true, // Activo por defecto al ser creado por un admin
            'approved' => true, // Aprobado por defecto al ser creado por un admin
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.register')->with('success', 'Usuario creado exitosamente.');
    }
}
