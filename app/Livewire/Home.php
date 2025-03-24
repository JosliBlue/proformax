<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $items;
    public function render()
    {
        $this->items = [
            ['icono' => 'ph:users-bold', 'titulo' => 'Clientes', 'texto' => 'Gestión de clientes', 'ruta' => 'customers'],
            ['icono' => 'mdi:papers-outline', 'titulo' => 'Proformas', 'texto' => 'Crear y editar proformas', 'ruta' => 'papers'],
            ['icono' => 'ph:gear-bold', 'titulo' => 'Configuración', 'texto' => 'Opciones avanzadas', 'ruta' => 'configs'],
        ];
        return view('components.livewire.home');
    }
}
