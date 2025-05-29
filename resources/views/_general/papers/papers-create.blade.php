@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm mb-6">
        <a href="{{ route('papers') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ isset($paper) ? 'Editar Documento' : 'Nuevo Documento' }}
        </h1>
    </div>

    <form action="{{ isset($paper) ? route('papers.update', $paper->id) : route('papers.store') }}" method="POST"
        class="space-y-6" autocomplete="on" spellcheck="true">
        @csrf
        @if (isset($paper))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Columna izquierda - Información del Cliente -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <span class="iconify h-5 w-5 text-[var(--primary-color)]"
                        data-icon="heroicons:user-circle-20-solid"></span>
                    Información del Cliente
                </h3>

                <!-- Selección de cliente -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cliente *
                    </label>
                    <select name="customer_id" id="customer-select"
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

                <!-- Días de validez -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label for="paper_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Días de validez *
                    </label>
                    <input type="number" name="paper_days" id="paper_days" min="1"
                        value="{{ isset($paper) ? $paper->paper_days : '7' }}" required
                        class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                </div>
            </div>

            <!-- Columna derecha - Productos -->
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                        <span class="iconify h-5 w-5 text-[var(--primary-color)]"
                            data-icon="heroicons:shopping-bag-20-solid"></span>
                        Productos
                    </h3>
                    <button type="button" id="add-product"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-4 py-2.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                        <span class="iconify h-5 w-5" data-icon="heroicons:plus-20-solid"></span>
                        Añadir Producto
                    </button>
                </div>

                <!-- Contenedor de productos -->
                <div id="products-container" class="space-y-4">
                    <!-- Los productos se añadirán aquí dinámicamente -->
                </div>

                <!-- Total -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-gray-800 dark:text-gray-200">Total:</span>
                        <span id="total-price" class="text-xl font-bold text-gray-800 dark:text-gray-200">$0.00</span>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('papers') }}"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-gray-500 text-white hover:bg-opacity-90 px-6 py-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                        Cancelar
                    </a>
                    <button type="submit" id="submit-btn"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                        <span class="iconify h-5 w-5" data-icon="heroicons:check-20-solid"></span>
                        {{ isset($paper) ? 'Actualizar Documento' : 'Guardar Documento' }}
                    </button>
                    <button type="submit" name="save_draft" value="1"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-yellow-400 text-gray-900 hover:bg-yellow-500 px-6 py-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                        <span class="iconify h-5 w-5" data-icon="mdi:content-save-edit"></span>
                        Guardar como borrador
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Plantilla para productos
            const productTemplate = (index = 0, product = null) => `
                <div class="product-item p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700" data-index="${index}">
                    <div class="grid grid-cols-12 gap-3 items-end">
                        <!-- Selector de producto -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Producto *</label>
                            <select name="products[${index}][id]" required
                                class="product-select w-full px-4 py-3 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
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

                        <!-- Cantidad -->
                        <div class="col-span-4 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cantidad *</label>
                            <input type="number" name="products[${index}][quantity]" min="1" value="${product ? product.quantity : 1}" required
                                class="w-full px-4 py-3 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                        </div>

                        <!-- Precio Unitario -->
                        <div class="col-span-4 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Precio *</label>
                            <input type="number" step="0.01" min="0" name="products[${index}][unit_price]" required
                                value="${product ? product.unit_price : ''}"
                                class="w-full px-4 py-3 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                        </div>

                        <!-- Botón Eliminar -->
                        <div class="col-span-2 md:col-span-1 flex justify-center items-end h-full">
                            <button type="button" class="remove-product h-[42px] w-[42px] flex items-center justify-center text-red-500 hover:text-red-700 transition-colors duration-150 border border-red-500 hover:border-red-700 rounded-lg">
                                <span class="iconify h-5 w-5" data-icon="heroicons:trash-20-solid"></span>
                            </button>
                        </div>

                        <!-- Subtotal -->
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
