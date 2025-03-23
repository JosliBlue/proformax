<div>
    <div class="flex items-center justify-center h-full">
        <div class="flex flex-wrap items-center justify-center gap-4 w-full max-w-6xl">
            @foreach ($items as $item)
                <a href="{{ route($item['ruta']) }}"
                    class="w-full sm:w-50 group sm:aspect-square p-4 flex flex-wrap
                    items-center justify-center text-center border-gray-800 rounded-lg shadow-lg bg-gray-100
                    hover:-translate-y-2 duration-500">
                    <div>
                        <span
                            class="iconify w-15 h-15 mx-auto text-violet-500 group-hover:w-20 group-hover:h-20 duration-500"
                            data-icon="{{ $item['icono'] }}"></span>
                        <p class="text-3xl font-medium text-gray-900 group-hover:text-2xl duration-500">
                            {{ $item['titulo'] }}
                        </p>
                    </div>
                    <p class="leading-relaxed text-gray-500 leading-tight text-sm w-full">
                        {{ $item['texto'] }}
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</div>
