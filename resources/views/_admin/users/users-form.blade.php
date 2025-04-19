@extends('appsita')

@section('content')
{{--
        @if (isset($user))
            <h2
                class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
                Editar vendedor</h2>
        @else
            <h2
                class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
                Nuevo vendedor</h2>
        @endif
 --}}

        <form action="{{ isset($user) ? route('sellers.update', $user->id) : route('sellers.store') }}" method="POST"
            class="my-5" autocomplete="on" spellcheck="true">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif

            {{-- Token de seguridad adicional --}}
            <input type="hidden" name="form_token" value="{{ Str::random(40) }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre del Vendedor --}}
                <div>
                    <label for="user_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nombre del Vendedor *
                    </label>
                    <input type="text" name="user_name" id="user_name"
                        value="{{ old('user_name', $user->user_name ?? '') }}" required
                        class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                        autocomplete="name">
                    @error('user_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="user_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Email *
                    </label>
                    <input type="email" name="user_email" id="user_email"
                        value="{{ old('user_email', $user->user_email ?? '') }}" required
                        class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                        autocomplete="email">
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
                        class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
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
                        class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                        autocomplete="new-password">
                </div>

                {{-- Rol (solo para administradores) --}}
                @if (auth()->check() && auth()->user()->isAdmin())
                    <div>
                        <label for="user_rol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Rol *
                        </label>
                        <select name="user_rol" id="user_rol" required
                            class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                            @foreach ($roles as $role)
                                <option value="{{ $role->value }}"
                                    {{ old('user_rol', $user->user_rol ?? '') == $role->value ? 'selected' : '' }}>
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
            </div>

            {{-- Botones --}}
            <div class="pt-4 flex justify-end gap-3">
                <button type="submit"
                    class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-2.5 rounded-lg transition-all duration-200">
                    {{ isset($user) ? 'Actualizar vendedor' : 'Guardar vendedor' }}
                </button>
            </div>
        </form>

@endsection
