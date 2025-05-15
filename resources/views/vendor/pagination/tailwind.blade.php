@if ($paginator->hasPages())
    <div class="flex items-center justify-between w-full dark:border-gray-700">
        <div class="flex flex-1 justify-between items-center sm:hidden">
            {{-- Mobile view --}}
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center rounded-md  bg-white px-4 py-2 text-sm font-medium text-gray-400 dark:bg-gray-800 dark:text-gray-500 cursor-not-allowed">
                    {{ __('Anterior') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    class="relative inline-flex items-center rounded-md border border-gray-500 dark:border-gray-300 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    {{ __('Anterior') }}
                </a>
            @endif

            {{-- Mobile counter --}}
            <div class="mx-4 text-sm text-gray-700 dark:text-gray-300">
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                -
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                de
                <span class="font-medium">{{ $paginator->total() }}</span>
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                    class="relative inline-flex items-center rounded-md border border-gray-500 dark:border-gray-300 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    {{ __('Siguiente') }}
                </a>
            @else
                <span
                    class="relative inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-400 dark:bg-gray-800 dark:text-gray-500 cursor-not-allowed">
                    {{ __('Siguiente') }}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    -
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    de
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    resultados
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm bg-white dark:bg-gray-900"
                    aria-label="Pagination">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-600 ring-1 ring-gray-300 dark:ring-gray-800 ring-inset cursor-not-allowed">
                            <span class="sr-only">Previous</span>
                            <span class="iconify h-5 w-5" data-icon="line-md:arrow-left"></span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="relative inline-flex items-center rounded-l-md px-2 py-2 text-[var(--primary-color)] dark:text-gray-300 ring-1 ring-inset ring-[var(--primary-color)] dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <span class="sr-only">Anterior</span>
                            <span class="iconify h-5 w-5" data-icon="line-md:arrow-left"></span>
                        </a>
                    @endif

                    {{-- Pagination Numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 ring-1 ring-gray-300 dark:ring-gray-600 ring-inset">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page"
                                        class="relative z-10 inline-flex items-center bg-[var(--primary-color)] dark:bg-gray-200 px-4 py-2 text-sm font-semibold text-[var(--primary-text-color)] dark:text-gray-800 focus:z-20 ring-1 ring-inset ring-[var(--primary-color)] dark:ring-gray-200">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[var(--primary-color)] dark:text-gray-300 ring-1 ring-inset ring-[var(--primary-color)] dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-20">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="relative inline-flex items-center rounded-r-md px-2 py-2 text-[var(--primary-color)] dark:text-gray-300 ring-1 ring-inset ring-[var(--primary-color)] dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <span class="sr-only">Siguiente</span>
                            <span class="iconify h-5 w-5" data-icon="line-md:arrow-right"></span>
                        </a>
                    @else
                        <span
                            class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-600 ring-1 ring-gray-300 dark:ring-gray-800 ring-inset cursor-not-allowed">
                            <span class="sr-only">Siguiente</span>
                            <span class="iconify h-5 w-5" data-icon="line-md:arrow-right"></span>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
@endif
