<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'No tienes permiso para acceder a esta página.');
            }
            return $next($request);
        })->except('index');
    }

    /**
     * Muestra la vista principal del dashboard.
     */
    public function index()
{
    // Obtén los usuarios pendientes de aprobación
    $pendingUsers = User::where('approved', false)->get();

    // Pasa la variable a la vista
    return view('dashboard', compact('pendingUsers'));
}


    /**
     * Muestra los usuarios pendientes de aprobación.
     */
    public function approvals()
    {
        $pendingUsers = User::where('approved', false)->get();

        return view('approvals', compact('pendingUsers'));
    }

    /**
     * Aprueba a un usuario pendiente.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveUser($id)
{
    $user = User::findOrFail($id); // Busca el usuario por ID

    if ($user->approved) {
        return response()->json(['message' => 'El usuario ya está aprobado.'], 200);
    }

    $user->approved = true; // Cambia el estado de aprobación
    $user->save(); // Guarda los cambios en la base de datos

    return response()->json(['message' => 'Usuario aprobado exitosamente.'], 200);
}


    /**
     * Rechaza (elimina) a un usuario pendiente.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('dashboard.approvals')->with('success', 'Usuario rechazado y eliminado exitosamente.');
    }
}
