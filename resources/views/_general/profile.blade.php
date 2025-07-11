@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm mb-6">
        <a href="{{ route('home') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Mi Perfil</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Izquierda - Información del Usuario -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 md:p-6 sticky top-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2 mb-6">
                    <span class="iconify h-5 w-5 text-[var(--primary-color)]" data-icon="heroicons:user-circle-20-solid"></span>
                    Información del Usuario
                </h2>

                <div class="space-y-6">
                    <!-- Nombre -->
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex-shrink-0">
                            <span class="iconify h-8 w-8 text-[var(--primary-color)]" data-icon="heroicons:user-20-solid"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
                            <p class="font-medium text-gray-800 dark:text-white truncate">{{ $user->user_name }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex-shrink-0">
                            <span class="iconify h-8 w-8 text-[var(--primary-color)]" data-icon="heroicons:envelope-20-solid"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="font-medium text-gray-800 dark:text-white truncate">{{ $user->user_email }}</p>
                        </div>
                    </div>

                    <!-- Rol -->
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex-shrink-0">
                            <span class="iconify h-8 w-8 text-[var(--primary-color)]" data-icon="heroicons:shield-check-20-solid"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Rol</p>
                            <p class="font-medium text-gray-800 dark:text-white">
                                @switch($user->user_rol->value)
                                    @case('gerente')
                                        Gerente
                                    @break
                                    @case('vendedor')
                                        Vendedor
                                    @break
                                    @case('pasante')
                                        Pasante
                                    @break
                                @endswitch
                            </p>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex-shrink-0">
                            <span class="iconify h-8 w-8 {{ $user->user_status ? 'text-green-500' : 'text-red-500' }}"
                                data-icon="heroicons:check-circle-20-solid"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Estado</p>
                            <span class="{{ $user->user_status ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                                {{ $user->user_status ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha - Formularios de Edición -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Editar Nombre -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 md:p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2 mb-4">
                    <span class="iconify h-5 w-5 text-[var(--primary-color)]" data-icon="heroicons:pencil-square-20-solid"></span>
                    Editar Nombre
                </h2>

                <form action="{{ route('profile.update') }}" method="POST" id="nameForm" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="name">

                    <div class="max-w-md">
                        <label for="user_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre *
                        </label>
                        <input type="text" name="user_name" id="user_name" value="{{ old('user_name', $user->user_name) }}" 
                            required maxlength="100"
                            class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md">
                        @error('user_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" id="nameBtn"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1 disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <span class="iconify h-5 w-5" data-icon="heroicons:check-20-solid"></span>
                        Actualizar Nombre
                    </button>
                </form>
            </div>

            <!-- Cambiar Contraseña -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 md:p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2 mb-4">
                    <span class="iconify h-5 w-5 text-[var(--primary-color)]" data-icon="heroicons:lock-closed-20-solid"></span>
                    Cambiar Contraseña
                </h2>

                <form action="{{ route('profile.update') }}" method="POST" id="passwordForm" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="password">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Contraseña Actual *
                            </label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password" required
                                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md pr-12"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('current_password', 'currentIcon')"
                                    class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition-colors">
                                    <span id="currentIcon" class="iconify h-5 w-5" data-icon="heroicons:eye-20-solid"></span>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="user_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nueva Contraseña *
                            </label>
                            <div class="relative">
                                <input type="password" name="user_password" id="user_password" required minlength="8"
                                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md pr-12"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('user_password', 'newIcon')"
                                    class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition-colors">
                                    <span id="newIcon" class="iconify h-5 w-5" data-icon="heroicons:eye-20-solid"></span>
                                </button>
                            </div>
                            @error('user_password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="user_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Confirmar Nueva Contraseña *
                            </label>
                            <div class="relative max-w-md">
                                <input type="password" name="user_password_confirmation" id="user_password_confirmation" required
                                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md pr-12"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('user_password_confirmation', 'confirmIcon')"
                                    class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition-colors">
                                    <span id="confirmIcon" class="iconify h-5 w-5" data-icon="heroicons:eye-20-solid"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="passwordBtn"
                            class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1 disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <span class="iconify h-5 w-5" data-icon="heroicons:arrow-path-20-solid"></span>
                            Actualizar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-icon', 'heroicons:eye-slash-20-solid');
            } else {
                input.type = 'password';
                icon.setAttribute('data-icon', 'heroicons:eye-20-solid');
            }
        }

        function setupFormLoading(formId, buttonId, loadingText) {
            const form = document.getElementById(formId);
            const button = document.getElementById(buttonId);

            form.addEventListener('submit', function() {
                button.disabled = true;
                button.innerHTML = `
                    <span class="iconify h-5 w-5 animate-spin" data-icon="heroicons:arrow-path-20-solid"></span>
                    ${loadingText}
                `;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupFormLoading('nameForm', 'nameBtn', 'Actualizando...');
            setupFormLoading('passwordForm', 'passwordBtn', 'Actualizando...');
        });
    </script>
@endpush
