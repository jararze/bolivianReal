// editProperty.js - Script específico para la página de edición de propiedades
document.addEventListener('DOMContentLoaded', function() {
    console.log('editProperty.js loaded successfully');

    // No inicializar el mapa aquí, ya que createPropertie.js lo hace

    const form = document.querySelector('form');

    if (form) {
        form.addEventListener('submit', function(e) {
            // Limpiar campos de servicios vacíos antes del envío
            cleanEmptyServiceRows();
        });
    }

    // Función para limpiar filas de servicios vacías
    function cleanEmptyServiceRows() {
        const serviceRows = document.querySelectorAll('.service-row');

        serviceRows.forEach(function(row) {
            const featureSelect = row.querySelector('select[name="features[]"]');
            const nameInput = row.querySelector('input[name="place_names[]"]');
            const distanceInput = row.querySelector('input[name="distances[]"]');

            // Si el select está vacío, eliminar toda la fila del DOM
            if (!featureSelect || !featureSelect.value || featureSelect.value === '') {
                row.remove();
            }
        });
    }

    document.addEventListener('click', function(e) {
        // Botón para agregar servicio
        if (e.target.closest('.add-service')) {
            e.preventDefault();

            const container = document.getElementById('services-container');
            if (!container) return;

            const serviceRows = container.querySelectorAll('.service-row');

            // Verificar si la última fila está completa antes de agregar una nueva
            if (serviceRows.length > 0) {
                const lastRow = serviceRows[serviceRows.length - 1];
                const lastSelect = lastRow.querySelector('select[name="features[]"]');

                if (!lastSelect || !lastSelect.value || lastSelect.value === '') {
                    alert('Por favor complete el servicio actual antes de agregar uno nuevo.');
                    return;
                }
            }

            // Clonar la primera fila
            if (serviceRows.length > 0) {
                const newRow = serviceRows[0].cloneNode(true);

                // Resetear valores
                newRow.querySelectorAll('input, select').forEach(input => {
                    if (input.type === 'text' || input.tagName === 'SELECT') {
                        input.value = '';
                    }
                });

                // Cambiar botón de agregar por botón de eliminar
                const addButton = newRow.querySelector('.add-service');
                if (addButton) {
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'p-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-service';
                    removeButton.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    `;

                    addButton.parentNode.replaceChild(removeButton, addButton);
                }

                container.appendChild(newRow);
            }
        }

        // Botón para quitar servicio
        if (e.target.closest('.remove-service')) {
            e.preventDefault();
            const serviceRow = e.target.closest('.service-row');
            if (serviceRow) {
                serviceRow.remove();
            }
        }
    });

    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function() {
            const container = this.closest('.image-container');
            const imageId = container.dataset.imageId;
            const input = container.querySelector('.delete-image-input');

            // Marcar para eliminación
            input.value = '1';
            // Mostrar visualmente que será eliminada
            container.classList.add('opacity-50');
            this.classList.add('bg-green-500');
            this.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';

            // Permitir restaurar la imagen
            this.classList.remove('delete-image');
            this.classList.add('restore-image');

            // Agregar evento para restaurar
            this.addEventListener('click', function() {
                input.value = '0';
                container.classList.remove('opacity-50');
                this.classList.remove('bg-green-500');
                this.classList.add('bg-red-500');
                this.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

                this.classList.remove('restore-image');
                this.classList.add('delete-image');
            }, { once: true });
        });
    });



});
