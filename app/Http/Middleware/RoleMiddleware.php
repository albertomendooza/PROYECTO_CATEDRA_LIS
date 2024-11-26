<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role  Uno o más roles requeridos (separados por "|")
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verificar si el usuario está autenticado
        if (!$request->user()) {
            return redirect()->route('login')->with('error', __('Debe iniciar sesión para acceder a esta página.'));
        }

        // Convertir los roles a un array
        $roles = explode('|', $role);

        // Verificar si el rol del usuario coincide con los roles permitidos
        if (!in_array($request->user()->role, $roles)) {
            abort(403, __('No tienes permiso para acceder a esta página.'));
        }

        return $next($request);
    }
}
