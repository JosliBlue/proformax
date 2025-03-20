<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/iconify.min.js') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    @livewireStyles <!-- Incluye los estilos de Livewire -->
</head>

<body>
    {{ $slot }} <!-- O el contenido dinámico de tu layout -->

    @livewireScripts <!-- Incluye los scripts de Livewire -->
</body>

</html>
