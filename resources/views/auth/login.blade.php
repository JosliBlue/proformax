@extends('appsita')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <div class="mb-32 text-center">
                <span class="iconify w-10 h-16 mx-auto" data-icon="mdi:account-circle"></span>
                <h2 class="text-3xl font-medium text-gray-900">Iniciar Sesión</h2>
                <p class="text-sm text-gray-600 mt-4">
                    {{ config('app.name', 'Laravel') }}, su plataforma para crear proformas fácil y rápido
                </p>
            </div>

            <!-- Formulario de Email (Paso 1) -->
            <form id="emailForm" class="mt-8 space-y-6">
                @csrf
                <div class="relative">
                    <label for="user_email" class="sr-only">Correo electrónico</label>
                    <input type="email" id="user_email" name="user_email" placeholder="Correo electrónico"
                        class="appearance-none rounded-none block w-full py-2 px-1 mb-12 border-0 border-b-4 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-0 focus:border-blue-500"
                        autocomplete="email" required>
                    <div id="emailError"
                        class="absolute top-8 left-0 transform translate-y-full w-full text-sm text-red-500 hidden"></div>
                </div>
                <button type="submit"
                    class="btn-sito w-full flex justify-center py-3 text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Siguiente
                </button>
            </form>

            <!-- Formulario de Password (Paso 2) -->
            <div id="passwordSection" class="hidden mt-8 space-y-6">
                <button id="backButton" type="button"
                    class="ml-1 text-gray-600 hover:text-gray-800 focus:outline-none mb-4">
                    ← <span id="emailDisplay"></span>
                </button>

                <form id="passwordForm">
                    @csrf
                    <input type="hidden" id="hidden_email" name="user_email">
                    <div class="relative">
                        <label for="user_password" class="sr-only">Contraseña</label>
                        <input type="password" id="user_password" name="user_password" placeholder="Contraseña"
                            class="appearance-none rounded-none block w-full py-2 px-1 mb-12 border-0 border-b-4 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-0 focus:border-blue-500"
                            autocomplete="current-password" required>
                        <div id="passwordError"
                            class="absolute top-8 left-0 transform translate-y-full w-full text-sm text-red-500 hidden">
                        </div>
                    </div>
                    <button type="submit"
                        class="btn-sito w-full flex justify-center py-3 text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Ingresar
                    </button>
                </form>
            </div>

            <!-- Mensaje de error general -->
            <div id="generalError" class="text-sm text-red-500 text-center hidden"></div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailForm = document.getElementById('emailForm');
            const passwordForm = document.getElementById('passwordForm');
            const passwordSection = document.getElementById('passwordSection');
            const backButton = document.getElementById('backButton');
            const emailDisplay = document.getElementById('emailDisplay');
            const hiddenEmail = document.getElementById('hidden_email');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const generalError = document.getElementById('generalError');

            // Validar email y avanzar al paso 2
            emailForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Reset errores
                emailError.classList.add('hidden');
                generalError.classList.add('hidden');

                const email = document.getElementById('user_email').value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                // Validaciones
                if (!email) {
                    showError(emailError, 'El correo electrónico es requerido');
                    return;
                }

                if (!emailRegex.test(email)) {
                    showError(emailError, 'Por favor ingrese un correo electrónico válido');
                    return;
                }

                // Mostrar paso 2
                emailForm.classList.add('hidden');
                passwordSection.classList.remove('hidden');
                emailDisplay.textContent = email;
                hiddenEmail.value = email;
            });

            // Volver al paso 1
            backButton.addEventListener('click', function() {
                passwordSection.classList.add('hidden');
                emailForm.classList.remove('hidden');
            });

            // Enviar formulario de login
            passwordForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Reset errores
                passwordError.classList.add('hidden');
                generalError.classList.add('hidden');

                const password = document.getElementById('user_password').value;

                if (!password) {
                    showError(passwordError, 'La contraseña es requerida');
                    return;
                }

                // Enviar datos al servidor
                const formData = new FormData(passwordForm);

                fetch('/login', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                            return;
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.errors) {
                            if (data.errors.user_email) {
                                showError(emailError, data.errors.user_email[0]);
                                passwordSection.classList.add('hidden');
                                emailForm.classList.remove('hidden');
                            }
                            if (data.errors.user_password) {
                                showError(passwordError, data.errors.user_password[0]);
                            }
                        } else if (data && data.message) {
                            showError(generalError, data.message);
                        }
                    })
                    .catch(error => {
                        showError(generalError, 'Ocurrió un error. Por favor, inténtelo de nuevo.');
                        console.error('Error:', error);
                    });
            });

            // Función auxiliar para mostrar errores
            function showError(element, message) {
                element.textContent = message;
                element.classList.remove('hidden');
            }
        });
    </script>
@endpush
