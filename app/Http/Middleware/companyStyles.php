<?php

namespace App\Http\Middleware;

use App\Enums\MyColors;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class companyStyles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = Company::default();
        if (Auth::check() && Auth::user()->company !== null) {
            $company = Auth::user()->company;
        }

        // Compartir las variables con todas las vistas
        view()->share('company', $company);

        return $next($request);
    }
}
