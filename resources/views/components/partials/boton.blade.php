@props([
    'type' => 'button',
    'href' => null,
    'class' => null,
    'wireClick' => null,
    'onclick' => null,
    'style' => 'azul'
])

@php
    $baseClasses = 'w-full sm:w-auto cursor-pointer focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all duration-200 ease-in-out text-center';

    $styles = [
        'azul' => 'text-white bg-blue-600 hover:bg-blue-800',
        'limpiar' => 'text-black bg-gray-400 hover:bg-gray-600'
    ];

    // Clases finales
    $classes = $baseClasses . ' ' . ($styles[$style] ?? $styles['azul']) . ' ' . ($class ?? '');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if($wireClick) wire:click="{{ $wireClick }}" @endif
        @if($onclick) onclick="{{ $onclick }}" @endif
    >
        {{ $slot }}
    </button>
@endif
