@extends('appsita')

@section('content')
    {{--
    @if (isset($product))
        <h2
            class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
            Editar producto</h2>
    @else
        <h2
            class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
            Nuevo producto</h2>
    @endif
 --}}

    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST"
        class="my-5" autocomplete="on" spellcheck="true">
        @csrf
        @if (isset($product))
            @method('PUT')
        @endif

        {{-- Token de seguridad adicional --}}
        <input type="hidden" name="form_token" value="{{ Str::random(40) }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nombre del Producto --}}
            <div>
                <label for="product_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Nombre del Producto *
                </label>
                <input type="text" name="product_name" id="product_name"
                    value="{{ old('product_name', $product->product_name ?? '') }}" required
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
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
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
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
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                @error('product_price')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Botones --}}
        <div class="pt-4 flex justify-end gap-3">
            <button type="submit"
                class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-2.5 rounded-lg transition-all duration-200">
                {{ isset($product) ? 'Actualizar producto' : 'Guardar producto' }}
            </button>
        </div>
    </form>
@endsection
