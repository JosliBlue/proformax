<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
        <div class="mb-32 text-center">
            <span class="iconify w-10 h-16 mx-auto" data-icon="mdi:account-circle"></span>
            <h2 class="text-3xl font-medium text-gray-900">Iniciar Sesión</h2>
            <p class="text-sm text-gray-600 mt-4">
                {{ config('app.name', 'Laravel') }}, su plataforma para crear proformas fácil y rápido
            </p>
        </div>

        <form wire:submit.prevent="login" class="mt-8 space-y-6">
            @if ($showEmailInput)
                <!-- Input de correo -->
                <div class="relative">
                    <label for="user_email" class="sr-only">Correo electrónico</label>
                    <input type="email" id="user_email" wire:model="user_email" placeholder="Correo electrónico"
                        class="appearance-none rounded-none block w-full py-2 px-1 mb-12 border-0 border-b-4 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-0 focus:border-blue-500"
                        autocomplete="email" wire:keydown.enter="goToPassword" required>
                    <div class="absolute top-8 left-0 transform translate-y-full w-full text-sm text-red-500">
                        @error('user_email')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <button type="button" wire:click="goToPassword"
                    class="btn-sito w-full flex justify-center py-3 text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Siguiente
                </button>
            @endif

            @if ($showBackButton)
                <button type="button" wire:click="goBackToEmail"
                    class="ml-1 text-gray-600 hover:text-gray-800 focus:outline-none">
                    ← {{ $user_email }}
                </button>
            @endif

            @if ($showPasswordInput)
                <!-- Input de contraseña -->
                <div class="relative">
                    <label for="user_password" class="sr-only">Contraseña</label>
                    <input type="password" id="user_password" wire:model="user_password" placeholder="Contraseña"
                        class="appearance-none rounded-none block w-full py-2 px-1 mb-12 border-0 border-b-4 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-0 focus:border-blue-500"
                        autocomplete="current-password" required>
                    <div class="absolute top-8 left-0 transform translate-y-full w-full text-sm text-red-500">
                        @error('user_password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <button type="submit"
                    class="btn-sito w-full flex justify-center py-3 text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Ingresar
                </button>
            @endif

            @if ($error)
                <div class="text-sm text-red-500 text-center">{{ $error }}</div>
            @endif
        </form>
    </div>
</div>
