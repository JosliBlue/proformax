@extends('appsita')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-5">
        <!-- Buscador Mejorado -->
        <div class="w-full sm:w-auto">
            <form action="{{ route('customers') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">

                <div class="relative w-full sm:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="iconify h-6 w-6 text-gray-500" data-icon="heroicons:magnifying-glass"></span>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar clientes..."
                        class="w-full pl-12 pr-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                </div>

                <div class="flex gap-3 w-full sm:w-auto">
                    <button type="submit"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-4 py-2.5 rounded-lg w-full sm:w-auto transition-all duration-200">
                        Buscar
                    </button>

                    @if (request('search'))
                        <a href="{{ route('customers') }}"
                            class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--primary-color)] text-[var(--primary-text-color)] hover:bg-opacity-90 px-4 py-2.5 rounded-lg w-full sm:w-auto transition-all duration-200">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Botón Nuevo Cliente Mejorado -->
        <a href="{{ route('customers.create') }}"
            class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-5 py-2.5 rounded-lg w-full sm:w-auto transition-all duration-200">
            <span>Nuevo cliente</span>
        </a>
    </div>

    <!-- Tabla con Tamaño Aumentado -->
    <div class="overflow-x-auto rounded-lg md:border md:border-gray-200 dark:md:border-gray-700">
        <table class="min-w-full bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <!-- Cabecera Estilizada -->
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    @foreach ($columns as $column)
                        <th
                            class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('customers', [
                                    'sort' => $column['field'],
                                    'direction' => $sortField === $column['field'] && $sortDirection === 'asc' ? 'desc' : 'asc',
                                    'search' => request('search'),
                                ]) }}"
                                    class="hover:text-[var(--primary-color)] dark:hover:text-[var(--secondary-color)] transition-colors duration-150">
                                    {{ $column['name'] }}
                                </a>
                                @if ($sortField === $column['field'])
                                    <span class="text-[var(--primary-color)] dark:text-[var(--secondary-color)]">
                                        @if ($sortDirection === 'asc')
                                            <span class="iconify h-4 w-4" data-icon="heroicons:chevron-up-20-solid"></span>
                                        @else
                                            <span class="iconify h-4 w-4"
                                                data-icon="heroicons:chevron-down-20-solid"></span>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </th>
                    @endforeach
                    <th
                        class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                        Acciones
                    </th>
                </tr>
            </thead>

            <!-- Cuerpo de Tabla con Tamaño Aumentado -->
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($data as $customer)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                        <!-- Celda de Nombre Mejorada -->
                        <td class="px-4 py-3 whitespace-nowrap text-base text-gray-800 dark:text-gray-200">
                            <div class="flex items-center gap-3">
                                <span class="iconify h-5 w-5 text-gray-600 dark:text-gray-400"
                                    data-icon="heroicons:user-20-solid"></span>
                                <span>{{ $customer->getFullName() }}</span>
                            </div>
                        </td>

                        <!-- Celda de Teléfono -->
                        <td class="px-4 py-3 whitespace-nowrap text-base text-gray-800 dark:text-gray-200">
                            <div class="flex items-center gap-3">
                                <span class="iconify hidden md:block h-5 w-5 text-gray-600 dark:text-gray-400 "
                                    data-icon="heroicons:phone-20-solid"></span>
                                <span>{{ $customer->customer_phone }}</span>
                            </div>
                        </td>

                        <!-- Celda de Email -->
                        <td class="px-4 py-3 whitespace-nowrap text-base text-gray-800 dark:text-gray-200">
                            <div class="flex items-center gap-3">
                                <span class="iconify hidden md:block h-5 w-5 text-gray-600 dark:text-gray-400"
                                    data-icon="heroicons:envelope-20-solid"></span>
                                <span>{{ $customer->customer_email }}</span>
                            </div>
                        </td>

                        <!-- Estado con Badge Mejorado -->
                        @if (auth()->check() && auth()->user()->isAdmin())
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $customer->customer_status ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' }}">
                                    <span class="iconify h-4 w-4 mr-1.5"
                                        data-icon="{{ $customer->customer_status ? 'heroicons:check-circle-20-solid' : 'heroicons:x-circle-20-solid' }}"></span>
                                    {{ $customer->customer_status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                        @endif
                        <!-- Acciones con Tamaño Aumentado -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <!-- Botón Editar -->
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                    class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-200"
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
                                        class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200"
                                        title="{{ $customer->customer_status ? 'Desactivar' : 'Activar' }}">
                                        <span class="iconify w-5 h-5"
                                            data-icon="{{ $customer->customer_status ? 'mdi:trash-can' : 'tabler:trash-off' }}"></span>
                                    </button>
                                </form>

                                {{--
                                <!-- Botón Eliminar -->
                                @if (auth()->check() && auth()->user()->isAdmin())
                                    <form id="deleteForm-{{ $customer->id }}"
                                        action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $customer->id }}')"
                                            class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200"
                                            title="Eliminar">
                                            <span class="iconify w-5 h-5" data-icon="heroicons:trash-20-solid"></span>
                                        </button>
                                    </form>
                                @endif
                                 --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación Centrada -->
    <div class="flex justify-center">
        {{ $data->appends(request()->query())->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        // Alertas Modernas con Tamaño Aumentado
        function showAlert(options) {
            const defaults = {
                background: '#ffffff',
                color: 'var(--mi-oscuro)',
                customClass: {
                    popup: '!bg-white dark:!bg-[var(--mi-oscuro)] !rounded-lg !shadow-xl !max-w-md',
                    title: '!text-[var(--mi-oscuro)] dark:!text-white !font-semibold !text-lg',
                    htmlContainer: '!text-[var(--mi-oscuro)] dark:!text-gray-300 !text-base',
                    confirmButton: '!bg-[var(--primary-color)] hover:!bg-[var(--primary-color)]/90 dark:!bg-[var(--secondary-color)] dark:hover:!bg-[var(--secondary-color)]/90 !text-white !px-5 !py-2.5 !text-base !rounded-lg !transition-all !duration-200',
                    cancelButton: '!bg-gray-500 hover:!bg-gray-600 !text-white !px-5 !py-2.5 !text-base !rounded-lg !transition-all !duration-200'
                }
            };

            return Swal.fire({
                ...defaults,
                ...options
            });
        }

        /*
        function confirmDelete(customerId) {
            showAlert({
                title: '¿Eliminar cliente?',
                text: "¡Esta acción no se puede deshacer! Se perderán todos los datos asociados.",
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteForm-${customerId}`).submit();
                }
            });
        }
        */
        function confirmDeactivate(customerId) {
            showAlert({
                title: '¿Cambiar estado?',
                text: "¿Estás seguro de querer cambiar el estado de este cliente?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deactivateForm-${customerId}`).submit();
                }
            });
        }
    </script>
@endpush
