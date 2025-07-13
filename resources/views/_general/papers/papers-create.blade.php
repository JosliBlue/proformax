@extends('appsita')

@section('content')
    <!-- Header with back arrow -->
    <div class="flex items-center gap-3 bg-white dark:bg-gray-800 p-3 rounded-lg shadow-sm mt-2 mb-4">
        <a href="{{ route('papers') }}" class="text-[var(--primary-color)] group focus:outline-none">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ isset($paper) ? 'Editar Documento' : 'Nuevo Documento' }}
        </h1>
    </div>

    <form action="{{ isset($paper) ? route('papers.update', $paper->id) : route('papers.store') }}" method="POST"
        class="space-y-6" autocomplete="on" spellcheck="true" id="papersForm">
        @csrf
        @isset($paper)
            @method('PUT')
        @endisset

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Left Column: Customer Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <span class="iconify h-5 w-5 text-[var(--primary-color)]"
                        data-icon="heroicons:document-text-20-solid"></span>
                    Información de la proforma
                </h3>

                <!-- Customer Selection -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label for="customer-search"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cliente *</label>
                    <div class="relative">
                        <input type="text" id="customer-search" placeholder="Buscar cliente..."
                            class="w-full px-4 py-3 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all">
                        <select name="customer_id" id="customer-select" class="hidden">
                            <option value="">Seleccione un cliente</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    data-name="{{ $customer->customer_name }} {{ $customer->customer_lastname }}"
                                    data-cedula="{{ $customer->customer_cedula ?? '' }}"
                                    data-phone="{{ $customer->customer_phone }}"
                                    {{ (isset($paper) && $paper->customer_id == $customer->id) || (isset($copyCustomerId) && $copyCustomerId == $customer->id) ? 'selected' : '' }}>
                                    {{ $customer->customer_name }} {{ $customer->customer_lastname }}
                                    @if ($customer->customer_cedula)
                                        - {{ $customer->customer_cedula }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <div id="customer-dropdown"
                            class="absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg mt-1 max-h-48 overflow-y-auto hidden">
                        </div>
                    </div>
                </div>

                <!-- Date -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label for="paper_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fecha
                        *</label>
                    <input type="date" name="paper_date" id="paper_date"
                        value="{{ old('paper_date', isset($paper) ? $paper->paper_date : (isset($copyPaperDate) ? $copyPaperDate : now()->format('Y-m-d'))) }}"
                        min="{{ isset($paper) ? $paper->paper_date : now()->format('Y-m-d') }}"
                        max="{{ now()->addDays(30)->format('Y-m-d') }}"
                        required
                        class="w-full px-4 py-3 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all">
                </div>

                <!-- Validity Date -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label for="paper_valid_until"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fecha válida hasta *</label>
                    <input type="date" name="paper_valid_until" id="paper_valid_until"
                        value="{{ old('paper_valid_until', isset($paperValidUntil) ? $paperValidUntil : (isset($copyPaperDays) ? now()->addDays($copyPaperDays)->format('Y-m-d') : now()->addDays(7)->format('Y-m-d'))) }}"
                        min="{{ isset($paper) ? $paper->paper_date : now()->format('Y-m-d') }}"
                        max="{{ now()->addDays(365)->format('Y-m-d') }}" required
                        class="w-full px-4 py-3 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all">
                    <!-- Hidden input for days calculation -->
                    <input type="hidden" name="paper_days" id="paper_days"
                        value="{{ old('paper_days', isset($paper) ? $paper->paper_days : (isset($copyPaperDays) ? $copyPaperDays : '7')) }}">
                    <!-- Days display -->
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <span id="days-info">Días de validez: <span id="days-count"
                                class="font-medium">{{ isset($paper) ? $paper->paper_days : (isset($copyPaperDays) ? $copyPaperDays : '7') }}</span></span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Products -->
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                        <span class="iconify h-5 w-5 text-[var(--primary-color)]"
                            data-icon="heroicons:shopping-bag-20-solid"></span>
                        Productos
                    </h3>
                    <button type="button" id="add-product"
                        class="flex items-center gap-2 bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-4 py-2 rounded-lg transition-all shadow-sm hover:shadow-md hover:-translate-y-1">
                        <span class="iconify h-5 w-5" data-icon="heroicons:plus-20-solid"></span>
                        Añadir Producto
                    </button>
                </div>

                <!-- Products Container -->
                <div id="products-container" class="space-y-4"></div>

                <!-- Total -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-gray-800 dark:text-gray-200">Total:</span>
                        <span id="total-price" class="text-xl font-bold text-gray-800 dark:text-gray-200">$0.00</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col md:flex-row justify-end gap-3 pt-4">
                    <a href="{{ route('papers') }}"
                        class="flex items-center justify-center gap-2 bg-gray-500 text-white hover:bg-opacity-90 px-6 py-3 rounded-lg transition-all shadow-sm hover:shadow-md w-full md:w-auto">Cancelar</a>
                    <button type="submit" name="save_draft" value="1" id="draftBtn"
                        class="flex items-center justify-center gap-2 bg-yellow-400 text-gray-900 hover:bg-yellow-500 px-6 py-3 rounded-lg transition-all shadow-sm hover:shadow-md w-full md:w-auto disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <span class="iconify h-5 w-5" data-icon="mdi:content-save-edit"></span>
                        {{ isset($paper) && $paper->is_draft ? 'Actualizar borrador' : 'Guardar como borrador' }}
                    </button>
                    <button type="submit" id="submitBtn"
                        class="flex items-center justify-center gap-2 bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg transition-all shadow-sm hover:shadow-md w-full md:w-auto disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <span class="iconify h-5 w-5" data-icon="heroicons:check-20-solid"></span>
                        {{ isset($paper) && !$paper->is_draft ? 'Actualizar Proforma' : 'Guardar Proforma' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Utilities
            const debounce = (fn, delay) => {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => fn(...args), delay);
                };
            };

            // Product template
            const productTemplate = (index, product = null) => `
                <div class="product-item p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700" data-index="${index}">
                    <div>
                        <div class="flex flex-wrap gap-3 items-end">
                            <div class="flex-1 min-w-[180px]">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Producto *</label>
                                <div class="relative">
                                    <input type="text" class="product-search w-full px-4 py-3 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all" placeholder="Buscar producto...">
                                    <select name="products[${index}][id]" required class="product-select hidden">
                                        <option value="">Seleccione un producto</option>
                                        @foreach ($products as $prod)
                                            <option value="{{ $prod->id }}"
                                                data-price="{{ $prod->product_price }}"
                                                data-name="{{ $prod->product_name }}"
                                                data-type="{{ $prod->product_type }}"
                                                ${product && product.id == {{ $prod->id }} ? 'selected' : ''}>
                                                {{ $prod->product_name }} - $${{ number_format($prod->product_price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="product-dropdown absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg mt-1 max-h-48 overflow-y-auto hidden"></div>
                                </div>
                            </div>
                            <div class="w-24">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cantidad *</label>
                                <input type="number" name="products[${index}][quantity]" min="1" step="1" value="${product ? product.quantity : 1}" required class="w-full px-4 py-3 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all" oninput="this.value = Math.max(1, Math.floor(this.value))">
                            </div>
                            <div class="w-28">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Precio *</label>
                                <input type="number" step="0.01" min="0" name="products[${index}][unit_price]" value="${product ? product.unit_price : ''}" required class="w-full px-4 py-3 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all">
                            </div>
                            <div>
                                <button type="button" class="remove-product h-10 w-10 flex items-center justify-center text-red-500 hover:text-red-700 border border-red-500 hover:border-red-700 rounded-lg transition-colors mt-6">
                                    <span class="iconify h-5 w-5" data-icon="heroicons:trash-20-solid"></span>
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-end items-center mt-2">
                            <span class="product-subtotal w-full flex items-center justify-end text-base font-semibold text-gray-800 dark:text-gray-200">$0.00</span>
                        </div>
                    </div>
                </div>
            `;

            // Initialize state
            const productsContainer = document.getElementById('products-container');
            let productCount = 0;

            // Add initial products
            @if (isset($selectedProducts) && count($selectedProducts) > 0)
                @foreach ($selectedProducts as $index => $product)
                    addProduct(@json($product));
                @endforeach
            @else
                addProduct();
            @endif

            // Add product
            function addProduct(product = null) {
                productsContainer.insertAdjacentHTML('beforeend', productTemplate(productCount++, product));
                const productItem = productsContainer.lastElementChild;
                initializeProductSearch(productItem);
                calculateSubtotal(productItem);
            }

            // Calculate subtotal
            function calculateSubtotal(productItem) {
                const quantity = parseFloat(productItem.querySelector('input[name*="quantity"]').value) || 0;
                const price = parseFloat(productItem.querySelector('input[name*="unit_price"]').value) || 0;
                const subtotal = quantity * price;
                productItem.querySelector('.product-subtotal').textContent = `$${subtotal.toFixed(2)}`;
                calculateTotal();
            }

            // Calculate total
            function calculateTotal() {
                const total = Array.from(document.querySelectorAll('.product-item')).reduce((sum, item) => {
                    const quantity = parseFloat(item.querySelector('input[name*="quantity"]').value) || 0;
                    const price = parseFloat(item.querySelector('input[name*="unit_price"]').value) || 0;
                    return sum + quantity * price;
                }, 0);
                document.getElementById('total-price').textContent = `$${total.toFixed(2)}`;
            }

            // Initialize customer search
            function initializeCustomerSearch() {
                const search = document.getElementById('customer-search');
                const select = document.getElementById('customer-select');
                const dropdown = document.getElementById('customer-dropdown');

                if (select.value) {
                    search.value = select.options[select.selectedIndex].dataset.name;
                }

                // Show all options when clicking on search input
                search.addEventListener('focus', () => {
                    showAllCustomerOptions(dropdown, select, search);
                });

                search.addEventListener('input', debounce(() => {
                    const term = search.value.toLowerCase();
                    dropdown.innerHTML = '';

                    // If empty, show all options
                    if (!term) {
                        showAllCustomerOptions(dropdown, select, search);
                        return;
                    }

                    const options = Array.from(select.options).filter(opt => opt.value && (
                        opt.dataset.name.toLowerCase().includes(term) ||
                        (opt.dataset.cedula || '').toLowerCase().includes(term) ||
                        opt.dataset.phone.toLowerCase().includes(term)
                    ));

                    dropdown.classList.toggle('hidden', !options.length);
                    options.forEach(opt => {
                        createCustomerOption(opt, dropdown, select, search);
                    });
                }, 300));
            }

            // Show all customer options
            function showAllCustomerOptions(dropdown, select, search) {
                dropdown.innerHTML = '';
                const allOptions = Array.from(select.options).filter(opt => opt.value);

                dropdown.classList.toggle('hidden', !allOptions.length);
                allOptions.forEach(opt => {
                    createCustomerOption(opt, dropdown, select, search);
                });
            }

            // Create customer option element
            function createCustomerOption(opt, dropdown, select, search) {
                const div = document.createElement('div');
                div.className =
                    'px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer text-gray-800 dark:text-gray-200';
                div.innerHTML = `
                    <div class="font-medium">${opt.dataset.name}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        ${opt.dataset.cedula ? `C.I.: ${opt.dataset.cedula} - ` : ''}Tel.: ${opt.dataset.phone}
                    </div>
                `;
                div.addEventListener('click', () => {
                    select.value = opt.value;
                    search.value = opt.dataset.name;
                    dropdown.classList.add('hidden');
                });
                dropdown.appendChild(div);
            }

            // Initialize product search
            function initializeProductSearch(productItem) {
                const search = productItem.querySelector('.product-search');
                const select = productItem.querySelector('.product-select');
                const dropdown = productItem.querySelector('.product-dropdown');

                if (select.value) {
                    search.value = select.options[select.selectedIndex].dataset.name;
                    const priceInput = productItem.querySelector('input[name*="unit_price"]');
                    // Solo establecer el precio por defecto si no hay un precio personalizado ya establecido
                    if (!priceInput.value || priceInput.value === '') {
                        priceInput.value = select.options[select.selectedIndex].dataset.price;
                    }
                    calculateSubtotal(productItem);
                }

                select.addEventListener('change', () => {
                    const priceInput = productItem.querySelector('input[name*="unit_price"]');
                    priceInput.value = select.options[select.selectedIndex].dataset.price;
                    search.value = select.options[select.selectedIndex].dataset.name;
                    calculateSubtotal(productItem);
                });

                // Show all options when clicking on search input
                search.addEventListener('focus', () => {
                    showAllProductOptions(dropdown, select, search, productItem);
                });

                search.addEventListener('input', debounce(() => {
                    const term = search.value.toLowerCase();
                    dropdown.innerHTML = '';

                    // If empty, show all options
                    if (!term) {
                        showAllProductOptions(dropdown, select, search, productItem);
                        return;
                    }

                    const options = Array.from(select.options).filter(opt => opt.value && (
                        opt.dataset.name.toLowerCase().includes(term) ||
                        (opt.dataset.type || '').toLowerCase().includes(term)
                    ));

                    dropdown.classList.toggle('hidden', !options.length);
                    options.forEach(opt => {
                        createProductOption(opt, dropdown, select, search, productItem);
                    });
                }, 300));
            }

            // Show all product options
            function showAllProductOptions(dropdown, select, search, productItem) {
                dropdown.innerHTML = '';
                const allOptions = Array.from(select.options).filter(opt => opt.value);

                dropdown.classList.toggle('hidden', !allOptions.length);
                allOptions.forEach(opt => {
                    createProductOption(opt, dropdown, select, search, productItem);
                });
            }

            // Create product option element
            function createProductOption(opt, dropdown, select, search, productItem) {
                const div = document.createElement('div');
                div.className =
                    'px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer text-gray-800 dark:text-gray-200';
                div.innerHTML = `
                    <div class="font-medium">${opt.dataset.name}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        ${opt.dataset.type ? `Tipo: ${opt.dataset.type} - ` : ''}Precio: $${parseFloat(opt.dataset.price).toFixed(2)}
                    </div>
                `;
                div.addEventListener('click', () => {
                    select.value = opt.value;
                    search.value = opt.dataset.name;
                    dropdown.classList.add('hidden');
                    const priceInput = productItem.querySelector('input[name*="unit_price"]');
                    priceInput.value = opt.dataset.price;
                    calculateSubtotal(productItem);
                });
                dropdown.appendChild(div);
            }

            // Event delegation for products
            productsContainer.addEventListener('input', e => {
                if (e.target.matches('input[name*="quantity"], input[name*="unit_price"]')) {
                    calculateSubtotal(e.target.closest('.product-item'));
                }
            });

            productsContainer.addEventListener('click', e => {
                if (e.target.closest('.remove-product')) {
                    const productItem = e.target.closest('.product-item');
                    productItem.remove();
                    calculateTotal();
                    if (!document.querySelectorAll('.product-item').length) addProduct();
                }
            });

            // Close dropdowns on outside click
            document.addEventListener('click', e => {
                if (!e.target.closest(
                        '#customer-search, #customer-dropdown, .product-search, .product-dropdown')) {
                    document.querySelectorAll('#customer-dropdown, .product-dropdown').forEach(d => d
                        .classList.add('hidden'));
                }
            });

            // Add product button
            document.getElementById('add-product').addEventListener('click', () => addProduct());

            // Initialize customer search
            initializeCustomerSearch();

            // Calculate days between dates
            function calculateDays() {
                const startDate = document.getElementById('paper_date').value;
                const endDate = document.getElementById('paper_valid_until').value;
                const daysInput = document.getElementById('paper_days');
                const daysCount = document.getElementById('days-count');

                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const diffTime = Math.abs(end - start);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    daysInput.value = diffDays;
                    daysCount.textContent = diffDays;
                } else {
                    daysInput.value = 7;
                    daysCount.textContent = 7;
                }
            }

            // Initialize date calculation
            function initializeDateCalculation() {
                const paperDate = document.getElementById('paper_date');
                const validUntilDate = document.getElementById('paper_valid_until');
                
                // Determinar si estamos editando o creando
                const isEditing = {{ isset($paper) ? 'true' : 'false' }};
                const originalPaperDate = isEditing ? '{{ isset($paper) ? $paper->paper_date : '' }}' : null;
                const today = '{{ now()->format('Y-m-d') }}';

                // Calculate initial days
                calculateDays();

                // Update days when paper date changes
                paperDate.addEventListener('change', () => {
                    // Para nuevas proformas, la fecha no puede ser anterior a hoy
                    // Para edición, la fecha no puede ser anterior a la fecha original
                    const minDate = isEditing ? originalPaperDate : today;
                    
                    if (paperDate.value < minDate) {
                        paperDate.value = minDate;
                    }
                    
                    // Update min date for valid until
                    validUntilDate.min = paperDate.value;
                    // If valid until is before paper date, reset it
                    if (validUntilDate.value < paperDate.value) {
                        const nextWeek = new Date(paperDate.value);
                        nextWeek.setDate(nextWeek.getDate() + 7);
                        validUntilDate.value = nextWeek.toISOString().split('T')[0];
                    }
                    calculateDays();
                });

                // Update days when valid until date changes
                validUntilDate.addEventListener('change', () => {
                    calculateDays();
                });
                
                // Establecer la fecha mínima inicial según el contexto
                if (!isEditing) {
                    // Para nuevas proformas, la fecha mínima es hoy
                    paperDate.min = today;
                } else {
                    // Para edición, la fecha mínima es la fecha original
                    paperDate.min = originalPaperDate;
                }
            }

            // Initialize date calculation
            initializeDateCalculation();

            // Indicadores de carga para los botones de submit
            const form = document.getElementById('papersForm');
            const draftBtn = document.getElementById('draftBtn');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                const isDraft = e.submitter?.name === 'save_draft';

                if (isDraft) {
                    draftBtn.disabled = true;
                    draftBtn.innerHTML = `
                        <span class="iconify h-5 w-5 animate-spin" data-icon="heroicons:arrow-path-20-solid"></span>
                        Guardando borrador...
                    `;
                } else {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <span class="iconify h-5 w-5 animate-spin" data-icon="heroicons:arrow-path-20-solid"></span>
                        Guardando...
                    `;
                }
            });
        });
    </script>
@endpush
