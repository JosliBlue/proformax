<header
    class="flex justify-between items-center mx-auto w-full p-4 md:px-20 py-4 lg:py-4 bg-[var(--primary-color)] text-[var(--primary-text-color)]">
    <!-- Logo y nombre de empresa -->
    <div class="flex items-center space-x-3">
        <img src="{{ $company->getLogoUrlAttribute() }}" alt="{{ $company->company_name }}"
            class="h-10 w-auto object-contain">
        <div class="text-xl font-bold">
            {{ strtoupper($company->company_name) }}
        </div>
    </div>

    <!-- Contenedor usuario -->
    <details class="relative" id="userMenu">
        <summary class="flex items-center md:space-x-2 cursor-pointer list-none">
            <!-- Nombre usuario -->
            <div class="hidden md:block">
                {{ Auth::user()->user_name }}
            </div>

            <!-- Ícono usuario -->
            <span class="iconify w-12 h-12" data-icon="mdi:account-circle"></span>
        </summary>

        <!-- Menú flotante - Full width en mobile -->
        <div
            class="fixed md:absolute inset-x-0 md:right-0 md:left-auto mt-2 md:bottom-auto md:top-full md:w-48 mx-5 md:mx-0 rounded-lg shadow-lg py-2 z-50 bg-white text-black dark:bg-gray-900 dark:text-white">
            <div
                class="block text-center px-4 py-2  border-b border-gray-200 dark:border-gray-600 md:hidden select-none">
                {{ Auth::user()->user_name }}
            </div>

            <!-- Switch de tema -->
            <div class="hover:bg-gray-100 dark:hover:bg-gray-700">
                <x-theme-switcher />
            </div>

            <!-- Opción de perfil -->
            <a href="{{ route('profile') }}"
                class="w-full text-center px-4 py-2  flex justify-center items-center space-x-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                <span>Mi perfil</span>
            </a>

            <!-- Opción de cerrar sesión -->
            <a href="{{ route('logout') }}"
                class="w-full text-center px-4 py-2  flex justify-center items-center space-x-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                Cerrar Sesión
            </a>
        </div>
    </details>
</header>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userMenu = document.getElementById('userMenu');

            // Cerrar menú al hacer clic fuera en mobile
            document.addEventListener('click', (e) => {
                if (!userMenu.contains(e.target)) {
                    userMenu.removeAttribute('open');
                }
            });
        });
    </script>
@endpush
