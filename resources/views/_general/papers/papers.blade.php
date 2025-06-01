@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso - Versión con navegación JS -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm">
        <a href="{{ route('home') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Gestión de Proformas
        </h1>
    </div>

    <div class="flex flex-col gap-4 my-4">
        <!-- Barra superior con buscador y botón -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <!-- Buscador Mejorado -->
            <div class="w-full sm:w-auto">
                <form action="{{ route('papers') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-96">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <span class="iconify h-5 w-5 " data-icon="line-md:search-filled"></span>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar proformas..."
                            class="w-full pl-12 pr-4 py-3 text-base rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200 shadow-sm hover:shadow-md">
                    </div>

                    <div class="flex gap-3 w-full sm:w-auto">
                        <button type="submit"
                            class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--primary-color)] text-[var(--primary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                            Buscar
                        </button>

                        @if (request('search'))
                            <a href="{{ route('papers') }}"
                                class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                                <span class="iconify h-5 w-5" data-icon="iconamoon:trash-light"></span>
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Botón Nueva Proforma -->
            <div class="w-full sm:w-auto">
                <a href="{{ route('papers.create') }}"
                    class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg w-full sm:w-auto transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <span class="iconify h-5 w-5" data-icon="fluent:add-32-filled"></span>
                    Nueva proforma
                </a>
            </div>
        </div>

        <!-- Bloque de borradores mejorado -->
        @if (isset($drafts) && $drafts->count())
            <div class="flex items-center">
                <span class="iconify h-6 w-6 text-yellow-600 dark:text-yellow-300" data-icon="mdi:note-edit-outline"></span>
                <span class="font-semibold text-yellow-800 dark:text-yellow-200 text-lg">Borradores pendientes</span>
            </div>
            <div class="flex flex-col gap-2">
                @foreach ($drafts as $paper)
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between bg-yellow-50 dark:bg-yellow-800/60 rounded-lg py-2 px-3 border border-yellow-200 dark:border-yellow-700 shadow-sm gap-2 md:gap-0">
                        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 w-full">
                            <div
                                class="flex flex-row items-center gap-2 md:gap-4 w-full md:w-auto justify-between md:justify-start">
                                <span
                                    class="font-medium text-yellow-900 dark:text-yellow-100 text-base">{{ $paper->paper_date ? \Carbon\Carbon::parse($paper->paper_date)->format('d/m/Y') : '' }}</span>
                                <span
                                    class="text-sm text-yellow-800 dark:text-yellow-200">{{ $paper->customer->customer_name ?? 'Sin cliente' }}</span>
                                <span class="text-sm font-semibold text-yellow-900 dark:text-yellow-100">Total:
                                    ${{ number_format($paper->paper_total_price, 2) }}</span>
                            </div>
                        </div>
                        <div class="flex flex-row gap-2 w-full md:w-auto justify-center">
                            <a href="{{ route('papers.edit', $paper->id) }}"
                                class="px-3 py-1 bg-yellow-400 text-yellow-900 rounded-lg hover:bg-yellow-500 font-semibold flex items-center gap-1 shadow">
                                <span class="iconify h-4 w-4" data-icon="mdi:pencil"></span> Editar
                            </a>
                            <form id="deleteForm-draft-{{ $paper->id }}"
                                action="{{ route('papers.destroy', $paper->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDeleteDraft('draft-{{ $paper->id }}')"
                                    class="px-3 py-1 bg-red-200 text-red-800 rounded-lg hover:bg-red-300 font-semibold flex items-center gap-1 shadow">
                                    <span class="iconify h-4 w-4" data-icon="mdi:trash-can"></span> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Filtros de ordenamiento -->
        <div class="flex flex-wrap items-center gap-2 overflow-x-auto py-1">
            <span class="text-sm font-medium text-gray-600 dark:text-gray-300 whitespace-nowrap">Ordenar por:</span>

            @foreach ($columns as $column)
                <a href="{{ route('papers', [
                    'sort' => $column['field'],
                    'direction' => $sortField === $column['field'] && $sortDirection === 'asc' ? 'desc' : 'asc',
                    'search' => request('search'),
                ]) }}"
                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium transition-colors duration-150 whitespace-nowrap border
                    {{ $sortField === $column['field']
                        ? 'border-[var(--primary-color)] bg-[var(--primary-color)] text-[var(--primary-text-color)] shadow-sm'
                        : 'text-gray-900 dark:text-gray-300 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    {{ $column['name'] }}
                    @if ($sortField === $column['field'])
                        <span class="ml-1">
                            @if ($sortDirection === 'asc')
                                <span class="iconify h-3 w-3 text-[var(--primary-text-color)] font-extrabold"
                                    data-icon="oui:arrow-up"></span>
                            @else
                                <span class="iconify h-3 w-3 text-[var(--primary-text-color)] font-extrabold"
                                    data-icon="oui:arrow-down"></span>
                            @endif
                        </span>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="flex md:hidden justify-center">
            {{ $papers->appends(request()->query())->links() }}
        </div>
        <!-- Contenedor grid responsive para documentos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
            @foreach ($papers as $paper)
                @php
                    $expirationDate = $paper->paper_date
                        ? \Carbon\Carbon::parse($paper->paper_date)->addDays($paper->paper_days)
                        : $paper->created_at->addDays($paper->paper_days);
                @endphp

                <details
                    class="relative bg-white dark:bg-gray-800 group rounded-lg transform transition-transform duration-200 hover:-translate-y-1 h-full paper-card open:bg-blue-50 dark:open:bg-gray-700 open:z-20"
                    id="paper-{{ $paper->id }}">

                    <summary class="list-none p-4 cursor-pointer h-full">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <!-- Icono de documento -->
                                <span class="iconify h-5 w-5 text-[var(--primary-color)]"
                                    data-icon="heroicons:document-text-20-solid"></span>
                                {{ $paper->paper_date ? \Carbon\Carbon::parse($paper->paper_date)->format('d/m/Y') : '' }}
                            </h3>
                            <!-- Flecha indicadora -->
                            <span class="iconify h-6 w-6 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                                data-icon="heroicons:chevron-down-20-solid" id="arrow-{{ $paper->id }}"></span>
                        </div>

                        <!-- Información básica -->
                        <div class="mt-auto space-y-1.5 text-sm">
                            <div class="flex items-center gap-2 text-gray-700 dark:text-gray-400">
                                <span class="iconify h-3.5 w-3.5" data-icon="heroicons:user-20-solid"></span>
                                <span>{{ $paper->customer->customer_name }}
                                    {{ $paper->customer->customer_lastname }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-gray-800 dark:text-gray-200">
                                    ${{ number_format($paper->paper_total_price, 2) }}
                                </span>
                                <span
                                    class="text-xs {{ $paper->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $paper->paper_days }} días
                                </span>
                            </div>
                        </div>
                    </summary>

                    <!-- Panel flotante con diseño integrado -->
                    <div class="bg-blue-50 dark:bg-gray-700 absolute left-0 right-0 z-10 mt-[-8px] rounded-b-lg shadow-xl">
                        <div class="w-[90%] border-t border-gray-300 m-auto mt-1 dark:border-gray-600"></div>
                        <div class="py-3 px-4 space-y-3 text-gray-700 dark:text-gray-400">
                            <!-- Lista de productos -->
                            <div class="space-y-2 max-h-[200px] overflow-y-auto">
                                @foreach ($paper->products as $product)
                                    <div class="p-2 bg-white dark:bg-gray-600 rounded-lg text-sm">
                                        <p class="font-medium text-gray-800 dark:text-gray-200">
                                            {{ $product->product_name }}</p>
                                        <div class="grid grid-cols-3 gap-2 text-xs mt-1">
                                            <div>
                                                <span class="text-gray-600 dark:text-gray-400">Cant:</span>
                                                <span class="font-medium">{{ $product->pivot->quantity }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600 dark:text-gray-400">P.Unit:</span>
                                                <span
                                                    class="font-medium">${{ number_format($product->pivot->unit_price, 2) }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                                <span
                                                    class="font-medium">${{ number_format($product->pivot->subtotal, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Estado y vencimiento -->
                            <div class="flex items-center justify-between text-sm">
                                <span class="flex items-center gap-2">
                                    <span class="iconify h-4 w-4" data-icon="heroicons:clock-20-solid"></span>
                                    {{ $expirationDate->diffForHumans() }}
                                </span>
                                <span
                                    class="{{ $paper->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' }} px-2 py-1 rounded-full text-xs">
                                    {{ $paper->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex justify-center gap-3 p-1">
                                <!-- Botón Copiar -->
                                <a href="{{ route('papers.create', ['copy_from' => $paper->id]) }}"
                                    class="p-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200 flex items-center justify-center"
                                    title="Copiar documento">
                                    <span class="iconify w-5 h-5" data-icon="iconamoon:copy-bold"></span>
                                </a>

                                <!-- Botón PDF SOLO MÓVIL (descarga directa) -->
                                <a href="{{ route('papers.pdf', ['paper' => $paper->id, 'download' => 1]) }}" download
                                    class="md:hidden p-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700 transition-all duration-200 flex items-center justify-center"
                                    title="Descargar PDF">
                                    <span class="iconify w-5 h-5" data-icon="mdi:download"></span>
                                </a>

                                <!-- Botón PDF SOLO ESCRITORIO -->
                                <a href="{{ route('papers.pdf', $paper) }}" target="_blank"
                                    class="p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 flex items-center justify-center"
                                    title="Generar PDF">
                                    <span class="iconify w-5 h-5" data-icon="carbon:document-pdf"></span>
                                </a>

                                <!-- Botón Editar -->
                                <a href="{{ route('papers.edit', $paper->id) }}"
                                    class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-200 flex items-center justify-center"
                                    title="Editar">
                                    <span class="iconify w-5 h-5" data-icon="heroicons:pencil-square-20-solid"></span>
                                </a>

                                @if (auth()->user()->isGerente())
                                    <!-- Botón Eliminar (solo gerente) -->
                                    <form id="deleteForm-{{ $paper->id }}"
                                        action="{{ route('papers.destroy', $paper->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $paper->id }}')"
                                            class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200 flex items-center justify-center"
                                            title="Eliminar">
                                            <span class="iconify w-5 h-5" data-icon="mdi:trash-can"></span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </details>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="flex justify-center">
            {{ $papers->appends(request()->query())->links() }}
        </div>
    @endsection

    @push('scripts')
        <script>
            // Manejar las cards de documentos
            document.addEventListener('DOMContentLoaded', () => {
                const allDetails = document.querySelectorAll('details.paper-card');
                allDetails.forEach(detail => {
                    detail.addEventListener('toggle', (e) => {
                        const paperId = detail.id.split('-')[1];
                        const arrow = document.getElementById(`arrow-${paperId}`);

                        if (detail.open) {
                            arrow.style.transform = 'rotate(180deg)';
                            allDetails.forEach(otherDetail => {
                                if (otherDetail !== detail && otherDetail.open) {
                                    otherDetail.open = false;
                                    const otherPaperId = otherDetail.id.split('-')[1];
                                    const otherArrow = document.getElementById(
                                        `arrow-${otherPaperId}`);
                                    otherArrow.style.transform = 'rotate(0deg)';
                                }
                            });
                        } else {
                            arrow.style.transform = 'rotate(0deg)';
                        }
                    });
                });
            });

            // Función de confirmación para eliminar
            function confirmDelete(paperId) {
                confirmAction({
                    title: '¿Eliminar documento?',
                    html: "<div class='text-sm text-gray-600 dark:text-gray-400'>Esta acción eliminará permanentemente el documento y no se podrá recuperar</div>",
                    icon: 'warning',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#ef4444',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`deleteForm-${paperId}`).submit();
                    }
                });
            }

            // Función de confirmación para eliminar borradores
            function confirmDeleteDraft(paperId) {
                confirmAction({
                    title: '¿Eliminar borrador?',
                    html: "<div class='text-sm text-gray-600 dark:text-gray-400'>¿Seguro que deseas eliminar este borrador? Puedes crear uno nuevo en cualquier momento.</div>",
                    icon: 'question',
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#fbbf24', // amarillo suave
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`deleteForm-${paperId}`).submit();
                    }
                });
            }
        </script>
    @endpush
