<div>
    <header class="bg-white shadow-md px-4 py-5">
        <div class="mx-0 md:mx-16 flex justify-between items-center">
            <!-- Nombre de la empresa -->
            <div class="text-lg font-semibold text-gray-800">
                {{ strtoupper(config('app.name', 'Mi Empresa')) }}
            </div>

            <!-- Contenedor del usuario -->
            <details class="relative">
                <summary class="flex items-center space-x-2 cursor-pointer list-none">
                    <!-- Nombre del usuario (visible en pantallas grandes) -->
                    <div class="hidden md:block text-sm text-gray-700">
                        {{ Auth::user()->user_name }}
                    </div>

                    <!-- Ícono de usuario -->
                    <span class="iconify w-10 h-12" data-icon="mdi:account-circle"></span>
                </summary>

                <!-- Menú flotante -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                    <!-- Nombre del usuario (solo visible en móviles) -->
                    <div class="block md:hidden px-4 py-2 text-sm text-gray-700 border-b">
                        {{ Auth::user()->user_name }}
                    </div>

                    <!-- Botón para cerrar sesión -->
                    <form method="GET" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </details>
        </div>
    </header>
</div>
