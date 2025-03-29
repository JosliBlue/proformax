<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $items;
    public function render()
    {
        $this->items = [
            ['icono' => 'line-md:person-filled', 'titulo' => 'Clientes', 'texto' => 'Gestión de clientes', 'ruta' => 'customers'],
            ['icono' => 'line-md:file-document-filled', 'titulo' => 'Proformas', 'texto' => 'Crear y editar proformas', 'ruta' => 'papers'],
            ['icono' => 'line-md:cog-filled-loop', 'titulo' => 'Preferencias', 'texto' => 'Opciones avanzadas', 'ruta' => 'configs'],
            ['icono' => 'line-md:briefcase-filled', 'titulo' => 'Productos', 'texto' => 'Opciones avanzadas', 'ruta' => 'configs'],
            ['icono' => 'line-md:emoji-neutral-filled', 'titulo' => 'Vendedores', 'texto' => 'Opciones avanzadas', 'ruta' => 'configs'],
        ];
        return view('components.livewire.home');
    }
}
