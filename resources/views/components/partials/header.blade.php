<header
    class="flex justify-between items-center p-4 md:mx-20 md:rounded-lg md:mt-2 bg-[var(--primary-color)] text-[var(--primary-text-color)]">
    <!-- Logo y nombre de empresa -->
    <div class="flex items-center space-x-3">
        @if ($company->logo_url)
            <img src="{{ $company->getLogoUrlAttribute() }}" alt="{{ $company->company_name }}"
                class="h-10 w-auto object-contain">
        @endif
        <div class="text-lg font-semibold">
            {{ strtoupper($company->company_name) }}
        </div>
    </div>
    <!-- Contenedor usuario -->
    <details class="relative">
        <summary class="flex items-center space-x-2 cursor-pointer list-none">
            <!-- Nombre usuario -->
            <div class="hidden text-sm md:block">
                {{ Auth::user()->user_name }}
            </div>

            <!-- Ícono usuario -->
            <span class="iconify w-auto h-12" data-icon="mdi:account-circle"></span>
        </summary>

        <!-- Menú flotante -->
        <div
            class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg py-2 z-50 bg-white text-black dark:bg-[var(--mi-oscuro)] dark:text-white">
            <div class="block px-4 py-2 text-sm border-b border-gray-200 dark:border-gray-600 md:hidden select-none">
                {{ Auth::user()->user_name }}
            </div>
            <a href="{{ route('profile') }}"
                class="w-full text-left px-4 py-2 text-sm flex items-center space-x-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                <span class="iconify w-5 h-5" data-icon="mdi:account-circle"></span>
                <span>Mi perfil</span>
            </a>

            <!-- Botones de tema alternantes -->
            <button id="light-theme-btn"
                class="w-full text-left px-4 py-2 text-sm flex items-center space-x-2 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hidden">
                <span class="iconify w-5 h-5" data-icon="ph:sun-bold"></span>
                <span>Modo Claro</span>
            </button>

            <button id="dark-theme-btn"
                class="w-full text-left px-4 py-2 text-sm flex items-center space-x-2 hover:bg-gray-100 dark:hover:bg-gray-700 hidden dark:flex">
                <span class="iconify w-5 h-5" data-icon="ph:moon-bold"></span>
                <span>Modo Oscuro</span>
            </button>

            <a href="{{ route('logout') }}"
                class="w-full text-left px-4 py-2 text-sm flex items-center space-x-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                <span class="iconify w-5 h-5" data-icon="tabler:logout"></span>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </details>
</header>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lightBtn = document.getElementById('light-theme-btn');
            const darkBtn = document.getElementById('dark-theme-btn');
            const html = document.documentElement;

            // Función para establecer el tema
            function setTheme(theme) {
                if (theme === 'dark') {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            }

            // Verificar tema guardado o preferencia del sistema
            const savedTheme = localStorage.getItem('theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

            // Aplicar tema inicial
            setTheme(savedTheme);

            // Eventos para los botones
            lightBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                setTheme('dark');
            });

            darkBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                setTheme('light');
            });

            // Escuchar cambios en la preferencia del sistema
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('theme')) {
                    setTheme(e.matches ? 'dark' : 'light');
                }
            });
        });
    </script>
@endpush
