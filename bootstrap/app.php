<?php

use App\Http\Middleware\companyStyles;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // aqui se ve un ejemplo de como quedaria un metodo sin necesidad de archivo a parte
        // Captura la excepción de ruta no encontrada (404)
        /*
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            return redirect()->route('login'); // Cambia 'pagina.especifica' por el nombre de tu ruta
        });
        */
        // No se toma en cuenta porque ya esta puesto en routes/web.php
    })->create();
