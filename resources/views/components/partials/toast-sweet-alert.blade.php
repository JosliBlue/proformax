<style scoped>
    .colored-toast.swal2-icon-success {
        background-color: #a5dc86 !important;
    }

    .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
    }

    .colored-toast.swal2-icon-warning {
        background-color: #f8bb86 !important;
    }

    .colored-toast.swal2-icon-info {
        background-color: #3fc3ee !important;
    }

    .colored-toast.swal2-icon-question {
        background-color: #87adbd !important;
    }

    /* Personalización del botón de cerrar (la "X") */
    .mi-boton-cerrar {
        color: #6b7280 !important;
        /* Color gris (similar a tu ejemplo original) */
        transition: all 0.3s !important;
        /* Transición suave */
    }

    /* Cambiar color al pasar el mouse */
    .mi-boton-cerrar:hover {
        color: #1f2937 !important;
        /* Color más oscuro (hover) */
        background-color: #f3f4f6 !important;
        /* Fondo gris claro al hover */
    }
</style>

<script>
    Swal.fire({
        // -------------------------------
        // PROPIEDADES BÁSICAS DEL TOAST
        // -------------------------------
        toast: true, // Obligatorio para modo toast
        title: '{{ $message }}', // Texto principal (puede usar HTML)
        //text: 'Texto adicional', // Subtítulo (opcional)
        width: 'auto', // <- Esto hace que el ancho se ajuste al contenido
        icon: '{{ $icon }}', // 'success', 'error', 'warning', 'info', 'question'
        padding: '1em 0.5em',
        target: document.body, // Contenedor donde se insertará (por defecto: body)

        // -------------------------------
        // POSICIONAMIENTO
        // -------------------------------
        position: 'bottom-end', // Opciones: 'top', 'top-start', 'top-end', 'center', 'bottom', 'bottom-start', 'bottom-end'
        grow: false, // Hace que el toast crezca hacia arriba o abajo (opciones: 'row', 'column', 'fullscreen', false)

        // -------------------------------
        // TEMPORIZADOR Y CIERRE
        // -------------------------------
        timer: 4000, // Duración en milisegundos (0 = infinito)
        timerProgressBar: true, // Muestra barra de progreso
        showConfirmButton: false, // Oculta el botón "OK"
        showCloseButton: true, // Muestra la "X" de cierre
        closeButtonHtml: `
        <span class="iconify" data-icon="streamline:delete-1-solid"></span>
        `,
        allowOutsideClick: false, // Si permite cerrar al hacer clic fuera
        allowEscapeKey: false, // Si permite cerrar con la tecla ESC

        // -------------------------------
        // ESTILOS Y COLORES
        // -------------------------------
        iconColor: 'white', // Color del ícono
        background: '#ffffff', // Fondo del toast
        color: '#000000', // Color del texto
        customClass: {
            popup: 'colored-toast', // Clase CSS para el toast
            title: 'mi-clase-titulo', // Clase para el título
            closeButton: 'mi-boton-cerrar' // Clase para la "X"
        },

        // -------------------------------
        // ANIMACIONES
        // -------------------------------
        animation: true, // Habilita animaciones
        showClass: {
            popup: 'swal2-show'
            //popup: 'animate__animated animate__fadeIn' // Usa Animate.css (ejemplo)
        },
        hideClass: {
            popup: 'swal2-hide' // Clase nativa
            //popup: 'animate__animated animate__fadeOut' // Animación al cerrar
        },

        // -------------------------------
        // CALLBACKS (FUNCIONES)
        // -------------------------------
        /*
        willOpen: () => {
            console.log('Toast se abrirá');
        },
        didClose: () => {
            console.log('Toast se cerró');
        }
        */
    });
    // LE PUEDES LINKEAR ESTO PARA LAS ANIMACIONES, PERO NO CAMBIA MUCHO AL MENOS QUE LE PROBE ASI RAPIDO RAPIDO
    // <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</script>
