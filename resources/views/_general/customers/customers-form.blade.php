@extends('appsita')

@section('content')
    <div class="md:p-6 bg-mi-blanco md:rounded-xl md:shadow-md">
        @if (isset($customer))
            <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Datos de {{ $customer->customer_name ." ". $customer->customer_lastname}}</h2>
        @else
            <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Crear nuevo cliente</h2>
        @endif

        <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}"
            method="POST" class="space-y-6" autocomplete="on" spellcheck="true">
            @csrf
            @if (isset($customer))
                @method('PUT')
            @endif

            {{-- Token de seguridad adicional --}}
            <input type="hidden" name="form_token" value="{{ Str::random(40) }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre --}}
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                    <input type="text" name="customer_name" id="customer_name"
                        value="{{ old('customer_name', $customer->customer_name ?? '') }}" required
                        class="w-full px-4 py-2 border border-primary-color mdsita:border-secondary-color rounded-lg bg-white text-mi-oscuro focus:outline-none focus:ring-2 ring-secondary-color mdsita:ring-primary-color focus:ring-primary-color mdsita:focus:ring-secondary-color"
                        autocomplete="given-name">
                    @error('customer_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Apellido --}}
                <div>
                    <label for="customer_lastname" class="block text-sm font-medium text-gray-700 mb-1">Apellido *</label>
                    <input type="text" name="customer_lastname" id="customer_lastname"
                        value="{{ old('customer_lastname', $customer->customer_lastname ?? '') }}" required
                        class="w-full px-4 py-2 border border-primary-color mdsita:border-secondary-color rounded-lg bg-white text-mi-oscuro focus:outline-none focus:ring-2 ring-secondary-color mdsita:ring-primary-color focus:ring-primary-color mdsita:focus:ring-secondary-color"
                        autocomplete="family-name">
                    @error('customer_lastname')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div>
                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                    <input type="tel" name="customer_phone" id="customer_phone"
                        value="{{ old('customer_phone', $customer->customer_phone ?? '') }}" required
                        class="w-full px-4 py-2 border border-primary-color mdsita:border-secondary-color rounded-lg bg-white text-mi-oscuro focus:outline-none focus:ring-2 ring-secondary-color mdsita:ring-primary-color focus:ring-primary-color mdsita:focus:ring-secondary-color"
                        autocomplete="tel">
                    @error('customer_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
                    <input type="email" name="customer_email" id="customer_email"
                        value="{{ old('customer_email', $customer->customer_email ?? '') }}" required
                        class="w-full px-4 py-2 border border-primary-color mdsita:border-secondary-color rounded-lg bg-white text-mi-oscuro focus:outline-none focus:ring-2 ring-secondary-color mdsita:ring-primary-color focus:ring-primary-color mdsita:focus:ring-secondary-color"
                        autocomplete="email">
                    @error('customer_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Protección contra bots --}}
            <div class="hidden" aria-hidden="true">
                <label for="website">Sitio web</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>

            {{-- Botón Guardar --}}
            <div class="pt-4 flex justify-end">
                <button type="submit"
                    class="inline-flex justify-center px-6 py-2.5 rounded-md bg-secondary-color text-secondary-text-color transition duration-150 ease-in-out cursor-pointer">
                    {{ isset($customer) ? 'Actualizar cliente ' : 'Guardar nuevo cliente' }}
                </button>
            </div>
        </form>
    </div>
@endsection
