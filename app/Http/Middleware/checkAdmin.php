<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado y tiene el rol GERENTE y VENDEDOR
        if (Auth::user()->isGerente() || Auth::user()->isVendedor()) {
            // Redirigir si no está autenticado o no tiene el rol adecuado
            return $next($request);
        }

        return redirect()->route('home');
    }
}
