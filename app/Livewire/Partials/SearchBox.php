<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class SearchBox extends Component
{
    public $search = '';
    public $route;
    public $placeholder;
    public $additionalParams = [];

    public function mount($route, $placeholder = 'Buscar...', $additionalParams = [])
    {
        $this->route = $route;
        $this->placeholder = $placeholder;
        $this->additionalParams = $additionalParams;
        $this->search = request('search', '');
    }

    public function performSearch()
    {
        return redirect()->route($this->route, array_merge(
            $this->additionalParams,
            ['search' => $this->search]
        ));
    }

    public function clearSearch()
    {
        $this->search = '';
        return redirect()->route($this->route, $this->additionalParams);
    }
    public function render()
    {
        return view('components.partials.search-box');
    }
}
