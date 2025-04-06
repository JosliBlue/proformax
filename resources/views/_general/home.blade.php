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

    if (auth()->check() && auth()->user()->isAdmin()) {
        $items[] = [
            'icono' => 'line-md:briefcase-filled',
            'titulo' => 'Productos',
            'texto' => 'Lista de productos',
            'ruta' => 'products',
        ];
        $items[] = [
            'icono' => 'line-md:emoji-neutral-filled',
            'titulo' => 'Vendedores',
            'texto' => 'Mis vendedores',
            'ruta' => 'sellers',
        ];
        $items[] = [
            'icono' => 'line-md:cog-filled-loop',
            'titulo' => 'Preferencias',
            'texto' => 'Configurar mi app',
            'ruta' => 'settings',
        ];
    }
@endphp

@section('content')
    <div class="flex flex-wrap items-center justify-center gap-4">
        @foreach ($items as $item)
            <a href="{{ route($item['ruta']) }}"
                class="w-full sm:w-50 group sm:aspect-square p-4 flex flex-col items-center justify-center text-center
                     rounded-lg shadow-lg bg-gray-200 hover:-translate-y-2 duration-500 transition-transform">
                <span class="iconify w-15 h-15 text-black group-hover:w-20 group-hover:h-20 duration-500 transition-all"
                    data-icon="{{ $item['icono'] }}"></span>
                <p class="text-3xl font-medium text-gray-900 group-hover:text-2xl duration-500 transition-all">
                    {{ $item['titulo'] }}
                </p>
                <p class="text-sm leading-tight text-gray-500">
                    {{ $item['texto'] }}
                </p>
            </a>
        @endforeach
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const enHomeElement = document.getElementById('WhenEnHome');
            if (enHomeElement) {
                enHomeElement.classList.add('mt-2');
            }
        });
    </script>
@endpush
