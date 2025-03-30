@extends('layouts.app')

@section('content')
    <h1>Clientes</h1>
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    @foreach ($columns as $column)
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $column }}
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
                        {{-- AQUI LE PUEDES PONER PARA LAS ACCIONES --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mostrar la paginación -->
    <div class="mt-4">
        {{ $data->links() }}
    </div>
@endsection
