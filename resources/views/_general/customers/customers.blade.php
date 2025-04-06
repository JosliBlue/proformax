@extends('appsita')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">

        {{-- Buscador --}}
        <div class="w-full sm:w-auto">
            <form action="{{ route('customers') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2">
                {{-- Input de búsqueda --}}
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar clientes..."
                    class="w-full sm:w-96 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                {{-- Contenedor de botones --}}
                <div class="flex gap-2 w-full sm:w-auto mt-4 sm:mt-0">
                    {{-- Botón Buscar --}}
                    <button type="submit"
                        class="cursor-pointer px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                        Buscar
                    </button>

                    {{-- Botón Limpiar (solo visible con búsqueda) --}}
                    @if (request('search'))
                        <a href="{{ route('customers') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none w-full sm:w-auto text-center">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Botón Nuevo Cliente --}}
        <a href="{{ route('customers.create') }}"
            class="text-center cursor-pointer w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Nuevo cliente
        </a>
    </div>

    {{-- TABLA DE CLIENTES --}}
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    @foreach ($columns as $column)
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <a href="{{ route('customers', [
                                    'sort' => $column['field'],
                                    'direction' => $sortField === $column['field'] && $sortDirection === 'asc' ? 'desc' : 'asc',
                                    'search' => request('search'),
                                ]) }}"
                                    class="hover:text-gray-700">
                                    {{ $column['name'] }}
                                </a>
                                @if ($sortField === $column['field'])
                                    <span class="ml-1">
                                        @if ($sortDirection === 'asc')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </th>
                    @endforeach
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach ($data as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 flex items-center aling-center">
                            <span class="iconify w-7 h-5 text-gra-500" data-icon="ic:sharp-person"></span>
                            <span>{{ $customer->getFullName() }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $customer->customer_phone }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $customer->customer_email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <span
                                class="{{ $customer->customer_status ? 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800' : 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800' }}">
                                {{ $customer->customer_status ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap text-sm text-gray-700">
                            <div class="flex space-x-2">
                                <!-- Botón Editar (Amarillo) -->
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                    class="cursor-pointer p-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                    title="Editar">
                                    <span class="iconify w-6 h-6" data-icon="flowbite:edit-outline"></span>
                                </a>

                                <!-- Botón Desactivar (Naranja) -->
                                <form id="deactivateForm-{{ $customer->id }}"
                                    action="{{ route('customers.soft_destroy', $customer->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" onclick="confirmDeactivate('{{ $customer->id }}')"
                                        class="cursor-pointer p-2 bg-orange-500 text-white rounded hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                        title="{{ $customer->customer_status ? 'Desactivar' : 'Activar' }}">
                                        <span class="iconify w-6 h-6"
                                            data-icon="{{ $customer->customer_status ? 'mdi:account-cancel' : 'mdi:account-check' }}"></span>
                                    </button>
                                </form>

                                <!-- Botón Eliminar (Rojo) -->
                                <form id="deleteForm-{{ $customer->id }}"
                                    action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $customer->id }}')"
                                        class="cursor-pointer p-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        title="Eliminar">
                                        <span class="iconify w-6 h-6" data-icon="fluent:delete-32-regular"></span>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Mostrar la paginación -->
    <div class="mt-4">
        {{ $data->appends(request()->query())->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(customerId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteForm-${customerId}`).submit();
                }
            });
        }

        function confirmDeactivate(customerId) {
            Swal.fire({
                title: '¿Confirmar acción?',
                text: "¿Deseas cambiar el estado de este cliente?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, cambiar estado',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deactivateForm-${customerId}`).submit();
                }
            });
        }
    </script>
@endpush
