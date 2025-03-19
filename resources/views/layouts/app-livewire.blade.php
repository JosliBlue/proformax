<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet">
    @livewireStyles <!-- Incluye los estilos de Livewire -->
</head>

<body>
    {{ $slot }} <!-- O el contenido dinámico de tu layout -->

    @livewireScripts <!-- Incluye los scripts de Livewire -->
</body>

</html>
