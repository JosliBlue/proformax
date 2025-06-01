@extends('appsita')

@php
    $items = [];

    // Agregar opciones comunes
    $items[] = [
        'icono' => 'line-md:person-filled',
        'titulo' => 'Clientes',
        'texto' => 'Gestión de clientes',
        'ruta' => 'customers',
    ];
    $items[] = [
        'icono' => 'line-md:file-document-filled',
        'titulo' => 'Proformas',
        'texto' => 'Crear y editar proformas',
        'ruta' => 'papers',
    ];
    $items[] = [
        'icono' => 'line-md:briefcase-filled',
        'titulo' => 'Productos',
        'texto' => 'Lista de productos',
        'ruta' => 'products',
    ];

    // Opciones de gerente
    if (auth()->check() && (auth()->user()->isGerente() || auth()->user()->isVendedor())) {
        $items[] = [
            'icono' => 'line-md:emoji-neutral-filled',
            'titulo' => 'Usuarios',
            'texto' => 'Gestión de usuarios',
            'ruta' => 'sellers',
        ];
        $items[] = [
            'icono' => 'line-md:cog-filled-loop',
            'titulo' => 'Configuración',
            'texto' => 'Ajustes de la empresa',
            'ruta' => 'settings',
        ];
    }
@endphp

@section('content')
    {{-- Contenedor Flex de tarjetas --}}
    <div class="flex flex-wrap items-stretch justify-center gap-4 md:gap-6">
        @foreach ($items as $item)
            <a href="{{ route($item['ruta']) }}"
                class="w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(25%-1.5rem)]
                      group relative overflow-hidden rounded-xl transition-all duration-300
                      bg-white dark:bg-gray-800
                      dark:hover:bg-gray-700
                      hover:-translate-y-1
                      flex flex-col
                      border-2 border-transparent
                      hover:border-[var(--primary-color)] dark:hover:border-[var(--secondary-color)]">

                {{-- Contenido de la tarjeta --}}
                <div class="p-5 flex flex-col items-center text-center flex-grow justify-center">
                    {{-- Icono con contenedor circular --}}
                    <div
                        class="mb-4 p-3 rounded-full bg-gray-100 dark:bg-gray-700/50
                                group-hover:bg-[var(--primary-color)]/10 transition-all duration-300
                                flex items-center justify-center">
                        <span
                            class="iconify w-14 h-14 text-gray-700 dark:text-gray-300
                                  group-hover:text-[var(--primary-color)] dark:group-hover:text-white
                                  transition-colors duration-300"
                            data-icon="{{ $item['icono'] }}"></span>
                    </div>

                    {{-- Título --}}
                    <h2
                        class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200
                               group-hover:text-[var(--primary-color)] dark:group-hover:text-white
                               transition-colors duration-300">
                        {{ $item['titulo'] }}
                    </h2>

                    {{-- Descripción --}}
                    <p
                        class="text-xs md:text-sm text-gray-600 dark:text-gray-400
                              group-hover:text-gray-800 dark:group-hover:text-gray-300
                              transition-colors duration-300 px-2">
                        {{ $item['texto'] }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto de carga progresiva para las tarjetas
            const cards = document.querySelectorAll('.flex > a');
            cards.forEach((card, index) => {
                card.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => {
                    card.classList.remove('opacity-0', 'translate-y-4');
                    card.classList.add('opacity-100', 'translate-y-0');
                }, 50 * index);
            });
        });
    </script>
@endpush
