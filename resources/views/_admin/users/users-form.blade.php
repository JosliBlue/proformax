@extends('appsita'            {{-- Token de seguridad adicional --}}
            <input type="hidden" name="form_token" value="{{ Str::random(40) }}">

            {{-- Mensaje de estado del formulario --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
@section('content')
    <!-- Título con flecha de retroceso -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm mb-6">
        <a href="{{ route('sellers') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Nuevo Vendedor
        </h1>
    </div>

    <div class="max-w-md mx-auto">
        <form action="{{ route('sellers.store') }}" method="POST" class="space-y-4" autocomplete="on" spellcheck="true" id="userForm">
            @csrf

            {{-- Token de seguridad adicional --}}
            <input type="hidden" name="form_token" value="{{ Str::random(40) }}">

            {{-- Nombre --}}
            <div>
                <label for="user_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Nombre completo *
                </label>
                <input type="text" name="user_name" id="user_name" value="{{ old('user_name') }}"
                    required maxlength="100" placeholder="Ej: Juan Pérez"
                    class="w-full px-4 py-3 text-base border rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 transition-all duration-200 shadow-sm hover:shadow-md
                    @error('user_name') border-red-500 dark:border-red-500 focus:ring-red-500 dark:focus:ring-red-500 @else border-[var(--primary-color)] dark:border-[var(--secondary-color)] focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] @enderror"
                    autocomplete="given-name">
                @error('user_name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                        <span class="iconify h-4 w-4" data-icon="heroicons:exclamation-circle-20-solid"></span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="user_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Correo electrónico *
                </label>
                <input type="email" name="user_email" id="user_email" value="{{ old('user_email') }}" 
                    required maxlength="100" placeholder="usuario@empresa.com"
                    class="w-full px-4 py-3 text-base border rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 transition-all duration-200 shadow-sm hover:shadow-md
                    @error('user_email') border-red-500 dark:border-red-500 focus:ring-red-500 dark:focus:ring-red-500 @else border-[var(--primary-color)] dark:border-[var(--secondary-color)] focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] @enderror"
                    autocomplete="email">
                @error('user_email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                        <span class="iconify h-4 w-4" data-icon="heroicons:exclamation-circle-20-solid"></span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div>
                <label for="user_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Contraseña *
                </label>
                <div class="relative">
                    <input type="password" name="user_password" id="user_password" required
                        minlength="8" maxlength="100" placeholder="Mínimo 8 caracteres"
                        class="w-full px-4 py-3 text-base border rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 transition-all duration-200 shadow-sm hover:shadow-md pr-12
                        @error('user_password') border-red-500 dark:border-red-500 focus:ring-red-500 dark:focus:ring-red-500 @else border-[var(--primary-color)] dark:border-[var(--secondary-color)] focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] @enderror"
                        autocomplete="new-password">
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition-colors">
                        <span id="passwordIcon" class="iconify h-5 w-5" data-icon="heroicons:eye-20-solid"></span>
                        <span class="sr-only">Mostrar/Ocultar contraseña</span>
                    </button>
                </div>
                @error('user_password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                        <span class="iconify h-4 w-4" data-icon="heroicons:exclamation-circle-20-solid"></span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Confirmar Contraseña --}}
            <div>
                <label for="user_password_confirmation"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Confirmar Contraseña *
                </label>
                <div class="relative">
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation"
                        required minlength="8" maxlength="100" placeholder="Repetir la contraseña"
                        class="w-full px-4 py-3 text-base border rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 transition-all duration-200 shadow-sm hover:shadow-md pr-12
                        @error('user_password') border-red-500 dark:border-red-500 focus:ring-red-500 dark:focus:ring-red-500 @else border-[var(--primary-color)] dark:border-[var(--secondary-color)] focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] @enderror"
                        autocomplete="new-password">
                    <button type="button" id="togglePasswordConfirmation"
                        class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition-colors">
                        <span id="passwordConfirmationIcon" class="iconify h-5 w-5"
                            data-icon="heroicons:eye-20-solid"></span>
                        <span class="sr-only">Mostrar/Ocultar confirmación de contraseña</span>
                    </button>
                </div>
                <div id="passwordMatch" class="mt-1 text-xs hidden">
                    <!-- Mensaje de coincidencia se mostrará aquí -->
                </div>
            </div>

            {{-- Rol (solo para gerentes y vendedores, pero solo pueden asignar vendedor o pasante) --}}
            @if (auth()->check() && (auth()->user()->isGerente() || auth()->user()->isVendedor()))
                <div>
                    <label for="user_rol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Rol del usuario *
                    </label>
                    <select name="user_rol" id="user_rol" required
                        class="w-full px-4 py-3 text-base border rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 transition-all duration-200 shadow-sm hover:shadow-md
                        @error('user_rol') border-red-500 dark:border-red-500 focus:ring-red-500 dark:focus:ring-red-500 @else border-[var(--primary-color)] dark:border-[var(--secondary-color)] focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] @enderror">
                        <option value="">Selecciona un rol</option>
                        @foreach ($roles as $role)
                            @if (in_array($role->value, [\App\Enums\UserRole::VENDEDOR->value, \App\Enums\UserRole::PASANTE->value]))
                                <option value="{{ $role->value }}" {{ old('user_rol') == $role->value ? 'selected' : '' }}>
                                    @switch(strtolower($role->value))
                                        @case(\App\Enums\UserRole::VENDEDOR->value)
                                            Vendedor
                                        @break
                                        @case(\App\Enums\UserRole::PASANTE->value)
                                            Pasante
                                        @break
                                    @endswitch
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('user_rol')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                            <span class="iconify h-4 w-4" data-icon="heroicons:exclamation-circle-20-solid"></span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            @endif

            {{-- Botones --}}
            <div class="pt-6 flex justify-center gap-3">
                <button type="submit" id="submitBtn"
                    class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 disabled:bg-gray-400 disabled:cursor-not-allowed px-6 py-3 rounded-lg w-full transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1 disabled:transform-none">
                    <span class="iconify h-5 w-5" data-icon="fluent:save-20-filled"></span>
                    Guardar vendedor
                </button>
            </div>
            </form>
        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Elementos del formulario
                const form = document.getElementById('userForm');
                const passwordInput = document.getElementById('user_password');
                const passwordConfirmationInput = document.getElementById('user_password_confirmation');
                const passwordMatchDiv = document.getElementById('passwordMatch');
                const submitBtn = form.querySelector('button[type="submit"]');

                // Mostrar/Ocultar contraseña principal
                const togglePassword = document.getElementById('togglePassword');
                const passwordIcon = document.getElementById('passwordIcon');

                if (togglePassword && passwordInput && passwordIcon) {
                    togglePassword.addEventListener('click', function() {
                        const isPasswordVisible = passwordInput.type === 'text';
                        passwordInput.type = isPasswordVisible ? 'password' : 'text';
                        passwordIcon.setAttribute('data-icon', isPasswordVisible ? 'heroicons:eye-20-solid' :
                            'heroicons:eye-slash-20-solid');
                    });
                }

                // Mostrar/Ocultar confirmación de contraseña
                const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
                const passwordConfirmationIcon = document.getElementById('passwordConfirmationIcon');

                if (togglePasswordConfirmation && passwordConfirmationInput && passwordConfirmationIcon) {
                    togglePasswordConfirmation.addEventListener('click', function() {
                        const isPasswordVisible = passwordConfirmationInput.type === 'text';
                        passwordConfirmationInput.type = isPasswordVisible ? 'password' : 'text';
                        passwordConfirmationIcon.setAttribute('data-icon', isPasswordVisible ?
                            'heroicons:eye-20-solid' : 'heroicons:eye-slash-20-solid');
                    });
                }

                // Validación de contraseña en tiempo real
                function validatePassword(password) {
                    const minLength = password.length >= 8;
                    const hasUppercase = /[A-Z]/.test(password);
                    const hasLowercase = /[a-z]/.test(password);
                    const hasNumber = /\d/.test(password);
                    
                    return {
                        isValid: minLength && hasUppercase && hasLowercase && hasNumber,
                        minLength,
                        hasUppercase,
                        hasLowercase,
                        hasNumber
                    };
                }

                // Validación de coincidencia de contraseñas
                function checkPasswordMatch() {
                    const password = passwordInput.value;
                    const confirmation = passwordConfirmationInput.value;

                    if (confirmation === '') {
                        passwordMatchDiv.classList.add('hidden');
                        return;
                    }

                    passwordMatchDiv.classList.remove('hidden');

                    if (password === confirmation) {
                        passwordMatchDiv.innerHTML = `
                            <span class="text-green-600 dark:text-green-400 flex items-center gap-1">
                                <span class="iconify h-4 w-4" data-icon="heroicons:check-circle-20-solid"></span>
                                Las contraseñas coinciden
                            </span>
                        `;
                        passwordConfirmationInput.classList.remove('border-red-500', 'focus:ring-red-500');
                        passwordConfirmationInput.classList.add('border-green-500', 'focus:ring-green-500');
                    } else {
                        passwordMatchDiv.innerHTML = `
                            <span class="text-red-600 dark:text-red-400 flex items-center gap-1">
                                <span class="iconify h-4 w-4" data-icon="heroicons:exclamation-circle-20-solid"></span>
                                Las contraseñas no coinciden
                            </span>
                        `;
                        passwordConfirmationInput.classList.remove('border-green-500', 'focus:ring-green-500');
                        passwordConfirmationInput.classList.add('border-red-500', 'focus:ring-red-500');
                    }
                }

                // Event listeners para validación en tiempo real
                if (passwordConfirmationInput) {
                    passwordConfirmationInput.addEventListener('input', checkPasswordMatch);
                    passwordInput.addEventListener('input', checkPasswordMatch);
                }

                // Prevenir envío de formulario si hay errores
                form.addEventListener('submit', function(e) {
                    const password = passwordInput.value;
                    const confirmation = passwordConfirmationInput.value;

                    // Validar coincidencia de contraseñas
                    if (password !== confirmation) {
                        e.preventDefault();
                        // Mostrar error visual
                        passwordConfirmationInput.classList.add('border-red-500', 'focus:ring-red-500');
                        passwordConfirmationInput.focus();

                        // Mostrar mensaje de error más amigable
                        const errorMsg = document.createElement('div');
                        errorMsg.className =
                            'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50';
                        errorMsg.innerHTML = `
                            <span class="iconify h-5 w-5 inline mr-2" data-icon="heroicons:exclamation-circle-20-solid"></span>
                            Las contraseñas no coinciden
                        `;
                        document.body.appendChild(errorMsg);
                        setTimeout(() => errorMsg.remove(), 3000);
                        return false;
                    }

                    // Validar fortaleza de contraseña
                    const validation = validatePassword(password);
                    if (!validation.isValid) {
                        e.preventDefault();
                        passwordInput.focus();
                        
                        // Mostrar mensaje de error específico
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50';
                        errorMsg.innerHTML = `
                            <span class="iconify h-5 w-5 inline mr-2" data-icon="heroicons:exclamation-circle-20-solid"></span>
                            La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número
                        `;
                        document.body.appendChild(errorMsg);
                        setTimeout(() => errorMsg.remove(), 4000);
                        return false;
                    }

                    // Mostrar indicador de carga
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <span class="iconify h-5 w-5 animate-spin" data-icon="heroicons:arrow-path-20-solid"></span>
                        Guardando...
                    `;
                });

                // Auto-focus en el primer campo con error
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.focus();
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                // Limpiar errores visuales al escribir
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        this.classList.remove('border-red-500', 'focus:ring-red-500');
                        this.classList.add('border-[var(--primary-color)]',
                            'focus:ring-[var(--primary-color)]');
                    });
                });
            });
        </script>
    @endpush
