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
    {{-- Tarjeta de bienvenida --}}
    <div class="pb-4 select-none">
        <div class="flex items-center">
            <div>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">¡Bienvenido de vuelta! 👋🏽</h4>
            </div>
        </div>
    </div>

    {{-- Cuadros de estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 select-none">
        {{-- Clientes totales --}}
        <div
            class="bg-white dark:bg-gray-900 rounded-xl py-4 px-6 shadow-xl border border-gray-100 dark:border-gray-800 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-blue-500/10 dark:bg-blue-400/20 rounded-xl flex items-center justify-center">
                        <span class="iconify w-7 h-7 text-blue-600 dark:text-blue-400"
                            data-icon="line-md:person-filled"></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Clientes</h3>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $statistics['customers'] }}</p>
                </div>
            </div>
        </div>

        {{-- Proformas totales --}}
        <div
            class="bg-white dark:bg-gray-900 rounded-xl py-4 px-6 shadow-xl border border-gray-100 dark:border-gray-800 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-green-500/10 dark:bg-green-400/20 rounded-xl flex items-center justify-center">
                        <span class="iconify w-7 h-7 text-green-600 dark:text-green-400"
                            data-icon="line-md:file-document-filled"></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Proformas</h3>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $statistics['papers']['total'] }}</p>
                </div>
            </div>
            <div class="flex gap-4 text-xs">
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-gray-600 dark:text-gray-400">{{ $statistics['papers']['vigentes'] }} vigentes</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                    <span class="text-gray-600 dark:text-gray-400">{{ $statistics['papers']['vencidas'] }} vencidas</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                    <span class="text-gray-600 dark:text-gray-400">{{ $statistics['papers']['borradores'] }}
                        borradores</span>
                </div>
            </div>
        </div>

        {{-- Productos totales --}}
        <div
            class="bg-white dark:bg-gray-900 rounded-xl py-4 px-6 shadow-xl border border-gray-100 dark:border-gray-800 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div
                        class="w-14 h-14 bg-purple-500/10 dark:bg-purple-400/20 rounded-xl flex items-center justify-center">
                        <span class="iconify w-7 h-7 text-purple-600 dark:text-purple-400"
                            data-icon="line-md:briefcase-filled"></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Productos</h3>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $statistics['products']['total'] }}</p>
                </div>
            </div>
            <div class="flex gap-4 text-xs">
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                    <span class="text-gray-600 dark:text-gray-400">{{ $statistics['products']['productos'] }}
                        productos</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                    <span class="text-gray-600 dark:text-gray-400">{{ $statistics['products']['servicios'] }}
                        servicios</span>
                </div>
            </div>
        </div>

        {{-- Usuarios totales --}}
        <div
            class="bg-white dark:bg-gray-900 rounded-xl py-4 px-6 shadow-xl border border-gray-100 dark:border-gray-800 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div
                        class="w-14 h-14 bg-orange-500/10 dark:bg-orange-400/20 rounded-xl flex items-center justify-center">
                        <span class="iconify w-7 h-7 text-orange-600 dark:text-orange-400"
                            data-icon="line-md:emoji-neutral-filled"></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Usuarios</h3>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $statistics['users']['total'] }}</p>
                </div>
            </div>
            <div class="flex gap-4 text-xs">
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <span class="text-gray-600 dark:text-gray-400">{{ $statistics['users']['vendedores'] }}
                        vendedores</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                    <span class="text-gray-600 dark:text-gray-400">{{ $statistics['users']['pasantes'] }} pasantes</span>
                </div>
            </div>
        </div>
    </div>

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
            // Efecto de carga progresiva para la tarjeta de bienvenida
            const welcomeCard = document.querySelector('.bg-white.dark\\:bg-gray-900.rounded-xl.py-6');
            if (welcomeCard) {
                welcomeCard.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => {
                    welcomeCard.classList.remove('opacity-0', 'translate-y-4');
                    welcomeCard.classList.add('opacity-100', 'translate-y-0');
                }, 50);
            }

            // Efecto de carga progresiva para los cuadros de estadísticas
            const statsCards = document.querySelectorAll('.grid > div');
            statsCards.forEach((card, index) => {
                card.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => {
                    card.classList.remove('opacity-0', 'translate-y-4');
                    card.classList.add('opacity-100', 'translate-y-0');
                }, 100 + (50 * index));
            });

            // Efecto de carga progresiva para las tarjetas de navegación
            const navCards = document.querySelectorAll('.flex > a');
            navCards.forEach((card, index) => {
                card.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => {
                    card.classList.remove('opacity-0', 'translate-y-4');
                    card.classList.add('opacity-100', 'translate-y-0');
                }, 100 + (50 * (statsCards.length + index)));
            });
        });
    </script>
@endpush
