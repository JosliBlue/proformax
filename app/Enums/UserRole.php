<?php

namespace App\Enums;

enum UserRole: string
{
    case GERENTE = 'gerente';
    case VENDEDOR = 'vendedor';
    case PASANTE = 'pasante';
}
