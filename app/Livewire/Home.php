<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Home extends Component
{
    public $items;
    public function render()
    {
       // Inicializar el array vacío
       $this->items = [];

       // Agregar opciones comunes
       $this->items[] = ['icono' => 'line-md:person-filled', 'titulo' => 'Clientes', 'texto' => 'Gestión de clientes', 'ruta' => 'customers'];
       $this->items[] = ['icono' => 'line-md:file-document-filled', 'titulo' => 'Proformas', 'texto' => 'Crear y editar proformas', 'ruta' => 'papers'];

       // Verificar si el usuario es administrador y agregar opciones adicionales
       if (Auth::user() && Auth::user()->isAdmin()) {
           $this->items[] = ['icono' => 'line-md:briefcase-filled', 'titulo' => 'Productos', 'texto' => 'Lista de productos', 'ruta' => 'products'];
           $this->items[] = ['icono' => 'line-md:emoji-neutral-filled', 'titulo' => 'Vendedores', 'texto' => 'Mis vendedores', 'ruta' => 'sellers'];
           $this->items[] = ['icono' => 'line-md:cog-filled-loop', 'titulo' => 'Preferencias', 'texto' => 'Configurar mi app', 'ruta' => 'settings'];
       }
        return view('components.livewire.home');
    }
}
