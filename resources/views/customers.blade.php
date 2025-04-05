@extends('layouts.app')

@push('styles')
@endpush
@section('content')
    <h1>Clientes</h1>
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">

        <div class="w-full sm:w-auto">
            @livewire('partials.search-box', [
                'route' => 'customers',
                'placeholder' => 'Buscar clientes...',
                'additionalParams' => ['sort' => request('sort'), 'direction' => request('direction')],
            ])
        </div>

        @component('components.partials.boton', [
            'href' => '#modal',
        ])
            Agregar cliente
        @endcomponent


        <!-- Componente Modal -->
        @component('components.partials.modal')
            @slot('title', 'Agregar nuevo cliente')

            @slot('content')
                <!-- Aquí va el contenido específico del formulario -->
                @livewire('crud.formulario-clientes')
            @endslot
        @endcomponent
    </div>

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
