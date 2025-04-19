@extends('appsita')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Información del usuario -->
        <div class="md:bg-gray-100 dark:md:bg-gray-700/30 md:p-4 rounded-lg transition-colors duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Información del usuario</h3>
            <div class="space-y-3">
                <p class="flex items-center gap-2">
                    <span class="iconify text-black dark:text-white" data-icon="mdi:account"></span>
                    <span><span class="font-medium text-black dark:text-white">Nombre:</span>
                        {{ $user->user_name }}</span>
                </p>
                <p class="flex items-center gap-2">
                    <span class="iconify text-black dark:text-white" data-icon="mdi:email"></span>
                    <span><span class="font-medium text-black dark:text-white">Email:</span>
                        {{ $user->user_email }}</span>
                </p>
                <p class="flex items-center gap-2">
                    <span class="iconify text-black dark:text-white" data-icon="mdi:shield-account"></span>
                    <span>
                        <span class="font-medium text-black dark:text-white">Rol:</span>
                        @switch(strtolower($user->user_rol->value))
                            @case(App\Enums\UserRole::ADMIN->value)
                                Administrador
                            @break

                            @case(App\Enums\UserRole::USER->value)
                                Vendedor
                            @break
                        @endswitch
                    </span>
                </p>
            </div>
        </div>

        <!-- Estado de la cuenta -->
        <div class="md:bg-gray-100 dark:md:bg-gray-700/30 md:p-4 rounded-lg transition-colors duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Estado de la cuenta</h3>
            <div class="flex items-center gap-2">
                <span class="iconify text-black dark:text-white " data-icon="mdi:account-circle"></span>
                <span
                    class="{{ $user->user_status ? 'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : 'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' }}">
                    {{ $user->user_status ? 'Activo' : 'Inactivo' }}
                </span>
            </div>

            <!-- Fecha de creación -->
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Cuenta creada el: {{ $user->created_at->format('d/m/Y') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Formulario para cambiar contraseña -->
    <div class="md:bg-gray-100 dark:md:bg-gray-700/30 md:p-4 md:p-6 rounded-lg transition-colors duration-300">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Cambiar contraseña</h3>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Contraseña actual -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Contraseña actual *
                    </label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current_password" required
                            class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                            placeholder="••••••••">
                        <span class="iconify absolute right-3 top-3.5 text-gray-400" data-icon="mdi:lock"></span>
                    </div>
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Espacio vacío para alinear -->
                <div class="hidden md:block"></div>

                <!-- Nueva contraseña -->
                <div>
                    <label for="user_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nueva contraseña *
                    </label>
                    <div class="relative">
                        <input type="password" name="user_password" id="user_password" required
                            class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                            placeholder="••••••••">
                        <span class="iconify absolute right-3 top-3.5 text-gray-400" data-icon="mdi:lock-reset"></span>
                    </div>
                    @error('user_password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar nueva contraseña -->
                <div>
                    <label for="user_password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Confirmar nueva contraseña *
                    </label>
                    <div class="relative">
                        <input type="password" name="user_password_confirmation" id="user_password_confirmation" required
                            class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                            placeholder="••••••••">
                        <span class="iconify absolute right-3 top-3.5 text-gray-400" data-icon="mdi:lock-check"></span>
                    </div>
                </div>
            </div>

            <!-- Botón Guardar -->
            <div class="pt-4 flex justify-end">
                <button type="submit"
                    class="flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:brightness-95 px-6 py-2.5 rounded-lg transition-all duration-200 shadow-md">
                    <span class="iconify w-5 h-5" data-icon="mdi:content-save"></span>
                    Actualizar contraseña
                </button>
            </div>
        </form>
    </div>
@endsection
