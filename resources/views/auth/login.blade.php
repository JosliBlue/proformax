@extends('appsita')

@php
    $company = \App\Models\Company::default();
@endphp

@section('content')
    <div
        class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="absolute top-4 right-4 flex items-center">
            <x-theme-switcher />
            <span class="sr-only">Cambiar tema</span>
        </div>

        <div class="mb-6 text-center">
            <img class="mx-auto h-20 w-auto" src="{{ $company->getLogoUrlAttribute() }}" alt="{{ $company->company_name }}">
            <span class="block mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ $company->company_name }}</span>
        </div>
        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700 transition-colors duration-300">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1
                    class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white transition-colors duration-300">
                    Iniciar sesión
                </h1>
                <form method="POST" action="{{ route('login.submit') }}" class="space-y-4 md:space-y-6">
                    @csrf
                    <div>
                        <label for="user_email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white transition-colors duration-300">Correo
                            electrónico</label>
                        <input type="email" name="user_email" id="user_email"
                            class="w-full p-2.5 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                            placeholder="nombre@empresa.com" value="{{ old('user_email') }}" required>
                    </div>
                    <div>
                        <label for="user_password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white transition-colors duration-300">Contraseña</label>
                        <div class="relative">
                            <input type="password" name="user_password" id="user_password" placeholder="Tu contraseña"
                                class="w-full p-2.5 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 pr-12"
                                required>
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-600 dark:text-gray-300">
                                <span id="passwordIcon" class="iconify" data-icon="heroicons:eye-20-solid"></span>
                                <span class="sr-only">Mostrar/Ocultar contraseña</span>
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-[var(--primary-color)] text-[var(--primary-text-color)] hover:bg-opacity-90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center transition-colors duration-300 dark:focus:ring-blue-800">
                        Ingresar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mostrar/Ocultar contraseña
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('user_password');

            // Verificar que todos los elementos existan antes de añadir el listener
            togglePassword.addEventListener('click', function() {
                const isPasswordVisible = passwordInput.type === 'text';
                passwordInput.type = isPasswordVisible ? 'password' : 'text';
            });
        });
    </script>
@endpush
