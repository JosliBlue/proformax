<footer class="bg-white dark:bg-gray-900">
    <div class="mx-auto w-full px-4 md:px-20 py-3 lg:py-3">
        <!-- Logo y Copyright -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-center">
            <div class="flex items-center gap-2 mb-2 sm:mb-0 justify-center">
                <img src="{{ $company->default()->getLogoUrlAttribute() }}" alt="Logo Proformax"
                    class="h-8 w-auto rounded shadow-md border-gray-200 dark:border-gray-700"
                    loading="lazy">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400 font-semibold">{{ $company->default()->company_name }} SA</span>
            </div>
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                © 2025 <a href="https://github.com/JosliBlue" class="hover:underline">/|\ JosliBlue</a>.
                <span class="text-xs md:text-sm">Todos los derechos reservados</span>
            </span>

            <!-- Social Icons -->
            <div class="flex mt-4 space-x-5 sm:justify-center sm:mt-0 justify-center">
                <a href="https://github.com/JosliBlue" class="text-gray-500 hover:text-gray-900 dark:hover:text-white"
                    aria-label="Github">
                    <span class="iconify w-5 h-5" data-icon="bytesize:github"></span>
                </a>
                <a href="https://github.com/JosliBlue" class="text-gray-500 hover:text-gray-900 dark:hover:text-white"
                    aria-label="Linkedin">
                    <span class="iconify w-5 h-5" data-icon="uiw:linkedin"></span>
                </a>

            </div>
        </div>
    </div>
</footer>
