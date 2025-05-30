<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Si no está autenticado, dejar pasar
        if (!$user) {
            return $next($request);
        }

        // Si es admin, dejar pasar
        if (method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin')) {
            return $next($request);
        }

        $isActive = method_exists($user, 'isActive') ? $user->isActive() : ($user->active ?? false);
        $allowedRoutes = ['profile', 'profile.update', 'logout', 'deactivated'];

        // Si está desactivado y NO está accediendo a profile o logout, redirigir
        if (!$isActive && !$request->routeIs($allowedRoutes)) {
            return redirect()->route('deactivated');
        }

        // Si está en la ruta de desactivado y ya está activo, redirigir al home
        if ($isActive && $request->routeIs('deactivated')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
