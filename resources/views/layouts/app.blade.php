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
    @stack('styles')
    @livewireStyles
</head>

<body>
    {{-- si viene de una vista blade tradicional --}}
    @hasSection('content')
        {{-- Aqui se llama al header --}}
        @livewire('global.header')

        <!-- Mostrar alertas de sesión -->
        @if (session()->has('success'))
            @livewire('partials.alerts', [
                'type' => 'success',
                'message' => session('success'),
                'floating' => true,
                'autoclose' => 5000,
            ])
        @endif

        @if (session()->has('error'))
            @livewire('partials.alerts', [
                'type' => 'danger',
                'message' => session('error'),
                'floating' => true,
                'autoclose' => 5000,
            ])
        @endif

        {{-- Aqui se llama a los breadcrumbs si no estan en home --}}
        @if (Route::currentRouteName() !== 'home')
            @if (class_exists('Breadcrumbs'))
                {{ Breadcrumbs::render(Route::currentRouteName()) }}
            @endif
        @endif

        {{-- Aqui se carga la vista que llama el controlador --}}
        {{-- El javascript de este id solo se aplica cuando esta en Home(el proceso esta en home) --}}
        <div class="mx-4 rounded-lg md:mx-20 md:p-4 md:bg-blue-200" id="WhenEnHome">
            {{-- Aqui se carga el contenido --}}
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
