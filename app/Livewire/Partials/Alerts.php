<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class Alerts extends Component
{
    public $type;
    public $message;
    public $show = true;
    public $link = null;
    public $linkText = null;
    public $floating = true;
    public $autoclose = 5000; // 5 segundos en milisegundos

    protected $listeners = ['showAlert' => 'show'];

    public function mount($type = 'info', $message = '', $link = null, $linkText = null, $floating = true, $autoclose = 5000)
    {
        $this->type = $type;
        $this->message = $message;
        $this->link = $link;
        $this->linkText = $linkText;
        $this->floating = $floating;
        $this->autoclose = $autoclose;
    }

    public function dismiss()
    {
        $this->show = false;
    }

    public function show($type, $message, $link = null, $linkText = null, $floating = true, $autoclose = 5000)
    {
        $this->type = $type;
        $this->message = $message;
        $this->link = $link;
        $this->linkText = $linkText;
        $this->floating = $floating;
        $this->autoclose = $autoclose;
        $this->show = true;

        // Reiniciar el temporizador de auto-cierre
        $this->dispatch('startAutoClose', duration: $this->autoclose);
    }
    public function render()
    {
        return view('components.partials.alerts');
    }
}
