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
