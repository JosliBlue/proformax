<?php

namespace App\View\Components\partials;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public string $modalId = 'defaultModal',
        public string $title = ''
    ) {}

    public function render()
    {
        return view('components.partials.modal');
    }
}
