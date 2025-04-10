@extends('appsita')

@section('content')
    <div class="md:p-6 bg-white md:rounded-xl md:shadow-md">
        @if (isset($product))
            <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Editar producto</h2>
        @else
            <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Nuevo producto</h2>
        @endif

        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}"
            method="POST" class="space-y-6" autocomplete="on">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            {{-- Protección contra bots --}}
            <div class="hidden" aria-hidden="true">
                <label for="website">Sitio web</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre del Producto --}}
                <div>
                    <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Producto *</label>
                    <input type="text" name="product_name" id="product_name"
                        value="{{ old('product_name', $product->product_name ?? '') }}" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                    @error('product_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipo de Producto --}}
                <div>
                    <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                    <select name="product_type" id="product_type" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                        <option value="">Seleccione un tipo</option>
                        @foreach($types as $type)
                            <option value="{{ $type->value }}"
                                {{ old('product_type', $product->product_type ?? '') == $type->value ? 'selected' : '' }}>
                                {{ ucfirst($type->value) }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Precio --}}
                <div>
                    <label for="product_price" class="block text-sm font-medium text-gray-700 mb-1">Precio *</label>
                    <input type="number" step="0.01" min="0" name="product_price" id="product_price"
                        value="{{ old('product_price', $product->product_price ?? '') }}" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                    @error('product_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botón Guardar --}}
            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('products') }}"
                    class="inline-flex justify-center px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                    Cancelar
                </a>
                <button type="submit"
                    class="inline-flex justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                    {{ isset($product) ? 'Actualizar Producto' : 'Guardar Producto' }}
                </button>
            </div>
        </form>
    </div>
@endsection
