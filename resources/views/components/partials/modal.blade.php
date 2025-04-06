@push('styles')
    <style>
        .modal {
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .modal.show {
            opacity: 1;
            pointer-events: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            opacity: 0;
            transform: translateY(-20px);
            transition: all 0.3s ease;
        }

        .modal.show .modal-content {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endpush

<div id="{{ $modalId }}" class="modal fixed inset-0 z-50 hidden overflow-auto">
    <div class="modal-content  md:max-w-lg mx-4 md:mx-auto my-10 p-4 relative bg-white rounded-lg shadow-lg">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">{{ $title }}</h3>

            <button class="modal-close text-gray-500 text-2xl">
                <span class="iconify w-4 h-4 text-black cursor-pointer" data-icon="streamline:delete-1-solid"></span>
            </button>
        </div>

        <div class="modal-body py-4">
            {{ $slot }}
        </div>

    </div>
</div>

@push('scripts')
    <script>
        class ModalManager {
            constructor() {
                this.modals = [...document.querySelectorAll('.modal')].reduce((acc, el) => {
                    acc[el.id] = el;
                    return acc;
                }, {});
                this.bindEvents();
            }

            bindEvents() {
                document.querySelectorAll('[data-modal-toggle]').forEach(btn =>
                    btn.addEventListener('click', () => this.toggle(btn.dataset.modalToggle, true)));

                document.querySelectorAll('.modal-close').forEach(btn =>
                    btn.addEventListener('click', () =>
                        this.toggle(btn.closest('.modal')?.id, false)));

                document.addEventListener('click', e => {
                    if (e.target.classList.contains('modal')) this.toggle(e.target.id, false);
                });

                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') this.closeAll();
                });
            }

            toggle(id, show) {
                const modal = this.modals[id];
                if (!modal) return;

                if (show) {
                    modal.classList.remove('hidden');
                    // Esperamos dos frames para asegurar el reflow y aplicar transición
                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            modal.classList.add('show');
                        });
                    });
                    document.body.style.overflow = 'hidden';
                } else {
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }, 300); // duración igual a la del CSS
                }
            }
            closeAll() {
                Object.keys(this.modals).forEach(id => this.toggle(id, false));
            }
        }

        document.addEventListener('DOMContentLoaded', () => window.Modal = new ModalManager());
    </script>
@endpush
