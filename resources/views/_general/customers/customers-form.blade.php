@extends('appsita')

@section('content')
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm mb-6">
        <a href="{{ route('customers') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ isset($customer) ? 'Editar Cliente' : 'Nuevo Cliente' }}
        </h1>
    </div>

    <div class="max-w-md mx-auto">
        <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}"
            method="POST" class="space-y-4" autocomplete="on" spellcheck="true" id="customersForm">
            @csrf
            @if (isset($customer))
                @method('PUT')
            @endif

            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Nombre
                </label>
                <input type="text" name="customer_name" id="customer_name"
                    value="{{ old('customer_name', $customer->customer_name ?? '') }}" required
                    placeholder="Ej: Juan Carlos"
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md"
                    autocomplete="given-name">
                @error('customer_name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="customer_lastname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Apellido
                </label>
                <input type="text" name="customer_lastname" id="customer_lastname"
                    value="{{ old('customer_lastname', $customer->customer_lastname ?? '') }}" required
                    placeholder="Ej: Pérez González"
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md"
                    autocomplete="family-name">
                @error('customer_lastname')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="customer_cedula" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Cédula/DNI (opcional)
                </label>
                <input type="text" name="customer_cedula" id="customer_cedula" pattern="[0-9]*" inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    value="{{ old('customer_cedula', $customer->customer_cedula ?? '') }}" placeholder="Ej: 1805209095"
                    minlength="10" maxlength="10"
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md"
                    autocomplete="off">
                @error('customer_cedula')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="customer_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Teléfono
                </label>
                <input type="tel" name="customer_phone" id="customer_phone"
                    value="{{ old('customer_phone', $customer->customer_phone ?? '') }}" required pattern="[0-9]*"
                    inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    placeholder="Ej: 1234567890" maxlength="10"
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md"
                    autocomplete="tel">
                @error('customer_phone')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="customer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Correo electrónico (opcional)
                </label>
                <input type="email" name="customer_email" id="customer_email"
                    value="{{ old('customer_email', $customer->customer_email ?? '') }}"
                    placeholder="Ej: juan.perez@email.com" @if (isset($customer) && !auth()->user()->isGerente()) readonly @endif
                    class="w-full px-4 py-3 text-base rounded-lg shadow-sm hover:shadow-md transition-all duration-200
                        {{ !isset($customer) || auth()->user()->isGerente()
                            ? 'border-[var(--primary-color)] dark:border-[var(--secondary-color)] bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)]'
                            : 'border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-400 cursor-not-allowed' }}">
                @error('customer_email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex justify-center gap-3">
                <button type="submit" id="customersBtn"
                    class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:transform-none">
                    <span class="iconify h-5 w-5" data-icon="fluent:save-20-filled"></span>
                    {{ isset($customer) ? 'Actualizar cliente' : 'Guardar cliente' }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('customersForm');
            const customersBtn = document.getElementById('customersBtn');

            form.addEventListener('submit', function() {
                customersBtn.disabled = true;
                const isUpdate = {{ isset($customer) ? 'true' : 'false' }};
                customersBtn.innerHTML = `
                    <span class="iconify h-5 w-5 animate-spin" data-icon="heroicons:arrow-path-20-solid"></span>
                    ${isUpdate ? 'Actualizando...' : 'Guardando...'}
                `;
            });
        });
    </script>
@endpush
