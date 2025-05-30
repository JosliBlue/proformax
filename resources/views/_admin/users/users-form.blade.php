@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso - Versión con navegación JS -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm mb-6">
        <a href="{{ route('sellers') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ isset($user) ? 'Editar Vendedor' : 'Nuevo Vendedor' }}
        </h1>
    </div>

    <div class="max-w-md mx-auto">
        <form action="{{ isset($user) ? route('sellers.update', $user->id) : route('sellers.store') }}" method="POST"
            class="space-y-4" autocomplete="on" spellcheck="true">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif

            {{-- Token de seguridad adicional --}}
            <input type="hidden" name="form_token" value="{{ Str::random(40) }}">

            {{-- Nombre --}}
            <div>
                <label for="user_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Nombre *
                </label>
                <input type="text" name="user_name" id="user_name" value="{{ old('user_name', $user->user_name ?? '') }}"
                    required
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md"
                    autocomplete="given-name">
                @error('user_name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="user_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Correo electrónico *
                </label>
                <input type="email" name="user_email" id="user_email"
                    value="{{ old('user_email', $user->user_email ?? '') }}" required
                    @if (isset($user) && !auth()->user()->isAdmin()) readonly @endif
                    class="w-full px-4 py-3 text-base border rounded-lg transition-all duration-200 shadow-sm hover:shadow-md
                           @if (!isset($user) || auth()->user()->isAdmin()) border-[var(--primary-color)] dark:border-[var(--secondary-color)]
                               bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200
                               focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)]
                           @else
                               border-gray-300 dark:border-gray-600
                               bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-300
                               cursor-not-allowed @endif">
                @error('user_email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div>
                <label for="user_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    {{ isset($user) ? 'Nueva Contraseña' : 'Contraseña *' }}
                </label>
                <input type="password" name="user_password" id="user_password" {{ isset($user) ? '' : 'required' }}
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md"
                    autocomplete="{{ isset($user) ? 'new-password' : 'current-password' }}">
                @error('user_password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirmar Contraseña --}}
            <div>
                <label for="user_password_confirmation"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    {{ isset($user) ? 'Confirmar Nueva Contraseña' : 'Confirmar Contraseña *' }}
                </label>
                <input type="password" name="user_password_confirmation" id="user_password_confirmation"
                    {{ isset($user) ? '' : 'required' }}
                    class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md"
                    autocomplete="new-password">
            </div>

            {{-- Rol (solo para administradores) --}}
            @if (auth()->check() && auth()->user()->isAdmin())
                <div>
                    <label for="user_rol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Rol *
                    </label>
                    <select name="user_rol" id="user_rol" required
                        class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md">
                        @foreach ($roles as $role)
                            <option value="{{ $role->value }}"
                                {{ old('user_rol', isset($user) ? ($user->user_rol instanceof \App\Enums\UserRole ? $user->user_rol->value : $user->user_rol) : '') == $role->value ? 'selected' : '' }}>
                                @switch(strtolower($role->value))
                                    @case(App\Enums\UserRole::ADMIN->value)
                                        Administrador
                                    @break

                                    @case(App\Enums\UserRole::USER->value)
                                        Vendedor
                                    @break
                                @endswitch
                            </option>
                        @endforeach
                    </select>
                    @error('user_rol')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            {{-- Botones --}}
            <div class="pt-4 flex justify-center gap-3">
                <button type="submit"
                    class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <span class="iconify h-5 w-5" data-icon="fluent:save-20-filled"></span>
                    {{ isset($user) ? 'Actualizar vendedor' : 'Guardar vendedor' }}
                </button>
            </div>
        </form>
    </div>
@endsection
