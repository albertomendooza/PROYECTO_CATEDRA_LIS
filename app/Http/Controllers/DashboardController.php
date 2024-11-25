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
        return view('dashboard'); // Asegúrate de que esta vista existe
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
        $user = User::findOrFail($id);

        if ($user->approved) {
            return redirect()->route('dashboard.approvals')->with('warning', 'El usuario ya está aprobado.');
        }

        $user->approved = true;
        $user->save();

        return redirect()->route('dashboard.approvals')->with('success', 'Usuario aprobado exitosamente.');
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
