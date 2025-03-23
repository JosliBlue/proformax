<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Home extends Component
{
    public $items;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items = [
            ['icono' => 'ph:users-bold', 'titulo' => 'Clientes', 'texto' => 'Gestión de clientes', 'ruta' => 'customers'],
            ['icono' => 'mdi:papers-outline', 'titulo' => 'Proformas', 'texto' => 'Crear y editar proformas', 'ruta' => 'papers'],
            ['icono' => 'ph:gear-bold', 'titulo' => 'Configuración', 'texto' => 'Opciones avanzadas', 'ruta' => 'configs'],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home');
    }
}
