<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para bloquear acciones de modificación a usuarios DEMO
 * 
 * Los usuarios de la compañía DEMO (company_id = 3) tienen acceso de solo lectura.
 * Este middleware bloquea todas las peticiones que modifiquen datos (POST, PUT, PATCH, DELETE).
 */
class CheckDemoUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario es DEMO
        if (isDemoUser()) {
            // Bloquear métodos que modifican datos
            if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                return back()->with('error', '⚠️ Usuario DEMO: No tienes permisos para realizar esta acción. Esta es una cuenta de demostración de solo lectura.');
            }
        }

        return $next($request);
    }
}
