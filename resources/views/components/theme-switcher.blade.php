<div class="flex items-center justify-center px-3 py-3 text-sm  gap-x-1">
    <div class="flex items-center">
        <span class="iconify w-5 h-5" data-icon="ph:sun-bold" id="sun-icon"></span>
    </div>
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" id="theme-switch" class="sr-only peer">
        <div
            class="w-9 h-5 bg-gray-400 peer-focus:outline-none rounded-full peer
                    dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white
                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white
                    after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4
                    after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
        </div>
    </label>
    <div class="flex items-center">
        <span class="iconify w-5 h-5" data-icon="ph:moon-bold" id="moon-icon"></span>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeSwitch = document.getElementById('theme-switch');

            // Configurar estado inicial del switch
            themeSwitch.checked = document.documentElement.classList.contains('dark');

            // Manejar cambios en el switch
            themeSwitch.addEventListener('change', () => {
                const theme = themeSwitch.checked ? 'dark' : 'light';

                // Actualizar clases y preferencias
                document.documentElement.classList.toggle('dark', themeSwitch.checked);
                document.documentElement.style.colorScheme = theme;
                localStorage.setItem('theme', theme);
            });
        });
    </script>
@endpush
