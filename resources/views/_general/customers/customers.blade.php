@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso - Versión con navegación JS -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm">
        <a href="{{ route('home') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Gestión de Clientes
        </h1>
    </div>

    <div class="flex flex-col gap-4 my-4">
        <!-- Barra superior con buscador y botón -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <!-- Buscador Mejorado -->
            <div class="w-full sm:w-auto">
                <form action="{{ route('customers') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-96">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <span class="iconify h-5 w-5 " data-icon="line-md:search-filled"></span>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar clientes..."
                            class="w-full pl-12 pr-4 py-3 text-base rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md">
                    </div>

                    <div class="flex gap-3 w-full sm:w-auto">
                        <button type="submit"
                            class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--primary-color)] text-[var(--primary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                            Buscar
                        </button>

                        @if (request('search'))
                            <a href="{{ route('customers') }}"
                                class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                                <span class="iconify h-5 w-5 " data-icon="iconamoon:trash-light"></span>
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Botón Nuevo Cliente -->
            <div class="w-full sm:w-auto">
                <a href="{{ route('customers.create') }}"
                    class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <span class="iconify h-5 w-5 " data-icon="fluent:add-32-filled"></span>
                    Nuevo cliente
                </a>
            </div>
        </div>

        <!-- Filtros de ordenamiento -->
        <div class="flex flex-wrap items-center gap-2 overflow-x-auto py-1">
            <span class="text-sm font-medium text-gray-600 dark:text-gray-300 whitespace-nowrap">Ordenar por:</span>

            @foreach ($columns as $column)
                <a href="{{ route('customers', [
                    'sort' => $column['field'],
                    'direction' => $sortField === $column['field'] && $sortDirection === 'asc' ? 'desc' : 'asc',
                    'search' => request('search'),
                ]) }}"
                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium transition-colors duration-150 whitespace-nowrap border
                    {{ $sortField === $column['field']
                        ? 'border-[var(--primary-color)] bg-[var(--primary-color)] text-[var(--primary-text-color)] shadow-sm'
                        : 'text-gray-900 dark:text-gray-300 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800'}}">
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
    <!-- Contenedor grid responsive para clientes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
        @foreach ($data as $customer)
            <details
                class="relative bg-white dark:bg-gray-800 group rounded-lg transform transition-transform duration-200 hover:-translate-y-1 h-full customer-card open:bg-blue-50 dark:open:bg-gray-700 open:z-20"
                id="customer-{{ $customer->id }}">

                <summary class="list-none p-4 cursor-pointer h-full">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                            <!-- Icono de usuario con color de estado -->
                            <span
                                class="iconify h-5 w-5 {{ $customer->customer_status ? 'text-green-500' : 'text-red-500' }}"
                                data-icon="heroicons:user-20-solid"></span>
                            {{ $customer->getFullName() }}
                        </h3>
                        <!-- Flecha indicadora de estado -->
                        <span class="iconify h-6 w-6 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                            data-icon="heroicons:chevron-down-20-solid" id="arrow-{{ $customer->id }}"></span>
                    </div>

                    <!-- Información de contacto -->
                    <div class="mt-auto space-y-1.5 text-sm">
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-400">
                            <span class="iconify h-3.5 w-3.5" data-icon="heroicons:phone-20-solid"></span>
                            <span>{{ $customer->customer_phone }}</span>
                        </div>

                    </div>

                </summary>

                <!-- Panel flotante con diseño integrado -->
                <div class="bg-blue-50 dark:bg-gray-700 absolute left-0 right-0 z-10 mt-[-8px] rounded-b-lg shadow-xl">
                    <div class="w-[90%] border-t border-gray-300 m-auto mt-1 dark:border-gray-600"></div>
                    <div class="py-3 px-4 space-y-3 text-gray-700 dark:text-gray-400">
                        <div class="mt-auto space-y-1.5 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="iconify h-3.5 w-3.5" data-icon="heroicons:envelope-20-solid"></span>
                                <span class="truncate">{{ strtolower($customer->customer_email) }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="iconify h-3.5 w-3.5" data-icon="heroicons:calendar-20-solid"></span>
                                <span>Registrado el: {{ $customer->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="border-t border-gray-300 dark:border-gray-600"></div>
                        <!-- Botones de acción -->
                        <div class="flex justify-center gap-3 p-1">
                            <!-- Botón Editar -->
                            <a href="{{ route('customers.edit', $customer->id) }}"
                                class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-200 flex items-center justify-center"
                                title="Editar">
                                <span class="iconify w-5 h-5" data-icon="heroicons:pencil-square-20-solid"></span>
                            </a>

                            <!-- Botón Desactivar/Activar -->
                            <form id="deactivateForm-{{ $customer->id }}"
                                action="{{ route('customers.soft_destroy', $customer->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="button" onclick="confirmDeactivate('{{ $customer->id }}')"
                                    class="p-2 {{ $customer->customer_status ? 'bg-red-600' : 'bg-green-600' }} text-white rounded-lg hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200 flex items-center justify-center"
                                    title="{{ $customer->customer_status ? 'Desactivar' : 'Activar' }}">
                                    <span class="iconify w-5 h-5"
                                        data-icon="{{ $customer->customer_status ? 'mdi:eye-off' : 'mdi:eye' }}"></span>
                                </button>
                            </form>

                            @if (auth()->user()->isGerente())
                                <!-- Botón Eliminar (solo gerente) -->
                                <form id="deleteForm-{{ $customer->id }}"
                                    action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $customer->id }}')"
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
    <div class="flex justify-center mt-4">
        {{ $data->appends(request()->query())->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        // Manejar las cards
        document.addEventListener('DOMContentLoaded', () => {
            const allDetails = document.querySelectorAll('details.customer-card');
            allDetails.forEach(detail => {
                detail.addEventListener('toggle', (e) => {
                    const customerId = detail.id.split('-')[1];
                    const arrow = document.getElementById(`arrow-${customerId}`);

                    if (detail.open) {
                        arrow.style.transform = 'rotate(180deg)';
                        allDetails.forEach(otherDetail => {
                            if (otherDetail !== detail && otherDetail.open) {
                                otherDetail.open = false;
                                const otherCustomerId = otherDetail.id.split('-')[1];
                                const otherArrow = document.getElementById(
                                    `arrow-${otherCustomerId}`);
                                otherArrow.style.transform = 'rotate(0deg)';
                            }
                        });
                    } else {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                });
            });
        });

        // Funciones de confirmación
        function confirmDeactivate(customerId) {
            const card = document.querySelector(`#customer-${customerId}`);
            const isActive = card.querySelector('.text-green-500') !== null;

            confirmAction({
                title: isActive ? '¿Desactivar cliente?' : '¿Activar cliente?',
                text: isActive ?
                    "El cliente no aparecerá en las opciones de nuevas proformas" :
                    "El cliente volverá a estar disponible para nuevas proformas",
                icon: 'question',
                footer: '<span class="text-sm text-gray-500 dark:text-gray-400">Puedes cambiar este estado en cualquier momento</span>',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deactivateForm-${customerId}`).submit();
                }
            });
        }

        function confirmDelete(customerId) {
            confirmAction({
                title: '¿Eliminar cliente permanentemente?',
                html: "<div class='text-sm text-gray-600 dark:text-gray-400'>Esta acción es irreversible y eliminará:<br>- Todos los datos del cliente<br>- Todas sus proformas asociadas</div>",
                icon: 'warning',
                confirmButtonText: 'Confirmar eliminación',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#ef4444',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteForm-${customerId}`).submit();
                }
            });
        }

        function confirmDelete(customerId) {
            // Primera confirmación
            confirmAction({
                title: '¿Estás seguro de eliminar este cliente?',
                html: "<div class='text-sm text-gray-600 dark:text-gray-400'>Esta acción es irreversible y eliminará:<br>- Todos los datos del cliente<br>- Todas sus proformas asociadas</div>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#ef4444',
            }).then((firstResult) => {
                if (firstResult.isConfirmed) {
                    // Segunda confirmación con input
                    confirmAction({
                        title: 'Confirmación final',
                        html: `
                        <div class='text-sm text-red-600 dark:text-red-400 mb-3'>
                        Para confirmar, escribe <strong>ELIMINAR</strong> en el cuadro:
                        </div>
                        <input id="confirm-delete-input" type="text" class="swal2-input dark:text-white" placeholder="Escribe ELIMINAR aqui" required>`,
                        icon: 'warning',
                        showCancelButton: true,
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
                            document.getElementById(`deleteForm-${customerId}`).submit();
                        }
                    });
                }
            });
        }
    </script>
@endpush
