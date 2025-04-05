<div class="w-full">
    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
        <!-- Input de búsqueda -->
        <input type="text" wire:model.debounce.500ms="search" placeholder="{{ $placeholder }}"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- Contenedor de botones -->
        <div class="flex gap-2 w-full sm:w-auto">
            <!-- Botón Buscar -->
            @component('components.partials.boton', ['wireClick' => 'performSearch'])
                Buscar
            @endcomponent

            <!-- Botón Limpiar (solo visible con búsqueda) -->
            @if ($search)
                @component('components.partials.boton', [
                    'wireClick' => 'clearSearch',
                    'style' => 'limpiar',
                ])
                    Limpiar
                @endcomponent
            @endif
        </div>
    </div>
</div>
