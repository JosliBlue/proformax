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
        <div class="mt-4 sm:mt-0 w-full sm:w-auto">
            <button data-modal-toggle="nuevoCliente"
                class="cursor-pointer w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Nuevo cliente
            </button>
        </div>
    </div>


    <x-partials.modal modal-id="nuevoCliente" title="Nuevo cliente">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            {{-- Nombre --}}
            <div>
                <label for="customer_name" class="block text-lg font-medium text-gray-800">Nombre</label>
                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"
                    class="mt-2 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 text-gray-700 transition duration-200">
                @error('customer_name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Apellido --}}
            <div>
                <label for="customer_lastname" class="block text-lg font-medium text-gray-800">Apellido</label>
                <input type="text" name="customer_lastname" id="customer_lastname" value="{{ old('customer_lastname') }}"
                    class="mt-2 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 text-gray-700 transition duration-200">
                @error('customer_lastname')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Teléfono --}}
            <div>
                <label for="customer_phone" class="block text-lg font-medium text-gray-800">Teléfono</label>
                <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}"
                    class="mt-2 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 text-gray-700 transition duration-200">
                @error('customer_phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="customer_email" class="block text-lg font-medium text-gray-800">Correo electrónico</label>
                <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}"
                    class="mt-2 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 text-gray-700 transition duration-200">
                @error('customer_email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón Guardar --}}
            <div class="pt-4 text-right">
                <button type="submit"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg shadow-md transform transition duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Guardar Cliente
                </button>
            </div>
        </form>

    </x-partials.modal>

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
