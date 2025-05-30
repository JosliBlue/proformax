@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso - Versión con navegación JS -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm">
        <a href="{{ route('home') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Gestión de Vendedores
        </h1>
    </div>

    <div class="flex flex-col gap-4 my-4">
        <!-- Barra superior con buscador y botón -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <!-- Buscador Mejorado -->
            <div class="w-full sm:w-auto">
                <form action="{{ route('sellers') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-96">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <span class="iconify h-5 w-5 " data-icon="line-md:search-filled"></span>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar vendedores..."
                            class="w-full pl-12 pr-4 py-3 text-base rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md">
                    </div>

                    <div class="flex gap-3 w-full sm:w-auto">
                        <button type="submit"
                            class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--primary-color)] text-[var(--primary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                            Buscar
                        </button>

                        @if (request('search'))
                            <a href="{{ route('sellers') }}"
                                class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                                <span class="iconify h-5 w-5 " data-icon="iconamoon:trash-light"></span>
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Botón Nuevo Vendedor -->
            <div class="w-full sm:w-auto">
                <a href="{{ route('sellers.create') }}"
                    class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <span class="iconify h-5 w-5 " data-icon="fluent:add-32-filled"></span>
                    Nuevo vendedor
                </a>
            </div>
        </div>

        <!-- Filtros de ordenamiento con efecto hover -->
        <div class="flex flex-wrap items-center gap-2 overflow-x-auto py-1">
            <span class="text-sm font-medium text-gray-600 dark:text-gray-300 whitespace-nowrap">Ordenar por:</span>

            @foreach ($columns as $column)
                <a href="{{ route('sellers', [
                    'sort' => $column['field'],
                    'direction' => $sortField === $column['field'] && $sortDirection === 'asc' ? 'desc' : 'asc',
                    'search' => request('search'),
                ]) }}"
                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-200 whitespace-nowrap border transform hover:-translate-y-0.5
                {{ $sortField === $column['field']
                    ? 'border-transparent bg-[var(--primary-color)] text-[var(--primary-text-color)] shadow-sm hover:shadow-md'
                    : 'text-gray-900 dark:text-gray-300 border-[var(--primary-color)] hover:shadow-md bg-white dark:bg-gray-900' }}">
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
    <!-- Contenedor grid responsive para vendedores -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
        @foreach ($data as $seller)
            <details
                class="relative bg-white dark:bg-gray-800 group rounded-lg transform transition-transform duration-200 hover:-translate-y-1 h-full seller-card open:bg-blue-50 dark:open:bg-gray-700 open:z-20"
                id="seller-{{ $seller->id }}">

                <summary class="list-none p-4 cursor-pointer h-full">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                            <!-- Icono de usuario con color de estado -->
                            <span class="iconify h-5 w-5 {{ $seller->user_status ? 'text-green-500' : 'text-red-500' }}"
                                data-icon="heroicons:user-20-solid"></span>
                            {{ $seller->user_name }}
                        </h3>
                        <!-- Flecha indicadora de estado -->
                        <span class="iconify h-6 w-6 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                            data-icon="heroicons:chevron-down-20-solid" id="arrow-{{ $seller->id }}"></span>
                    </div>

                    <!-- Información básica -->
                    <div class="mt-auto space-y-1.5 text-sm">
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-400">
                            <span class="iconify h-3.5 w-3.5" data-icon="heroicons:envelope-20-solid"></span>
                            <span class="truncate">{{ strtolower($seller->user_email) }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-400">
                            <span class="iconify h-3.5 w-3.5" data-icon="heroicons:shield-check-20-solid"></span>
                            <span>
                                @switch(strtolower($seller->user_rol->value))
                                    @case(App\Enums\UserRole::ADMIN->value)
                                        Administrador
                                    @break

                                    @case(App\Enums\UserRole::USER->value)
                                        Vendedor
                                    @break
                                @endswitch
                            </span>
                        </div>
                    </div>
                </summary>

                <!-- Panel flotante con diseño integrado -->
                <div class="bg-blue-50 dark:bg-gray-700 absolute left-0 right-0 z-10 mt-[-8px] rounded-b-lg shadow-xl">
                    <div class="w-[90%] border-t border-gray-300 m-auto mt-1 dark:border-gray-600"></div>
                    <div class="py-3 px-4 space-y-3 text-gray-700 dark:text-gray-400">


                        <!-- Botones de acción -->
                        <div class="flex justify-center gap-3 p-1">
                            <!-- Botón Editar -->
                            <a href="{{ route('sellers.edit', $seller->id) }}"
                                class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-200 flex items-center justify-center"
                                title="Editar">
                                <span class="iconify w-5 h-5" data-icon="heroicons:pencil-square-20-solid"></span>
                            </a>

                            <!-- Botón Desactivar/Activar -->
                            <form id="deactivateForm-{{ $seller->id }}"
                                action="{{ route('sellers.soft_destroy', $seller->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="button" onclick="confirmDeactivate('{{ $seller->id }}')"
                                    class="p-2 {{ $seller->user_status ? 'bg-red-600' : 'bg-green-600' }} text-white rounded-lg hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200 flex items-center justify-center"
                                    title="{{ $seller->user_status ? 'Desactivar' : 'Activar' }}">
                                    <span class="iconify w-5 h-5"
                                        data-icon="{{ $seller->user_status ? 'mdi:eye-off' : 'mdi:eye' }}"></span>
                                </button>
                            </form>

                            <!-- Botón Eliminar -->
                            <form id="deleteForm-{{ $seller->id }}" action="{{ route('sellers.destroy', $seller->id) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $seller->id }}')"
                                    class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200 flex items-center justify-center"
                                    title="Eliminar">
                                    <span class="iconify w-5 h-5" data-icon="mdi:trash-can"></span>
                                </button>
                            </form>
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
            const allDetails = document.querySelectorAll('details.seller-card');
            allDetails.forEach(detail => {
                detail.addEventListener('toggle', (e) => {
                    const sellerId = detail.id.split('-')[1];
                    const arrow = document.getElementById(`arrow-${sellerId}`);

                    if (detail.open) {
                        arrow.style.transform = 'rotate(180deg)';
                        allDetails.forEach(otherDetail => {
                            if (otherDetail !== detail && otherDetail.open) {
                                otherDetail.open = false;
                                const otherSellerId = otherDetail.id.split('-')[1];
                                const otherArrow = document.getElementById(
                                    `arrow-${otherSellerId}`);
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
        function confirmDeactivate(sellerId) {
            const card = document.querySelector(`#seller-${sellerId}`);
            const isActive = card.querySelector('.text-green-500') !== null;

            confirmAction({
                title: isActive ? '¿Desactivar vendedor?' : '¿Activar vendedor?',
                text: isActive ?
                    "El vendedor no podrá acceder al sistema" : "El vendedor volverá a tener acceso al sistema",
                icon: 'question',
                footer: '<span class="text-sm text-gray-500 dark:text-gray-400">Puedes cambiar este estado en cualquier momento</span>',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deactivateForm-${sellerId}`).submit();
                }
            });
        }

        function confirmDelete(sellerId) {
            // Primera confirmación
            confirmAction({
                title: '¿Estás seguro de eliminar este vendedor?',
                html: "<div class='text-sm text-gray-600 dark:text-gray-400'>Esta acción es irreversible y eliminará:<br>- Todos los datos del vendedor<br>- Su acceso al sistema</div>",
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
                            document.getElementById(`deleteForm-${sellerId}`).submit();
                        }
                    });
                }
            });
        }
    </script>
@endpush
