<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Maneja la verificación de roles para las rutas protegidas.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Verificar que el usuario tenga una sesión activa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder al panel pastoral.');
        }

        $user = $request->user();

        // 2. Si no se definieron roles específicos, permitir paso
        if (empty($roles)) {
            return $next($request);
        }

        // 3. Validar si el usuario cuenta con alguno de los roles requeridos
        if (!$user->hasRole($roles)) {
            abort(403, 'Acceso restringido: No cuenta con el rol requerido (' . implode(', ', $roles) . ') para ingresar a esta sección.');
        }

        return $next($request);
    }
}
