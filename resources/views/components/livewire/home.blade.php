<div class="flex items-center justify-center h-full" id="cuerpecito">
    <div class="flex flex-wrap items-center justify-center gap-4 w-full py-4">
        @foreach ($items as $item)
            <a href="{{ route($item['ruta']) }}"
                class="w-full sm:w-50 group sm:aspect-square p-4 flex flex-col items-center justify-center text-center
                        border-gray-800 rounded-lg shadow-lg bg-gray-100 hover:-translate-y-2 duration-500">
                <span
                    class="iconify w-15 h-15 text-violet-500 group-hover:w-20 group-hover:h-20 duration-500"
                    data-icon="{{ $item['icono'] }}"></span>
                <p class="text-3xl font-medium text-gray-900 group-hover:text-2xl duration-500">
                    {{ $item['titulo'] }}
                </p>
                <p class="text-sm leading-tight text-gray-500">
                    {{ $item['texto'] }}
                </p>
            </a>
        @endforeach
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('header');
            const headerHeight = header.offsetHeight;
            const mainContent = document.getElementById('cuerpecito');

            if (mainContent) {
                // Para pantallas más grandes (md y mayores)
                if (window.innerWidth >= 768) {
                    mainContent.style.height = `calc(100vh - ${headerHeight}px)`;
                } else {
                    // Para pantallas móviles, la altura será automática
                    mainContent.style.height = 'auto';
                }
            }
        });

        // Aseguramos que también se ajuste cuando cambie el tamaño de la ventana
        window.addEventListener('resize', function() {
            const header = document.querySelector('header');
            const headerHeight = header.offsetHeight;
            const mainContent = document.getElementById('cuerpecito');

            if (mainContent) {
                if (window.innerWidth >= 768) {
                    mainContent.style.height = `calc(100vh - ${headerHeight}px)`;
                } else {
                    mainContent.style.height = 'auto';
                }
            }
        });
    </script>
@endpush
