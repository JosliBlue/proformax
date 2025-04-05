<div>
    <form wire:submit.prevent="save">
        <!-- Nombre -->
        <div class="mb-4">
            <label for="customer_name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" id="customer_name" wire:model="customer_name"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('customer_name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Apellido -->
        <div class="mb-4">
            <label for="customer_lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
            <input type="text" id="customer_lastname" wire:model="customer_lastname"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('customer_lastname')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
            <label for="customer_phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input type="text" id="customer_phone" wire:model="customer_phone"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('customer_phone')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="customer_email" wire:model="customer_email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('customer_email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-3">
            <a href="#" wire:click.prevent="resetForm"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                Limpiar
            </a>
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                Guardar
            </button>
        </div>
    </form>
</div>
