@push('scripts')
    <script>
        // Configuración base para todas las alertas
        const alertDefaults = {
            background: '#ffffff',
            color: 'var(--mi-oscuro)',
            customClass: {
                popup: '!bg-white dark:!bg-[var(--mi-oscuro)] !rounded-lg !shadow-xl',
                title: '!text-[var(--mi-oscuro)] dark:!text-white !font-semibold !text-lg',
                htmlContainer: '!text-[var(--mi-oscuro)] dark:!text-gray-300 !text-base',
                confirmButton: '!bg-[var(--primary-color)] hover:!bg-[var(--primary-color)]/90 dark:!bg-[var(--secondary-color)] dark:hover:!bg-[var(--secondary-color)]/90 !text-[var(--primary-text-color)] dark:!text-[var(--secondary-text-color)] !px-5 !py-2.5 !rounded-lg !transition-all !duration-200',
                cancelButton: '!bg-gray-500 hover:!bg-gray-600 !text-white !px-5 !py-2.5 !text-base !rounded-lg !transition-all !duration-200',
                footer: '!border-t-2 !border-gray-200 dark:!border-gray-800'
            }
        };

        // Función global para mostrar alertas
        window.showAlert = function(options) {
            return Swal.fire({
                ...alertDefaults,
                ...options
            });
        };

        // Función para confirmaciones con icono de SweetAlert
        window.confirmAction = function(options) {
            return showAlert({
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                icon: options.icon || 'question', // Icono de SweetAlert por defecto
                ...options
            });
        };
    </script>
@endpush
