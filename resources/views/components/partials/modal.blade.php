<div id="modal"
    class="bg-black/60 fixed inset-0 z-2 flex items-center justify-center invisible opacity-0 transition-all duration-300 backdrop-blur-sm target:visible target:opacity-100">

    <div
        class="mx-4 bg-white p-6 rounded-lg shadow-2xl shadow-black/50 max-w-md w-full relative z-10 border border-gray-200/50">
        <!-- Título del modal -->
        <h2 class="text-xl font-bold mb-4 text-gray-800">{{ $title ?? 'Título del modal' }}</h2>

        <!-- Contenido principal -->
        <div class="mb-4 text-gray-600">
            {{ $content }}
        </div>

        <!-- Botón de cerrar con mejor contraste -->
        <a href="#"
            class="absolute top-6 right-4 text-gray-500 hover:text-gray-700 transition-colors duration-200 hover:scale-110">
            <span class="iconify text-2xl" data-icon="streamline:delete-1-solid"></span>
        </a>
    </div>
</div>
