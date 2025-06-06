@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso (única tarjeta) -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm mb-6">
        <a href="{{ route('home') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Mi Perfil
        </h1>
    </div>

    <!-- Contenedor principal sin tarjetas exteriores -->
    <div class="space-y-6">
        <!-- Sección de Información del usuario -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <span class="iconify h-5 w-5 text-[var(--primary-color)]" data-icon="heroicons:user-circle-20-solid"></span>
                Información del usuario
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mb-1">
                        <span class="iconify h-4 w-4" data-icon="heroicons:user-20-solid"></span>
                        Nombre
                    </p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $user->user_name }}</p>
                </div>

                <!-- Email -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mb-1">
                        <span class="iconify h-4 w-4" data-icon="heroicons:envelope-20-solid"></span>
                        Email
                    </p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $user->user_email }}</p>
                </div>

                <!-- Rol -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mb-1">
                        <span class="iconify h-4 w-4" data-icon="heroicons:shield-check-20-solid"></span>
                        Rol
                    </p>
                    <p class="font-medium text-gray-800 dark:text-white">
                        @switch(strtolower($user->user_rol->value))
                            @case(App\Enums\UserRole::GERENTE->value)
                                Gerente
                            @break
                            @case(App\Enums\UserRole::VENDEDOR->value)
                                Vendedor
                            @break
                            @case(App\Enums\UserRole::PASANTE->value)
                                Pasante
                            @break
                        @endswitch
                    </p>
                </div>

                <!-- Estado -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mb-1">
                        <span class="iconify h-4 w-4 {{ $user->user_status ? 'text-green-500' : 'text-red-500' }}"
                            data-icon="heroicons:check-circle-20-solid"></span>
                        Estado
                    </p>
                    <span
                        class="{{ $user->user_status ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                        {{ $user->user_status ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
        </div>



        <!-- Formulario para cambiar contraseña -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <span class="iconify h-5 w-5 text-[var(--primary-color)]" data-icon="heroicons:lock-closed-20-solid"></span>
                Cambiar contraseña
            </h3>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Contraseña actual -->
                    <div class="space-y-2">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Contraseña actual *
                        </label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password" required
                                class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                                placeholder="••••••••">
                            <span class="iconify absolute right-3 top-3.5 text-gray-400"
                                data-icon="heroicons:lock-closed-20-solid"></span>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Espacio vacío para alinear -->
                    <div class="hidden md:block"></div>

                    <!-- Nueva contraseña -->
                    <div class="space-y-2">
                        <label for="user_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nueva contraseña *
                        </label>
                        <div class="relative">
                            <input type="password" name="user_password" id="user_password" required
                                class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                                placeholder="••••••••">
                            <span class="iconify absolute right-3 top-3.5 text-gray-400"
                                data-icon="heroicons:key-20-solid"></span>
                        </div>
                        @error('user_password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar nueva contraseña -->
                    <div class="space-y-2">
                        <label for="user_password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Confirmar nueva contraseña *
                        </label>
                        <div class="relative">
                            <input type="password" name="user_password_confirmation" id="user_password_confirmation"
                                required
                                class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                                placeholder="••••••••">
                            <span class="iconify absolute right-3 top-3.5 text-gray-400"
                                data-icon="heroicons:check-circle-20-solid"></span>
                        </div>
                    </div>
                </div>

                <!-- Botón Guardar -->
                <div class="pt-2 flex justify-end">
                    <button type="submit"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg transition-all duration-200">
                        <span class="iconify h-5 w-5" data-icon="heroicons:arrow-path-20-solid"></span>
                        Actualizar contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
