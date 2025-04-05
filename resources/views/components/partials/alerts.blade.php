<div x-data="{
    show: @js($show),
    autoclose: @js($autoclose),
    init() {
        // Iniciar auto-cierre si es necesario
        if (this.show && this.autoclose > 0) {
            setTimeout(() => {
                this.show = false;
                @this.dismiss();
            }, this.autoclose);
        }

        // Escuchar eventos de Livewire
        Livewire.on('startAutoClose', (duration) => {
            setTimeout(() => {
                this.show = false;
                @this.dismiss();
            }, duration);
        });
    }
}" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-4" @class([
        'fixed z-1 w-full max-w-sm right-4 md:right-20' => $floating,
        'block' => !$floating,
    ])
    wire:key="alert-{{ $type }}-{{ time() }}">
    @if ($show)
        @php
            // Definir clases según el tipo de alerta (tu código actual)
            $classes = [
                'info' => [
                    'text' => 'text-blue-800 dark:text-blue-400',
                    'border' => 'border-blue-300 dark:border-blue-800',
                    'bg' => 'bg-blue-50 dark:bg-gray-800',
                    'button' => 'text-blue-500 hover:bg-blue-200 dark:text-blue-400 dark:hover:bg-gray-700',
                ],
                // ... (otros tipos de alerta)
            ];

            $currentClass = $classes[$type] ?? $classes['info'];
        @endphp

        <div id="alert-{{ $type }}"
            class="flex items-center p-4 mb-4 border-t-4 rounded-lg shadow-lg {{ $currentClass['text'] }} {{ $currentClass['border'] }} {{ $currentClass['bg'] }}"
            role="alert" x-ref="alert">
            <!-- Icono SVG -->
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>

            <!-- Mensaje -->
            <div class="ms-3 text-sm font-medium">
                {!! $message !!}
                @if ($link && $linkText)
                    <a href="{{ $link }}"
                        class="font-semibold underline hover:no-underline">{{ $linkText }}</a>
                @endif
            </div>

            <!-- Botón para cerrar -->
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 {{ $currentClass['bg'] }} {{ $currentClass['button'] }} rounded-lg focus:ring-2 focus:ring-{{ $type }}-400 p-1.5 inline-flex items-center justify-center h-8 w-8"
                aria-label="Close" @click="show = false; $wire.dismiss()">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif
</div>
