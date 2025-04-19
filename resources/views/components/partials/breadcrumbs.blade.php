@unless ($breadcrumbs->isEmpty())
    <nav class="flex mx-0 py-3 px-4 md:mx-20 md:px-0">
        {{--
            Lista ordenada de breadcrumbs.
            - 'inline-flex': Elementos en línea con flexbox
            - 'items-center': Centrado vertical
            - 'space-x-1 md:space-x-2': Espaciado entre elementos (1 en móvil, 2 en desktop)
        --}}
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            
            @foreach ($breadcrumbs as $breadcrumb)
                {{-- Primer elemento (normalmente el Home) --}}
                @if ($loop->first)
                    {{--
                        Elemento Home:
                        - 'inline-flex items-center': Alineación del icono y texto
                    --}}
                    <li class="inline-flex items-center">
                        {{--
                            Enlace Home:
                            - 'group': Permite efectos hover en elementos hijos
                            - 'text-sm font-medium': Tamaño y peso de fuente
                            - 'text-gray-700': Color gris oscuro en modo claro
                            - 'hover:text-[var(--primary-color)]': Color primario al hacer hover
                            - 'dark:text-gray-300': Color gris claro en modo oscuro
                            - 'dark:hover:text-[var(--primary-color)]': Color primario al hover en oscuro
                        --}}
                        <a href="{{ $breadcrumb->url }}"
                            class="group inline-flex items-center text-sm font-medium text-gray-700 hover:text-[var(--primary-color)] dark:text-gray-300 dark:hover:text-[var(--primary-color)]">

                            {{--
                                Icono Home:
                                - 'iconify': Clase para el icono
                                - 'w-5 h-5': Tamaño del icono
                                - 'text-gray-700': Color gris oscuro en modo claro
                                - 'group-hover:text-[var(--primary-color)]': Color primario al hover
                                - 'mr-1': Margen derecho para separar icono y texto
                                - 'dark:text-gray-300': Color gris claro en modo oscuro
                                - 'dark:group-hover:text-[var(--primary-color)]': Color primario al hover en oscuro
                                - 'data-icon="ic:round-home"': Icono de Home de Iconify
                            --}}
                            <span
                                class="iconify w-5 h-5 text-gray-700 group-hover:text-[var(--primary-color)] mr-1 dark:text-gray-300 dark:group-hover:text-[var(--primary-color)]"
                                data-icon="ic:round-home"></span>

                            {{-- Texto del breadcrumb --}}
                            {{ $breadcrumb->title }}
                        </a>
                    </li>

                    {{-- Elementos intermedios --}}
                @elseif (!$loop->last)
                    <li>
                        {{-- Contenedor del elemento intermedio --}}
                        <div class="flex items-center">
                            {{--
                                Separador entre elementos:
                                - 'iconify': Clase para el icono
                                - 'w-6 h-6': Tamaño del icono
                                - 'text-gray-400': Color gris claro en modo claro
                                - 'dark:text-gray-500': Color gris medio en modo oscuro
                                - 'data-icon="heroicons:slash-16-solid"': Icono de separador (/)
                            --}}
                            <span class="iconify w-6 h-6 text-gray-400 dark:text-gray-500"
                                data-icon="heroicons:slash-16-solid"></span>

                            {{--
                                Enlace intermedio:
                                - 'ms-1 md:ms-2': Margen izquierdo (1 en móvil, 2 en desktop)
                                - 'text-sm font-medium': Tamaño y peso de fuente
                                - 'text-gray-700': Color gris oscuro en modo claro
                                - 'hover:text-[var(--primary-color)]': Color primario al hover
                                - 'dark:text-gray-300': Color gris claro en modo oscuro
                                - 'dark:hover:text-[var(--primary-color)]': Color primario al hover en oscuro
                            --}}
                            <a href="{{ $breadcrumb->url }}"
                                class="ms-1 text-sm font-medium text-gray-700 hover:text-[var(--primary-color)] md:ms-2 dark:text-gray-300 dark:hover:text-[var(--primary-color)]">
                                {{ $breadcrumb->title }}
                            </a>
                        </div>
                    </li>

                    {{-- Último elemento (página actual) --}}
                @else
                    {{--
                        Elemento actual (sin enlace):
                        - 'aria-current="page"': Indica que es la página actual (accesibilidad)
                    --}}
                    <li aria-current="page">
                        <div class="flex items-center">
                            {{-- Separador (mismo estilo que elementos intermedios) --}}
                            <span class="iconify w-6 h-6 text-gray-400 dark:text-gray-500"
                                data-icon="heroicons:slash-16-solid"></span>

                            {{--
                                Texto de la página actual:
                                - 'ms-1 md:ms-2': Margen izquierdo (1 en móvil, 2 en desktop)
                                - 'text-sm font-medium': Tamaño y peso de fuente
                                - 'text-gray-500': Color gris medio en modo claro
                                - 'dark:text-gray-400': Color gris en modo oscuro
                                - 'opacity-80': Ligera transparencia para diferenciarlo
                            --}}
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400 opacity-80">
                                {{ $breadcrumb->title }}
                            </span>
                        </div>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endunless
