@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm">
        <a href="{{ route('home') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Gestión de Productos
        </h1>
    </div>

    <div class="flex flex-col gap-4 my-4">
        <!-- Barra superior con buscador y botón -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <!-- Buscador Mejorado -->
            <div class="w-full sm:w-auto">
                <form action="{{ route('products') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-96">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <span class="iconify h-5 w-5" data-icon="line-md:search-filled"></span>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar productos..."
                            class="w-full pl-12 pr-4 py-3 text-base rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md">
                    </div>

                    <div class="flex gap-3 w-full sm:w-auto">
                        <button type="submit"
                            class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--primary-color)] text-[var(--primary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                            Buscar
                        </button>

                        @if (request('search'))
                            <a href="{{ route('products') }}"
                                class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                                <span class="iconify h-5 w-5" data-icon="iconamoon:trash-light"></span>
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Botón Nuevo Producto -->
            <div class="w-full sm:w-auto">
                <a href="{{ route('products.create') }}"
                    class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <span class="iconify h-5 w-5" data-icon="fluent:add-32-filled"></span>
                    Nuevo producto
                </a>
            </div>
        </div>

        <!-- Filtros de ordenamiento con efecto hover -->
        <div class="flex flex-wrap items-center gap-2 overflow-x-auto py-1">
            <span class="text-sm font-medium text-gray-600 dark:text-gray-300 whitespace-nowrap">Ordenar por:</span>

            @foreach ($columns as $column)
                <a href="{{ route('products', [
                    'sort' => $column['field'],
                    'direction' => $sortField === $column['field'] && $sortDirection === 'asc' ? 'desc' : 'asc',
                    'search' => request('search'),
                ]) }}"
                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium transition-colors duration-150 whitespace-nowrap border
                    {{ $sortField === $column['field']
                        ? 'border-[var(--primary-color)] bg-[var(--primary-color)] text-[var(--primary-text-color)] shadow-sm'
                        : 'text-gray-900 dark:text-gray-300 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    {{ $column['name'] }}
                    @if ($sortField === $column['field'])
                        <span class="ml-1">
                            @if ($sortDirection === 'asc')
                                <span class="iconify h-3 w-3 text-[var(--primary-text-color)] font-extrabold"
                                    data-icon="oui:arrow-up"></span>
                            @else
                                <span class="iconify h-3 w-3 text-[var(--primary-text-color)] font-extrabold"
                                    data-icon="oui:arrow-down"></span>
                            @endif
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
    <div class="flex md:hidden justify-center mb-4">
        {{ $data->appends(request()->query())->links() }}
    </div>

    @if ($data->count() > 0)
        <!-- Contenedor grid responsive para productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
            @foreach ($data as $product)
                <details
                    class="relative bg-white dark:bg-gray-800 group rounded-lg transform transition-transform duration-200 hover:-translate-y-1 h-full product-card open:bg-blue-50 dark:open:bg-gray-700 open:z-20"
                    id="product-{{ $product->id }}">

                    <summary class="list-none p-4 cursor-pointer h-full">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <span
                                    class="iconify h-5 w-5 {{ $product->product_status ? 'text-green-500' : 'text-red-500' }}"
                                    data-icon="heroicons:cube-20-solid"></span>
                                {{ $product->product_name }}
                            </h3>
                            <span class="iconify h-6 w-6 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                                data-icon="heroicons:chevron-down-20-solid" id="arrow-{{ $product->id }}"></span>
                        </div>

                        <div class="mt-auto space-y-1.5 text-sm">
                            <div class="flex items-center gap-2 text-gray-700 dark:text-gray-400">
                                <span class="iconify h-3.5 w-3.5" data-icon="heroicons:currency-dollar-20-solid"></span>
                                <span>${{ number_format($product->product_price, 2) }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-700 dark:text-gray-400">
                                <span class="iconify h-3.5 w-3.5" data-icon="heroicons:tag-20-solid"></span>
                                <span>{{ ucfirst($product->product_type->value) }}</span>
                            </div>
                        </div>
                    </summary>

                    <div class="bg-blue-50 dark:bg-gray-700 absolute left-0 right-0 z-10 mt-[-8px] rounded-b-lg shadow-xl">
                        <div class="w-[90%] border-t border-gray-300 m-auto mt-1 dark:border-gray-600"></div>
                        <div class="py-3 px-4">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-200 flex items-center justify-center"
                                    title="Editar">
                                    <span class="iconify w-5 h-5" data-icon="heroicons:pencil-square-20-solid"></span>
                                </a>

                                <form id="deactivateForm-{{ $product->id }}"
                                    action="{{ route('products.soft_destroy', $product->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" onclick="confirmDeactivate('{{ $product->id }}')"
                                        class="p-2 {{ $product->product_status ? 'bg-red-600' : 'bg-green-600' }} text-white rounded-lg hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200 flex items-center justify-center"
                                        title="{{ $product->product_status ? 'Desactivar' : 'Activar' }}">
                                        <span class="iconify w-5 h-5"
                                            data-icon="{{ $product->product_status ? 'mdi:eye-off' : 'mdi:eye' }}"></span>
                                    </button>
                                </form>

                                @if (auth()->user()->isGerente())
                                    <form id="deleteForm-{{ $product->id }}"
                                        action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $product->id }}')"
                                            class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200 flex items-center justify-center"
                                            title="Eliminar">
                                            <span class="iconify w-5 h-5" data-icon="mdi:trash-can"></span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </details>
            @endforeach
        </div>
    @else
        <!-- Vista de estado vacío para productos -->
        <div class="flex flex-col items-center justify-center py-16 px-4">
            <div class="text-center max-w-md mx-auto">
                <!-- Icono animado -->
                <div
                    class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    <span class="iconify h-12 w-12 text-gray-400 dark:text-gray-500"
                        data-icon="heroicons:cube-transparent"></span>
                </div>

                <!-- Mensaje principal -->
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                    @if (request('search'))
                        No se encontraron productos
                    @else
                        No hay productos disponibles
                    @endif
                </h3>

                <!-- Mensaje secundario -->
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    @if (request('search'))
                        No hay productos que coincidan con "<strong>{{ request('search') }}</strong>".
                        Intenta con otros términos de búsqueda.
                    @else
                        Aún no se han agregado productos al sistema.
                        Comienza creando tu primer producto.
                    @endif
                </p>
            </div>
        </div>
    @endif

    <div class="flex justify-center mt-4">
        {{ $data->appends(request()->query())->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const allDetails = document.querySelectorAll('details.product-card');
            allDetails.forEach(detail => {
                detail.addEventListener('toggle', (e) => {
                    const productId = detail.id.split('-')[1];
                    const arrow = document.getElementById(`arrow-${productId}`);

                    if (detail.open) {
                        arrow.style.transform = 'rotate(180deg)';
                        allDetails.forEach(otherDetail => {
                            if (otherDetail !== detail && otherDetail.open) {
                                otherDetail.open = false;
                                const otherProductId = otherDetail.id.split('-')[1];
                                const otherArrow = document.getElementById(
                                    `arrow-${otherProductId}`);
                                otherArrow.style.transform = 'rotate(0deg)';
                            }
                        });
                    } else {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                });
            });
        });

        function confirmDeactivate(productId) {
            const card = document.querySelector(`#product-${productId}`);
            const isActive = card.querySelector('.text-green-500') !== null;

            confirmAction({
                title: isActive ? '¿Desactivar producto?' : '¿Activar producto?',
                text: isActive ? "El producto no estará disponible para nuevas proformas" :
                    "El producto volverá a estar disponible para proformas",
                icon: 'question',
                footer: '<span class="text-sm text-gray-500 dark:text-gray-400">Puedes cambiar este estado en cualquier momento</span>',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deactivateForm-${productId}`).submit();
                }
            });
        }

        function confirmDelete(productId) {
            confirmAction({
                title: '¿Estás seguro de eliminar este producto?',
                html: "<div class='text-sm text-gray-600 dark:text-gray-400'>Esta acción es irreversible y eliminará:<br>- Todos los datos del producto<br>- Todas sus relaciones con proformas</div>",
                icon: 'warning',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#ef4444',
            }).then((firstResult) => {
                if (firstResult.isConfirmed) {
                    confirmAction({
                        title: 'Confirmación final',
                        html: `<div class='text-sm text-red-600 dark:text-red-400 mb-3'>Para confirmar, escribe <strong>ELIMINAR</strong> en el cuadro:</div><input id="confirm-delete-input" type="text" class="swal2-input dark:text-white" placeholder="Escribe ELIMINAR aqui" required>`,
                        icon: 'warning',
                        confirmButtonText: 'Confirmar eliminación',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#dc2626',
                        focusCancel: true,
                        preConfirm: () => {
                            const inputValue = document.getElementById('confirm-delete-input').value;
                            if (inputValue.toUpperCase() !== 'ELIMINAR') {
                                Swal.showValidationMessage('Debes escribir exactamente "ELIMINAR"');
                            }
                            return inputValue.toUpperCase() === 'ELIMINAR';
                        }
                    }).then((secondResult) => {
                        if (secondResult.isConfirmed) {
                            document.getElementById(`deleteForm-${productId}`).submit();
                        }
                    });
                }
            });
        }
    </script>
@endpush
