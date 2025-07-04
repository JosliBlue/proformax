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
                    placeholder="Ej: Tarjetas de presentación, Consultoría contable"
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
                    <option value="">Selecciona si es producto físico o servicio</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->value }}"
                            {{ old('product_type', isset($product) ? ($product->product_type instanceof \App\Enums\ProductType ? $product->product_type->value : $product->product_type) : '') == $type->value ? 'selected' : '' }}>
                            @switch($type->value)
                                @case('producto')
                                    Producto - Artículo físico o digital
                                @break

                                @case('servicio')
                                    Servicio - Trabajo o consultoría
                                @break

                                @default
                                    {{ ucfirst($type->value) }}
                            @endswitch
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
                <div class="relative">
                    <span
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">$</span>
                    <input type="text" name="product_price_display" id="product_price_display"
                        value="{{ old('product_price', isset($product) ? number_format($product->product_price ?? 0, 2) : '') }}"
                        placeholder="0.00 (ej: 1,250.50)"
                        class="w-full pl-8 pr-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md">
                    <input type="hidden" name="product_price" id="product_price" required>
                </div>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceDisplay = document.getElementById('product_price_display');
            const priceHidden = document.getElementById('product_price');

            // Función para formatear el número con comas y limitar a 2 decimales
            function formatPrice(value) {
                // Remover todo excepto números y punto decimal
                let cleanValue = value.replace(/[^0-9.]/g, '');

                // Si hay múltiples puntos, mantener solo el primero
                const parts = cleanValue.split('.');
                if (parts.length > 2) {
                    cleanValue = parts[0] + '.' + parts.slice(1).join('');
                }

                // Limitar a 2 decimales
                if (parts.length === 2 && parts[1].length > 2) {
                    cleanValue = parts[0] + '.' + parts[1].substring(0, 2);
                }

                // Convertir a número para validación
                const numValue = parseFloat(cleanValue);
                if (isNaN(numValue)) {
                    return '';
                }

                // Separar parte entera y decimal
                const [integerPart, decimalPart] = cleanValue.split('.');

                // Agregar comas a la parte entera
                const formattedInteger = parseInt(integerPart).toLocaleString('en-US');

                // Combinar con decimales si existen
                let formatted = formattedInteger;
                if (decimalPart !== undefined) {
                    formatted += '.' + decimalPart;
                }

                return formatted;
            }

            // Función para obtener el valor numérico limpio
            function getCleanValue(value) {
                return value.replace(/[^0-9.]/g, '');
            }

            // Validar que solo se ingresen números, puntos y comas
            priceDisplay.addEventListener('input', function(e) {
                const cursorPosition = e.target.selectionStart;
                const oldValue = e.target.value;
                const oldLength = oldValue.length;

                // Formatear el valor
                const formatted = formatPrice(e.target.value);
                e.target.value = formatted;

                // Actualizar el campo oculto con el valor limpio
                const cleanValue = getCleanValue(formatted);
                priceHidden.value = cleanValue;

                // Ajustar la posición del cursor
                const newLength = formatted.length;
                const lengthDiff = newLength - oldLength;
                e.target.setSelectionRange(cursorPosition + lengthDiff, cursorPosition + lengthDiff);
            });

            // Validar al salir del campo
            priceDisplay.addEventListener('blur', function(e) {
                const value = e.target.value;
                if (value && !value.match(/^\d{1,3}(,\d{3})*(\.\d{0,2})?$/)) {
                    // Si el formato no es válido, reformatear
                    const cleanValue = getCleanValue(value);
                    if (cleanValue && !isNaN(parseFloat(cleanValue))) {
                        const numValue = parseFloat(cleanValue);
                        e.target.value = numValue.toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        priceHidden.value = numValue.toFixed(2);
                    }
                } else if (value) {
                    // Actualizar el campo oculto
                    priceHidden.value = getCleanValue(value);
                }
            });

            // Prevenir caracteres no válidos
            priceDisplay.addEventListener('keypress', function(e) {
                const char = String.fromCharCode(e.which);
                const currentValue = e.target.value;

                // Permitir números, punto decimal, backspace, delete, tab, escape, enter
                if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
                    // Permitir Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                    (e.keyCode === 65 && e.ctrlKey === true) ||
                    (e.keyCode === 67 && e.ctrlKey === true) ||
                    (e.keyCode === 86 && e.ctrlKey === true) ||
                    (e.keyCode === 88 && e.ctrlKey === true)) {
                    return;
                }

                // Verificar si es un número
                if (!/[0-9]/.test(char)) {
                    // Permitir punto decimal solo si no hay uno ya
                    if (char === '.' && currentValue.indexOf('.') === -1) {
                        return;
                    }
                    e.preventDefault();
                    return;
                }
            });

            // Inicializar el valor del campo oculto al cargar la página
            if (priceDisplay.value) {
                priceHidden.value = getCleanValue(priceDisplay.value);
            }

            // Validación antes de enviar el formulario
            const form = priceDisplay.closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const displayValue = priceDisplay.value;
                    const cleanValue = getCleanValue(displayValue);

                    if (!cleanValue || isNaN(parseFloat(cleanValue))) {
                        e.preventDefault();
                        priceDisplay.focus();

                        // Mostrar mensaje de error
                        const errorMsg = document.createElement('div');
                        errorMsg.className =
                            'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50';
                        errorMsg.innerHTML = `
                    <span class="iconify h-5 w-5 inline mr-2" data-icon="heroicons:exclamation-circle-20-solid"></span>
                    Por favor ingresa un precio válido
                `;
                        document.body.appendChild(errorMsg);
                        setTimeout(() => errorMsg.remove(), 3000);
                        return false;
                    }

                    // Asegurar que el valor final esté en el campo oculto
                    priceHidden.value = parseFloat(cleanValue).toFixed(2);
                });
            }
        });
    </script>
@endpush
