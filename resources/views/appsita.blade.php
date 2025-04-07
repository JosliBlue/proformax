<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/css2-google_fonts.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <script src="{{ asset('js/tailwind-josliblue.js') }}"></script>
    <script src="{{ asset('js/iconify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11') }}"></script>

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

</head>

<body>
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
        <x-partials.header />
        {{-- Aqui se llama a los breadcrumbs si no estan en home --}}
        @if (Route::currentRouteName() !== 'home')
            {{ Breadcrumbs::render(Route::currentRouteName()) }}
        @endif

        {{-- Aqui se carga la vista que llama el controlador --}}
        {{-- El javascript de este id solo se aplica cuando esta en Home(el proceso esta en home) --}}
        <div class="mx-4 rounded-lg md:mx-20 md:p-4 md:bg-blue-200" id="WhenEnHome">
            {{-- Aqui se carga el contenido --}}
            @yield('content')
        </div>

    @endif

    {{-- Scripts personalizados --}}
    @stack('scripts')
</body>

</html>
