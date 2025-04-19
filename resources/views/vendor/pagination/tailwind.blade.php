@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex justify-center items-center w-full mt-5">
        <div class="flex items-center justify-center">
            <div class="py-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-[var(--primary-color)] dark:border-[var(--secondary-color)] transition-colors duration-200">
                <ol class="flex items-center text-sm divide-x divide-gray-200 dark:divide-gray-600">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li>
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <span
                                    class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md text-gray-400 dark:text-gray-500 cursor-not-allowed">
                                    <span class="iconify w-5 h-5 rtl:scale-x-[-1]" data-icon="octicon:arrow-left-16"></span>
                                </span>
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                                aria-label="{{ __('pagination.previous') }}"
                                class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md text-[var(--primary-color)] dark:text-[var(--secondary-color)] hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <span class="iconify w-5 h-5 rtl:scale-x-[-1]" data-icon="octicon:arrow-left-16"></span>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li>
                                <span aria-disabled="true"
                                    class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 text-gray-500 dark:text-gray-400">
                                    <span>{{ $element }}</span>
                                </span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li>
                                        <span aria-current="page"
                                            class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md bg-[var(--primary-color)] dark:bg-[var(--secondary-color)] text-[var(--primary-text-color)] shadow-sm dark:text-[var(--secondary-text-color)]">
                                            <span>{{ $page }}</span>
                                        </span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}"
                                            aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                            class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md text-[var(--primary-color)] dark:text-[var(--secondary-color)] hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <span>{{ $page }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                                aria-label="{{ __('pagination.next') }}"
                                class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md text-[var(--primary-color)] dark:text-[var(--secondary-color)] hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <span class="iconify w-5 h-5 rtl:scale-x-[-1]" data-icon="octicon:arrow-right-16"></span>
                            </a>
                        </li>
                    @else
                        <li>
                            <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                <span
                                    class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md text-gray-400 dark:text-gray-500 cursor-not-allowed">
                                    <span class="iconify w-5 h-5 rtl:scale-x-[-1]" data-icon="octicon:arrow-right-16"></span>
                                </span>
                            </span>
                        </li>
                    @endif
                </ol>
            </div>
        </div>
    </nav>
@endif
