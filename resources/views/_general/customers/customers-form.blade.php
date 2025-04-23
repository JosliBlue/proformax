@extends('appsita')

@section('content')
    {{--
    @if (isset($customer))
        <h2
            class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
            Datos de {{ $customer->customer_name . ' ' . $customer->customer_lastname }}
        </h2>
    @else
        <h2
            class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
            Crear nuevo cliente
        </h2>
    @endif
 --}}

    <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}" method="POST"
        class="my-5" autocomplete="on" spellcheck="true">
        @csrf
        @if (isset($customer))
            @method('PUT')
        @endif

        {{-- Token de seguridad adicional --}}
        <input type="hidden" name="form_token" value="{{ Str::random(40) }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nombre --}}
            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Nombre *
                </label>

                <input type="text" name="customer_name" id="customer_name"
                    value="{{ old('customer_name', $customer->customer_name ?? '') }}" required
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                    autocomplete="given-name">

                @error('customer_name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Apellido --}}
            <div>
                <label for="customer_lastname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Apellido *
                </label>
                <input type="text" name="customer_lastname" id="customer_lastname"
                    value="{{ old('customer_lastname', $customer->customer_lastname ?? '') }}" required
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                    autocomplete="family-name">
                @error('customer_lastname')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Teléfono --}}
            <div>
                <label for="customer_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Teléfono *
                </label>
                <input type="tel" name="customer_phone" id="customer_phone"
                    value="{{ old('customer_phone', $customer->customer_phone ?? '') }}" required pattern="[0-9]*"
                    inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                    autocomplete="tel">
                @error('customer_phone')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="customer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Correo electrónico *
                </label>

                <input type="email" name="customer_email" id="customer_email"
                    value="{{ old('customer_email', $customer->customer_email ?? '') }}" required
                    @if (isset($customer) && !auth()->user()->isAdmin()) readonly @endif
                    class="w-full px-4 py-3 text-base border rounded-lg transition-all duration-200
                           @if (!isset($customer) || auth()->user()->isAdmin()) border-[var(--primary-color)] dark:border-[var(--secondary-color)]
                               bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200
                               focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)]
                           @else
                               border-gray-300 dark:border-gray-600
                               bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-300
                               cursor-not-allowed @endif">

                @error('customer_email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Botones --}}
        <div class="pt-4 flex justify-end gap-3">
            <button type="submit"
                class="flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:brightness-125 px-6 py-2.5 rounded-lg transition-all duration-200">
                {{ isset($customer) ? 'Actualizar cliente' : 'Guardar cliente' }}
            </button>
        </div>
    </form>
@endsection
