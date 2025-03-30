@php
    // Definimos variables de color (puedes mover esto a un archivo de configuración si lo prefieres)
    $colorBase = 'gray';
    $colorPrimary = 'blue';
    $colorPrimaryIntensity = '500';
    $colorHoverIntensity = '100';
@endphp

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-center items-center w-full">
        <div class="flex items-center justify-center">
            <div class="py-3 border border-{{ $colorBase }}-300 rounded-lg md:border-none">
                <ol class="flex items-center text-sm text-{{ $colorBase }}-500 divide-x rtl:divide-x-reverse divide-{{ $colorBase }}-300">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li>
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <span class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none cursor-not-allowed pointer-events-none opacity-70">
                                    <svg class="w-5 h-5 rtl:scale-x-[-1]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}" class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-{{ $colorBase }}-{{ $colorHoverIntensity }} focus:bg-{{ $colorPrimary }}-{{ $colorHoverIntensity }} focus:ring-2 focus:ring-{{ $colorPrimary }}-{{ $colorPrimaryIntensity }} transition text-{{ $colorPrimary }}-600">
                                <svg class="w-5 h-5 rtl:scale-x-[-1]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li>
                                <span aria-disabled="true" class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none cursor-not-allowed pointer-events-none opacity-70">
                                    <span>{{ $element }}</span>
                                </span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li>
                                        <span aria-current="page" class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-{{ $colorPrimary }}-600 bg-{{ $colorPrimary }}-{{ $colorHoverIntensity }} ring-2 ring-{{ $colorPrimary }}-{{ $colorPrimaryIntensity }}">
                                            <span>{{ $page }}</span>
                                        </span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-{{ $colorBase }}-{{ $colorHoverIntensity }} focus:bg-{{ $colorPrimary }}-{{ $colorHoverIntensity }} focus:ring-2 focus:ring-{{ $colorPrimary }}-{{ $colorPrimaryIntensity }} focus:text-{{ $colorPrimary }}-600 transition">
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
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}" class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-{{ $colorBase }}-{{ $colorHoverIntensity }} focus:bg-{{ $colorPrimary }}-{{ $colorHoverIntensity }} focus:ring-2 focus:ring-{{ $colorPrimary }}-{{ $colorPrimaryIntensity }} transition text-{{ $colorPrimary }}-600">
                                <svg class="w-5 h-5 rtl:scale-x-[-1]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </li>
                    @else
                        <li>
                            <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                <span class="relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none cursor-not-allowed pointer-events-none opacity-70">
                                    <svg class="w-5 h-5 rtl:scale-x-[-1]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                        </li>
                    @endif
                </ol>
            </div>
        </div>
    </nav>
@endif
