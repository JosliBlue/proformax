<?php

/**
 * Verifica si el usuario autenticado pertenece a la compañía DEMO (company_id = 3)
 * Los usuarios DEMO tienen acceso de solo lectura al sistema
 *
 * @return bool
 */
if (!function_exists('isDemoUser')) {
    function isDemoUser()
    {
        return auth()->check() && auth()->user()->company_id === 3;
    }
}
