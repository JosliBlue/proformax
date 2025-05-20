@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso - Versión con navegación JS -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm mb-6">
        <a href="{{ route('products') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ isset($product) ? 'Editar Producto' : 'Nuevo Producto' }}
        </h1>
    </div>

    <div class="max-w-md mx-auto">
        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST"
            class="space-y-4" autocomplete="on" spellcheck="true">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            {{-- Token de seguridad adicional --}}
            <input type="hidden" name="form_token" value="{{ Str::random(40) }}">

            {{-- Nombre --}}
            <div>
                <label for="product_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Nombre del Producto *
                </label>
                <input type="text" name="product_name" id="product_name"
                    value="{{ old('product_name', $product->product_name ?? '') }}" required
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md"
                    autocomplete="off">
                @error('product_name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipo de Producto --}}
            <div>
                <label for="product_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Tipo *
                </label>
                <select name="product_type" id="product_type" required
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md">
                    <option value="">Seleccione un tipo</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->value }}"
                            {{ old('product_type', $product->product_type ?? '') == $type->value ? 'selected' : '' }}>
                            {{ ucfirst($type->value) }}
                        </option>
                    @endforeach
                </select>
                @error('product_type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Precio --}}
            <div>
                <label for="product_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Precio *
                </label>
                <input type="number" step="0.01" min="0" name="product_price" id="product_price"
                    value="{{ old('product_price', $product->product_price ?? '') }}" required
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md">
                @error('product_price')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="pt-4 flex justify-center gap-3">
                <button type="submit"
                    class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <span class="iconify h-5 w-5" data-icon="fluent:save-20-filled"></span>
                    {{ isset($product) ? 'Actualizar producto' : 'Guardar producto' }}
                </button>
            </div>
        </form>
    </div>
@endsection
