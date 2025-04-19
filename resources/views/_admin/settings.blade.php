@extends('appsita')

@section('content')
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información General -->
            <div
                class="bg-white md:bg-gray-100 dark:bg-gray-800 dark:md:bg-gray-700 rounded-lg shadow-sm p-5 border dark:border-none">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Información General</h3>

                <!-- Nombre de la Empresa -->
                <div class="mb-4">
                    <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nombre de la Empresa *
                    </label>
                    <input type="text" name="company_name" id="company_name"
                        value="{{ old('company_name', $company->company_name) }}" required
                        class="w-full px-4 py-2 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200">
                </div>

                <!-- Logo de la Empresa -->
                <div>
                    <label for="company_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Logo de la Empresa
                    </label>
                    <input type="file" name="company_logo" id="company_logo" accept=".jpg,.jpeg,.png,.gif,.webp"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0 file:text-sm file:font-semibold
                            file:bg-[var(--primary-color)] file:text-[var(--primary-text-color)] cursor-pointer">

                    @if ($company->company_logo_path)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Logo actual:</p>
                            <img src="{{ $company->logo_url }}" alt="{{ $company->company_name }}"
                                class="max-h-32 border rounded-md shadow-sm">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Esquema de Colores -->
            <div
                class="bg-white md:bg-gray-100 dark:bg-gray-800 dark:md:bg-gray-700 rounded-lg shadow-sm p-5 border dark:border-none">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Esquema de Colores</h3>

                <!-- Color Primario -->
                <div class="mb-6">
                    <label for="company_primary_color"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Color Primario *
                    </label>
                    <div class="flex space-x-2">
                        <input type="color" id="company_primary_color" name="company_primary_color"
                            value="{{ old('company_primary_color', $company->company_primary_color) }}"
                            class="h-10 w-10 rounded-lg cursor-pointer">
                        <input type="text" id="company_primary_color_text"
                            value="{{ old('company_primary_color', $company->company_primary_color) }}"
                            class="w-full px-4 py-2 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                            oninput="document.getElementById('company_primary_color').value = this.value">
                    </div>
                </div>

                <!-- Color Secundario -->
                <div>
                    <label for="company_secondary_color"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Color Secundario *
                    </label>
                    <div class="flex space-x-2">
                        <input type="color" id="company_secondary_color" name="company_secondary_color"
                            value="{{ old('company_secondary_color', $company->company_secondary_color) }}"
                            class="h-10 w-10 rounded-lg  cursor-pointer">
                        <input type="text" id="company_secondary_color_text"
                            value="{{ old('company_secondary_color', $company->company_secondary_color) }}"
                            class="w-full px-4 py-2 border border-[var(--primary-color)] dark:border-[var(--secondary-color)] rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] dark:focus:ring-[var(--secondary-color)] transition-all duration-200"
                            oninput="document.getElementById('company_secondary_color').value = this.value">
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="pt-4 flex justify-end space-x-3">
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 text-base bg-[var(--secondary-color)] text-[var(--secondary-text-color)] hover:bg-opacity-90 px-5 py-2.5 rounded-lg transition-all duration-200">
                Guardar Cambios
            </button>
        </div>
    </form>


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
            });
        </script>
    @endpush
@endsection
