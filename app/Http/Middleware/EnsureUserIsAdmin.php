<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado y su rol es "administrador"
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->withErrors(['access' => 'No tienes permiso para acceder a esta sección.']);
        }

        return $next($request);
    }
}
