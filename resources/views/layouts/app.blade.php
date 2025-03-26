<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/tailwind-josliblue.js') }}"></script>
    <script src="{{ asset('js/iconify.min.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: "Inter", sans-serif !important;
            font-optical-sizing: auto;
            font-weight: normal;
            font-style: normal;
        }

        .btn-sito {
            border-radius: 50px;
        }
    </style>

    @livewireStyles
</head>

<body>
    {{-- si viene de una vista blade tradicional --}}
    @hasSection('content')
        {{-- Aqui se llama al header --}}
        @livewire('global.header')

        {{-- Aqui se llama a los breadcrumbs si no estan en home --}}
        @if (Route::currentRouteName() !== 'home')
            {{ Breadcrumbs::render(Route::currentRouteName()) }}
        @endif

        {{-- Aqui se llama carga la vista que llama el controlador --}}
        <div class="mx-4 md:mx-20">
            @yield('content')
        </div>

        {{-- si viene de un componente de livewire(componente que ocupara toda la pantalla) --}}
    @else
        {{ $slot }}
    @endif

    {{-- Scripts para q funcione livewire --}}
    @livewireScripts
    {{-- Scripts personalizados --}}
    @stack('scripts')
</body>

</html>
