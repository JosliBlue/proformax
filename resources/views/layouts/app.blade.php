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
    <!-- si viene de una vista blade tradicional -->
    @hasSection('content')
        <x-global.header />
        <div class="flex flex-col p-4 gap-4 mx-0 md:mx-16" id="cuerpecito">
            <div>
                Home / Inicio / loginsito xdddd
            </div>

            <div class="grid flex-1">
                <!-- Elemento que ocupa todo el espacio disponible -->
                @yield('content')
            </div>
        </div>

    <!-- si viene de un componente de livewire(componente que ocupara toda la pantalla) -->
    @else
        {{ $slot }}
    @endif



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('header');
            const headerHeight = header.offsetHeight;


            const mainContent = document.getElementById('cuerpecito');

            if (mainContent) {
                // Para pantallas más grandes (md y mayores)
                if (window.innerWidth >= 768) {
                    mainContent.style.height = `calc(100vh - ${headerHeight}px)`;
                } else {
                    // Para pantallas móviles, la altura será automática
                    mainContent.style.height = 'auto';
                }
            }
        });

        // Aseguramos que también se ajuste cuando cambie el tamaño de la ventana
        window.addEventListener('resize', function() {
            const header = document.querySelector('header');
            const headerHeight = header.offsetHeight;
            const mainContent = document.getElementById('cuerpecito');

            if (mainContent) {
                if (window.innerWidth >= 768) {
                    mainContent.style.height = `calc(100vh - ${headerHeight}px)`;
                } else {
                    mainContent.style.height = 'auto';
                }
            }
        });
    </script>
    <!-- Scripts para q funcione livewire -->
    @livewireScripts
    <!-- Scripts personalizados -->
    @stack('scripts')
</body>

</html>
