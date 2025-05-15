@extends('appsita')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-5">
        <!-- Buscador -->
        <div class="w-full sm:w-auto">
            <form action="{{ route('papers') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full sm:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="iconify h-6 w-6 text-gray-500" data-icon="heroicons:magnifying-glass"></span>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar documentos..."
                        class="w-full pl-12 pr-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                </div>

                <div class="flex gap-3 w-full sm:w-auto">
                    <button type="submit"
                        class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-4 py-2.5 rounded-lg w-full sm:w-auto transition-all duration-200">
                        Buscar
                    </button>

                    @if (request('search'))
                        <a href="{{ route('papers') }}"
                            class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--primary-color)] text-[var(--primary-text-color)] hover:bg-opacity-90 px-4 py-2.5 rounded-lg w-full sm:w-auto transition-all duration-200">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Botón Nuevo Documento -->
        <a href="{{ route('papers.create') }}"
            class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-5 py-2.5 rounded-lg w-full sm:w-auto transition-all duration-200">
            <span>Nuevo documento</span>
        </a>
    </div>

    <!-- Contenedor grid responsive -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
        @foreach ($papers as $paper)
            @php
                $expirationDate = $paper->created_at->addDays($paper->paper_days);
            @endphp

            <div class="relative group">
                <!-- Tarjeta principal - toda clickeable -->
                <div
                    class="bg-white md:bg-gray-100 dark:bg-gray-800 dark:md:bg-gray-700 rounded-lg shadow-md overflow-hidden transition-all duration-200 hover:shadow-xl group-[.active]:rounded-b-none">
                    <button class="paper-toggle w-full text-left p-4">
                        <div class="flex items-start gap-3">
                            <!-- Icono -->
                            <div class="p-2 rounded-lg flex-shrink-0 bg-[var(--primary-color)]">
                                <span class="iconify h-5 w-5 text-[var(--primary-text-color)]"
                                    data-icon="heroicons:document-text-20-solid"></span>
                            </div>

                            <!-- Info principal -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $paper->created_at->format('d/m/Y') }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                    {{ $paper->customer->customer_name }} {{ $paper->customer->customer_lastname }}
                                </p>
                                <div class="mt-1 flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                        ${{ number_format($paper->paper_total_price, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Columna derecha: días arriba, estado abajo -->
                            <div class="flex flex-col justify-between items-end min-h-[65px] h-full">
                                <!-- Días -->
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $paper->paper_days }} días
                                </span>

                                <!-- Estado -->
                                @if ($paper->is_active)
                                    <span
                                        class="inline-flex items-center mt-2 px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                        {{ $expirationDate->diffForHumans() }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center mt-2 px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200">
                                        {{ $expirationDate->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </button>
                </div>

                <!-- Panel flotante -->
                <div
                    class="bg-white md:bg-gray-100 dark:bg-gray-800 dark:md:bg-gray-700 absolute left-0 right-0 z-10 hidden group-[.active]:block rounded-b-lg shadow-lg border-t border-gray-200 dark:border-gray-700 mt-[-1px]">
                    <div class="p-4 space-y-3">
                        <div class="space-y-2 max-h-[300px] overflow-y-auto">
                            <!-- Tus elementos aquí -->

                            @foreach ($paper->products as $product)
                                <div class="flex items-start gap-2 p-2 bg-gray-50 dark:bg-gray-700/30 rounded text-sm">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-gray-800 dark:text-gray-200">{{ $product->product_name }}</p>
                                        <div class="grid grid-cols-3 gap-2 text-xs mt-1">
                                            <div class="text-gray-600 dark:text-gray-400">
                                                <span class="font-medium">Cant:</span> {{ $product->pivot->quantity }}
                                            </div>
                                            <div class="text-gray-600 dark:text-gray-400">
                                                <span class="font-medium">P.Unit:</span>
                                                ${{ number_format($product->pivot->unit_price, 2) }}
                                            </div>
                                            <div class="text-gray-600 dark:text-gray-400">
                                                <span class="font-medium">Subtotal:</span>
                                                ${{ number_format($product->pivot->subtotal, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-center gap-3 pt-2">
                            <a href="{{ route('papers.edit', $paper->id) }}"
                                class="p-1.5 bg-green-500 text-white rounded-lg hover:bg-green-600"
                                title="Nuevo a partir de este">
                                <span class="iconify h-6 w-6" data-icon="iconamoon:copy-bold"></span>
                            </a>
                            <a href="" class="p-1.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                                title="PDF">
                                <span class="iconify h-6 w-6" data-icon="carbon:document-pdf"></span>
                            </a>
                            <a href="{{ route('papers.edit', $paper->id) }}"
                                class="p-1.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600" title="Editar">
                                <span class="iconify h-6 w-6" data-icon="heroicons:pencil-square-20-solid"></span>
                            </a>

                            <form action="{{ route('papers.destroy', $paper->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700"
                                    title="Eliminar" onclick="return confirm('¿Eliminar documento?')">
                                    <span class="iconify h-6 w-6" data-icon="heroicons:trash-20-solid"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Paginación -->
    @if ($papers->hasPages())
        <div class="flex justify-center mt-6">
            {{ $papers->appends(request()->query())->links() }}
        </div>
    @endif

    @push('scripts')
        <script>
            document.querySelectorAll('.paper-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const card = this.closest('.relative');

                    // Cerrar todos los demás primero
                    document.querySelectorAll('.relative').forEach(otherCard => {
                        if (otherCard !== card) {
                            otherCard.classList.remove('active');
                        }
                    });

                    // Alternar el actual
                    card.classList.toggle('active');
                });
            });

            // Cerrar al hacer clic fuera
            document.addEventListener('click', function() {
                document.querySelectorAll('.relative').forEach(card => {
                    card.classList.remove('active');
                });
            });
        </script>
    @endpush
@endsection
