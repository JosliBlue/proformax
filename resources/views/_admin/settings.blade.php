@extends('appsita')

@section('content')
    <!-- Título con flecha de retroceso (única tarjeta) -->
    <div class="flex items-center gap-3 bg-white rounded-lg p-2 md:p-3 dark:bg-gray-800 shadow-sm mb-6">
        <a href="{{ route('home') }}" class="flex items-center text-[var(--primary-color)] group focus:outline">
            <span class="iconify h-6 w-6 group-hover:-translate-x-1 transition-transform duration-200"
                data-icon="heroicons:arrow-left-20-solid"></span>
        </a>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Configuración de la Empresa
        </h1>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sección de Información General -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <span class="iconify h-5 w-5 text-[var(--primary-color)]"
                        data-icon="heroicons:building-office-20-solid"></span>
                    Información General
                </h3>
                <!-- Logo de la Empresa -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Logo de la Empresa
                    </p>

                    <!-- Contenedor principal con grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Preview del logo actual (mitad derecha) -->
                        @if ($company->company_logo_path)
                            <div class="flex flex-col items-center justify-center">
                                <div class="relative">
                                    <img src="{{ $company->logo_url }}" alt="{{ $company->company_name }}"
                                        class="h-32 border rounded-lg shadow-sm">
                                </div>

                            </div>
                        @endif
                        <!-- Área de carga de archivos (mitad izquierda) -->
                        <div id="file-upload-container">
                            <label
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 relative">
                                <input id="company_logo" name="company_logo" type="file"
                                    accept=".jpg,.jpeg,.png,.gif,.webp" class="hidden" />
                                <div id="upload-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <span class="iconify h-8 w-8 mb-3 text-gray-500 dark:text-gray-400"
                                        data-icon="heroicons:photo-20-solid"></span>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">Haz clic si quieres subir un
                                        nuevo logo</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG o WEBP</p>
                                </div>
                                <div id="file-selected-message"
                                    class="absolute inset-0 hidden flex-col items-center justify-center bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                    <span class="iconify h-8 w-8 mb-2 text-green-500"
                                        data-icon="heroicons:check-circle-20-solid"></span>
                                    <p class="text-sm font-medium text-green-700 dark:text-green-300">Archivo seleccionado
                                    </p>
                                    <p id="file-name" class="text-xs text-green-600 dark:text-green-400 mt-1 text-center">
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>
                    @error('company_logo')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Nombre de la Empresa -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nombre de la Empresa *
                    </label>
                    <input type="text" name="company_name" id="company_name"
                        value="{{ old('company_name', $company->company_name) }}" required
                        class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sección de Esquema de Colores -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <span class="iconify h-5 w-5 text-[var(--primary-color)]" data-icon="heroicons:swatch-20-solid"></span>
                    Esquema de Colores
                </h3>

                <!-- Color Primario -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label for="company_primary_color"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Color Primario *
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" id="company_primary_color" name="company_primary_color"
                            value="{{ old('company_primary_color', $company->company_primary_color) }}"
                            class="h-12 w-12 rounded-lg cursor-pointer shadow-md hover:shadow-lg transition-shadow duration-200">
                        <div class="flex-1">
                            <input type="text" id="company_primary_color_text"
                                value="{{ old('company_primary_color', $company->company_primary_color) }}"
                                class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                                oninput="document.getElementById('company_primary_color').value = this.value">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Ejemplo: #3B82F6</p>
                        </div>
                    </div>
                    @error('company_primary_color')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color Secundario -->
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label for="company_secondary_color"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Color Secundario *
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" id="company_secondary_color" name="company_secondary_color"
                            value="{{ old('company_secondary_color', $company->company_secondary_color) }}"
                            class="h-12 w-12 rounded-lg cursor-pointer shadow-md hover:shadow-lg transition-shadow duration-200">
                        <div class="flex-1">
                            <input type="text" id="company_secondary_color_text"
                                value="{{ old('company_secondary_color', $company->company_secondary_color) }}"
                                class="w-full px-4 py-3 text-base border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                                oninput="document.getElementById('company_secondary_color').value = this.value">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Ejemplo: #10B981</p>
                        </div>
                    </div>
                    @error('company_secondary_color')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="pt-4 md:pt-0 flex justify-end gap-3">
            <button type="submit"
                class="hover:brightness-125 flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-6 py-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                <span class="iconify h-5 w-5" data-icon="heroicons:check-20-solid"></span>
                Guardar Cambios
            </button>
        </div>
    </form>
@endsection
@push('scripts')
    <script>
        // Sincronizar los campos de texto con los selectores de color
        document.addEventListener('DOMContentLoaded', function() {
            // Para el color primario
            document.getElementById('company_primary_color').addEventListener('input', function() {
                document.getElementById('company_primary_color_text').value = this.value;
            });

            // Para el color secundario
            document.getElementById('company_secondary_color').addEventListener('input', function() {
                document.getElementById('company_secondary_color_text').value = this.value;
            });

            // Mostrar feedback cuando se selecciona un archivo
            document.getElementById('company_logo').addEventListener('change', function(e) {
                const fileInput = e.target;
                const fileName = fileInput.files[0]?.name || '';
                const placeholder = document.getElementById('upload-placeholder');
                const fileSelectedMsg = document.getElementById('file-selected-message');
                const fileNameElement = document.getElementById('file-name');

                if (fileInput.files.length > 0) {
                    placeholder.classList.add('hidden');
                    fileSelectedMsg.classList.remove('hidden');
                    fileSelectedMsg.classList.add('flex'); // Añadimos flex cuando mostramos el elemento
                    fileNameElement.textContent = fileName;
                } else {
                    placeholder.classList.remove('hidden');
                    fileSelectedMsg.classList.remove('flex'); // Quitamos flex cuando ocultamos el elemento
                    fileSelectedMsg.classList.add('hidden');
                    fileNameElement.textContent = '';
                }
            });
        });
    </script>
@endpush
