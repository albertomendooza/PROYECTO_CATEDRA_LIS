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
        // Validar los datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:cliente,empresa'], // Restringir roles en el registro estándar
        ]);
    
        // Determinar valores para campos según el rol
        $isApproved = $request->role === 'cliente' ? true : false; // Cliente aprobado automáticamente
        $isActive = $request->role === 'cliente' ? true : false;   // Cliente activo automáticamente
    
        // Crear el usuario con los datos validados
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $isActive, // Clientes activos por defecto
            'approved' => $isApproved, // Clientes aprobados por defecto
        ]);
    
        // Disparar el evento de registro (opcional)
        event(new Registered($user));
    
        // Mensaje según el tipo de usuario
        $message = $request->role === 'empresa'
            ? 'Tu cuenta se ha registrado correctamente. Por favor, espera la aprobación del administrador.'
            : 'Tu cuenta se ha registrado correctamente. Ahora puedes iniciar sesión.';
    
        // Redirigir al login con el mensaje correcto
        return redirect('/login')->with('status', $message);
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
