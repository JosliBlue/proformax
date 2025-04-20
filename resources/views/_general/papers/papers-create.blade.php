@extends('appsita')

@section('content')
    <form action="{{ isset($paper) ? route('papers.update', $paper->id) : route('papers.store') }}" method="POST"
        autocomplete="on" spellcheck="true">
        @csrf
        @if (isset($paper))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Columna izquierda - Cliente -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Información del Cliente</h3>

                <!-- Selección de cliente existente -->
                <div>
                    <div class="relative">
                        <select name="customer_id" id="customer-select" required
                            class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                            <option value="">Seleccione un cliente</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ isset($paper) && $paper->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->customer_name }} {{ $customer->customer_lastname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Días del documento -->
                <div class="mt-6">
                    <label for="paper_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Días de validez *
                    </label>
                    <input type="number" name="paper_days" id="paper_days" min="1"
                        value="{{ isset($paper) ? $paper->paper_days : '7' }}" required
                        class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                </div>
            </div>

            <!-- Columna derecha - Productos -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Productos</h3>
                    <button type="button" id="add-product"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-4 py-2.5 rounded-lg transition-all duration-200">
                        <span class="iconify h-5 w-5" data-icon="heroicons:plus-20-solid"></span>
                        Añadir Producto
                    </button>
                </div>

                <div id="products-container" class="space-y-4">
                    <!-- Productos se añadirán aquí dinámicamente -->
                </div>

                <!-- Total -->
                <div
                    class="mt-6 p-4 bg-white md:bg-gray-100 dark:bg-gray-800 dark:md:bg-gray-700 rounded-lg border-none dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-gray-800 dark:text-gray-200">Total:</span>
                        <span id="total-price" class="text-xl font-bold text-gray-800 dark:text-gray-200">$0.00</span>
                    </div>
                </div>

                <!-- Botones -->
                <div class="pt-6 flex justify-end gap-3">
                    <a href="{{ route('papers') }}"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-gray-500 text-white hover:bg-opacity-90 px-5 py-2.5 rounded-lg transition-all duration-200">
                        Cancelar
                    </a>
                    <button type="submit" id="submit-btn"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-5 py-2.5 rounded-lg transition-all duration-200">
                        {{ isset($paper) ? 'Actualizar Documento' : 'Guardar Documento' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Plantilla para productos con botón eliminar en línea
            const productTemplate = (index = 0, product = null) => `
                <div class="product-item p-4 bg-white md:bg-gray-100 rounded-lg dark:bg-gray-800 dark:md:bg-gray-700" data-index="${index}">
                    <div class="grid grid-cols-12 gap-3 items-end">
                        <!-- Selector de producto (ocupa más espacio) -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Producto *</label>
                            <select name="products[${index}][id]" required
                                class="product-select w-full px-3 py-2 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                                <option value="">Seleccione un producto</option>
                                @foreach ($products as $prod)
                                    <option value="{{ $prod->id }}"
                                        data-price="{{ $prod->product_price }}"
                                        ${product && product.id == {{ $prod->id }} ? 'selected' : ''}>
                                        {{ $prod->product_name }} - ${{ number_format($prod->product_price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cantidad (proporción media) -->
                        <div class="col-span-4 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cantidad *</label>
                            <input type="number" name="products[${index}][quantity]" min="1" value="${product ? product.quantity : 1}" required
                                class="w-full px-3 py-2 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                        </div>

                        <!-- Precio Unitario (proporción media) -->
                        <div class="col-span-4 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Precio *</label>
                            <input type="number" step="0.01" min="0" name="products[${index}][unit_price]" required
                                value="${product ? product.unit_price : ''}"
                                class="w-full px-3 py-2 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                        </div>

                        <!-- Botón Eliminar (espacio mínimo) -->
                        <div class="col-span-2 md:col-span-1 flex justify-center items-end h-full">
                            <button type="button" class="remove-product h-[42px] w-[42px] flex items-center justify-center text-red-500 hover:text-red-700 transition-colors duration-150 border border-red-500 hover:border-red-700 rounded-lg">
                                <span class="iconify h-5 w-5" data-icon="heroicons:trash-20-solid"></span>
                            </button>
                        </div>

                        <!-- Subtotal (espacio ajustado) -->
                        <div class="col-span-2 md:col-span-1 flex justify-end items-center">
                            <span class="product-subtotal text-sm font-medium text-gray-800 dark:text-gray-200 whitespace-nowrap">$0.00</span>
                        </div>
                    </div>
                </div>
            `;

            // Contador de productos
            let productCount = 0;
            const productsContainer = document.getElementById('products-container');

            // Si hay productos seleccionados (modo edición), los añadimos
            @if (isset($selectedProducts) && count($selectedProducts) > 0)
                @foreach ($selectedProducts as $index => $product)
                    addProduct(@json($product));
                @endforeach
            @else
                // Si no hay productos, añadir uno vacío (modo creación)
                addProduct();
            @endif

            // Función para añadir producto
            function addProduct(product = null) {
                const index = productCount++;
                productsContainer.insertAdjacentHTML('beforeend', productTemplate(index, product));

                // Configurar eventos para el nuevo producto
                const productItem = productsContainer.lastElementChild;
                setupProductEvents(productItem, index);

                // Calcular total inicial
                calculateTotal();
            }

            // Función para configurar eventos de un producto
            function setupProductEvents(productItem, index) {
                const productSelect = productItem.querySelector('select');
                const quantityInput = productItem.querySelector('input[name*="quantity"]');
                const priceInput = productItem.querySelector('input[name*="unit_price"]');
                const subtotalSpan = productItem.querySelector('.product-subtotal');
                const removeBtn = productItem.querySelector('.remove-product');

                // Autocompletar precio cuando se selecciona un producto
                productSelect.addEventListener('change', function() {
                    const selectedOption = productSelect.options[productSelect.selectedIndex];
                    if (selectedOption.dataset.price) {
                        priceInput.value = selectedOption.dataset.price;
                        calculateSubtotal(productItem);
                    }
                });

                // Calcular subtotal cuando cambia cantidad o precio
                quantityInput.addEventListener('input', () => calculateSubtotal(productItem));
                priceInput.addEventListener('input', () => calculateSubtotal(productItem));

                // Eliminar producto
                removeBtn.addEventListener('click', function() {
                    productItem.remove();
                    calculateTotal();

                    // Si no quedan productos, añadir uno nuevo
                    if (document.querySelectorAll('.product-item').length === 0) {
                        addProduct();
                    }
                });

                // Calcular subtotal inicial
                calculateSubtotal(productItem);
            }

            // Función para calcular subtotal de un producto
            function calculateSubtotal(productItem) {
                const quantity = parseFloat(productItem.querySelector('input[name*="quantity"]').value) || 0;
                const price = parseFloat(productItem.querySelector('input[name*="unit_price"]').value) || 0;
                const subtotal = quantity * price;

                productItem.querySelector('.product-subtotal').textContent =
                    `$${subtotal.toFixed(2)}`;

                calculateTotal();
            }

            // Función para calcular el total
            function calculateTotal() {
                let total = 0;

                document.querySelectorAll('.product-item').forEach(item => {
                    const quantity = parseFloat(item.querySelector('input[name*="quantity"]').value) || 0;
                    const price = parseFloat(item.querySelector('input[name*="unit_price"]').value) || 0;
                    total += quantity * price;
                });

                document.getElementById('total-price').textContent = `$${total.toFixed(2)}`;
            }

            // Añadir nuevo producto al hacer clic en el botón
            document.getElementById('add-product').addEventListener('click', () => addProduct());
        });
    </script>
@endpush
