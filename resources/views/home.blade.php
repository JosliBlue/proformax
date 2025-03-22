@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center h-full">
    <div class="flex flex-wrap items-center justify-center gap-4 w-full max-w-6xl">
        <!-- Tarjeta 1 -->
        <div class="bg-blue-500 text-white flex items-center justify-center w-full sm:w-32 h-32 rounded-lg shadow-md">
            <span>Opción 1</span>
        </div>

        <!-- Tarjeta 2 (más grande) -->
        <div class="bg-red-500 text-white flex items-center justify-center w-full sm:w-48 h-48 rounded-lg shadow-md">
            <span>Opción 2</span>
        </div>

        <!-- Tarjeta 3 (más pequeña) -->
        <div class="bg-yellow-500 text-white flex items-center justify-center w-full sm:w-28 h-28 rounded-lg shadow-md">
            <span>Opción 3</span>
        </div>

        <!-- Tarjeta 4 -->
        <div class="bg-green-500 text-white flex items-center justify-center w-full sm:w-36 h-36 rounded-lg shadow-md">
            <span>Opción 4</span>
        </div>

    </div>
</div>
@endsection
