<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $company->company_name }}</title>
    <meta name="theme-color" content="{{ $company->company_primary_color }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $company->company_name }}: Sistema de gestión de proformas, clientes y productos para tu empresa.">

    <link rel="icon" href="{{ $company->getLogoUrlAttribute() }}" type="image/webp">

    <link rel="stylesheet" href="{{ asset('css/css2-google_fonts.css') }}">

    <script src="{{ asset('js/tailwind-3_4_16.js') }}"></script>
    <script src="{{ asset('js/iconify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script>
        // Configuración de Tailwind
        tailwind.config = {
            darkMode: 'class'
        };

        // Función para aplicar el tema inicial
        function applyInitialTheme() {
            // 1. Verificar localStorage
            const savedTheme = localStorage.getItem('theme');
            // 2. Verificar preferencia del sistema
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            // 3. Aplicar tema oscuro si:
            //    - Hay tema guardado en localStorage como 'dark' O
            //    - No hay tema guardado Y el sistema prefiere oscuro
            if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
                document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = 'dark';
            }
        }

        // Aplicar tema al cargar la página
        applyInitialTheme();
    </script>
    <style>
        :root {
            --primary-color: {{ $company->company_primary_color }};
            --secondary-color: {{ $company->company_secondary_color }};
            --primary-text-color: {{ $company->company_primary_text_color }};
            --secondary-text-color: {{ $company->company_secondary_text_color }};
            --mi-oscuro: #010812;
        }

        * {
            font-family: "Inter", sans-serif !important;
            font-optical-sizing: auto;
            font-weight: normal;
            font-style: normal;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-[#eeeff1] dark:bg-[var(--mi-oscuro)]">
    {{-- TOASTS PARA NOTIFICACIONES --}}
    @if (session('success'))
        <x-partials.toast-sweet_alert icon="success" message="{{ session('success') }}" />
    @elseif (session('error'))
        <x-partials.toast-sweet_alert icon="error" message="{{ session('error') }}" />
    @elseif (session('warning'))
        <x-partials.toast-sweet_alert icon="warning" message="{{ session('warning') }}" />
    @elseif (session('info'))
        <x-partials.toast-sweet_alert icon="info" message="{{ session('info') }}" />
    @elseif(session('question'))
        <x-partials.toast-sweet_alert icon="question" message="{{ session('question') }}" />
    @endif

    @if (Route::currentRouteName() == 'login')
        {{-- Solo muestra el contenido del login --}}
        @yield('content')
    @else
        <div class="min-h-dvh grid grid-rows-[auto_1fr_auto]">
            <x-header class="row-start-1" />

            <section>
                {{-- Contenido principal --}}
                <main class="m-4 md:mx-20 row-start-2">
                    @yield('content')
                </main>
            </section>

            <x-footer class="row-start-3" />
        </div>
    @endif

    <!-- Incluir el componente de alertas -->
    <x-partials.sweet-alert />
    @stack('scripts')
</body>

</html>
