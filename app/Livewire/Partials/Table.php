<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class Table extends Component
{
    public $columns;
    public $rows;

    public function mount($columns, $rows)
    {
        $this->columns = $columns;
        $this->rows = $rows;
    }
    public function render()
    {
        return view('components.partials.table');
    }
}
