@extends('appsita')

@php
    $company = \App\Models\Company::default();
@endphp

@section('content')
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
        <!-- Botón de cambio de tema -->
        <button id="theme-toggle" type="button"
            class="absolute top-4 right-4 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2.5 transition-colors duration-300">
            <span id="theme-icon" class="iconify" data-icon="heroicons:sun-20-solid"></span>
            <span class="sr-only">Cambiar tema</span>
        </button>

        <div class="mb-6 text-center">
            <img class="mx-auto h-20 w-auto" src="{{ $company->getLogoUrlAttribute() }}" alt="{{ $company->company_name }}">
            <span class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $company->company_name }}</span>
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
                                <span class="iconify" id="password-icon" data-icon="heroicons:eye-20-solid"></span>
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-[var(--primary-color)] text-[var(--primary-text-color)] focus:ring-4 focus:outline-none font-medium rounded-lg px-5 py-2.5 text-center transition-colors duration-300">
                        Ingresar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const html = document.documentElement;

            const savedTheme = localStorage.getItem('theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

            if (savedTheme === 'dark') {
                html.classList.add('dark');
                themeIcon.setAttribute('data-icon', 'heroicons:moon-20-solid');
            }

            themeToggle.addEventListener('click', function() {
                html.classList.toggle('dark');
                const isDark = html.classList.contains('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                themeIcon.setAttribute('data-icon', isDark ? 'heroicons:moon-20-solid' :
                    'heroicons:sun-20-solid');
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('theme')) {
                    html.classList.toggle('dark', e.matches);
                    themeIcon.setAttribute('data-icon', e.matches ? 'heroicons:moon-20-solid' :
                        'heroicons:sun-20-solid');
                }
            });

            // Mostrar/Ocultar contraseña
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('user_password');
            const passwordIcon = document.getElementById('password-icon');

            togglePassword.addEventListener('click', function() {
                const isPasswordVisible = passwordInput.type === 'text';
                passwordInput.type = isPasswordVisible ? 'password' : 'text';
                passwordIcon.setAttribute('data-icon', isPasswordVisible ? 'heroicons:eye-20-solid' :
                    'heroicons:eye-off-20-solid');
            });
        });
    </script>
@endpush
