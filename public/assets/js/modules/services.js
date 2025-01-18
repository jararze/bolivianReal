export const initServices = () => {
    const container = document.getElementById('services-container');
    if (!container) return;

    const addServiceRow = () => {
        // Get original elements to clone styles
        const originalSelect = document.querySelector('select[name="features[]"]');
        const originalInput = document.querySelector('input[name="place_names[]"]');

        if (!originalSelect || !originalInput) return;

        const newRow = document.createElement('div');
        newRow.className = 'service-row grid grid-cols-12 gap-4 items-start';

        newRow.innerHTML = `
            <div class="col-span-4">
                <select name="features[]" class="${originalSelect.className}">
                    ${originalSelect.innerHTML}
                </select>
            </div>
            <div class="col-span-4">
                <input type="text"
                       name="place_names[]"
                       class="${originalInput.className}"
                       placeholder="Nombre del servicio">
            </div>
            <div class="col-span-3">
                <input type="text"
                       name="distances[]"
                       class="${originalInput.className}"
                       placeholder="Distancia (Cuadras)">
            </div>
            <div class="col-span-1 flex space-x-1">
                <button type="button"
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-success text-white hover:bg-success-dark add-service">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
                <button type="button"
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-danger text-white hover:bg-danger-dark remove-service">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"/>
                    </svg>
                </button>
            </div>
        `;

        container.appendChild(newRow);
        attachEventListeners(newRow);
    };

    const removeServiceRow = (button) => {
        const row = button.closest('.service-row');
        if (container.children.length > 1) {
            row.remove();
        }
    };

    const attachEventListeners = (row) => {
        const addButton = row.querySelector('.add-service');
        const removeButton = row.querySelector('.remove-service');

        if (addButton) {
            addButton.addEventListener('click', addServiceRow);
        }
        if (removeButton) {
            removeButton.addEventListener('click', function() {
                removeServiceRow(this);
            });
        }
    };

    // Initialize event listeners on existing rows
    document.querySelectorAll('.service-row').forEach(row => {
        attachEventListeners(row);
    });
};
