export const initImageUpload = () => {
    // Funciones para manejar el almacenamiento temporal
    const saveToLocalStorage = (key, data) => {
        try {
            localStorage.setItem(key, data);
        } catch (e) {
            console.error('Error saving to localStorage:', e);
        }
    };

    const getFromLocalStorage = (key) => {
        try {
            return localStorage.getItem(key);
        } catch (e) {
            console.error('Error reading from localStorage:', e);
            return null;
        }
    };

    const clearLocalStorage = () => {
        try {
            localStorage.removeItem('thumbnailImage');
            localStorage.removeItem('additionalImages');
        } catch (e) {
            console.error('Error clearing localStorage:', e);
        }
    };

    const handleThumbnailUpload = (input) => {
        const preview = document.getElementById('thumbnail-preview');
        const placeholder = document.getElementById('thumbnail-placeholder');
        const removeBtn = document.getElementById('remove-thumbnail');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                removeBtn.classList.remove('hidden');

                // Guardar en localStorage
                saveToLocalStorage('thumbnailImage', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    };

    const removeThumbnail = () => {
        const input = document.getElementById('thumbnail');
        const preview = document.getElementById('thumbnail-preview');
        const placeholder = document.getElementById('thumbnail-placeholder');
        const removeBtn = document.getElementById('remove-thumbnail');

        input.value = '';
        preview.src = '';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');

        // Eliminar de localStorage
        localStorage.removeItem('thumbnailImage');
    };

    const handleAdditionalImages = (input) => {
        const previewGrid = document.getElementById('preview-grid');
        const savedImages = [];
        previewGrid.innerHTML = '';

        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = createImagePreviewElement(e.target.result, index);
                    previewGrid.appendChild(div);
                    savedImages.push(e.target.result);

                    // Guardar en localStorage cuando todas las imágenes estén cargadas
                    if (savedImages.length === input.files.length) {
                        saveToLocalStorage('additionalImages', JSON.stringify(savedImages));
                    }
                };
                reader.readAsDataURL(file);
            });
        }
    };

    const createImagePreviewElement = (imageUrl, index) => {
        const div = document.createElement('div');
        div.className = 'relative aspect-square';
        div.innerHTML = `
            <img src="${imageUrl}" class="w-full h-full object-cover rounded-lg">
            <button type="button"
                    class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-sm hover:bg-gray-100 remove-image"
                    data-index="${index}">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;

        const removeButton = div.querySelector('.remove-image');
        removeButton.addEventListener('click', () => removeAdditionalImage(removeButton, index));

        return div;
    };

    const removeAdditionalImage = (button, index) => {
        const container = button.closest('.aspect-square');
        const input = document.getElementById('additional-images');
        const dt = new DataTransfer();

        // Actualizar el input file
        Array.from(input.files).forEach((file, i) => {
            if (i !== index) dt.items.add(file);
        });
        input.files = dt.files;

        // Actualizar localStorage
        const savedImages = JSON.parse(getFromLocalStorage('additionalImages') || '[]');
        savedImages.splice(index, 1);
        saveToLocalStorage('additionalImages', JSON.stringify(savedImages));

        container.remove();
    };

    // Función para restaurar imágenes del localStorage
    const restoreImagesFromStorage = () => {
        // Restaurar thumbnail
        const thumbnailData = getFromLocalStorage('thumbnailImage');
        if (thumbnailData) {
            const preview = document.getElementById('thumbnail-preview');
            const placeholder = document.getElementById('thumbnail-placeholder');
            const removeBtn = document.getElementById('remove-thumbnail');

            preview.src = thumbnailData;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            removeBtn.classList.remove('hidden');
        }

        // Restaurar imágenes adicionales
        const additionalImagesData = JSON.parse(getFromLocalStorage('additionalImages') || '[]');
        if (additionalImagesData.length > 0) {
            const previewGrid = document.getElementById('preview-grid');
            previewGrid.innerHTML = '';
            additionalImagesData.forEach((imageUrl, index) => {
                const div = createImagePreviewElement(imageUrl, index);
                previewGrid.appendChild(div);
            });
        }
    };

    // Event Listeners
    const setupEventListeners = () => {
        const thumbnailInput = document.getElementById('thumbnail');
        const thumbnailPreviewArea = document.getElementById('thumbnail-preview-area');
        const removeThumbnailBtn = document.getElementById('remove-thumbnail');
        const dropZone = document.getElementById('drop-zone');
        const additionalImagesInput = document.getElementById('additional-images');
        const form = document.querySelector('form');

        if (thumbnailPreviewArea) {
            thumbnailPreviewArea.addEventListener('click', () => thumbnailInput.click());
        }

        if (thumbnailInput) {
            thumbnailInput.addEventListener('change', (e) => handleThumbnailUpload(e.target));
        }

        if (removeThumbnailBtn) {
            removeThumbnailBtn.addEventListener('click', removeThumbnail);
        }

        if (dropZone && additionalImagesInput) {
            dropZone.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                additionalImagesInput.click();
            });

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-primary-500');
            });

            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-primary-500');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-primary-500');

                const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
                if (files.length > 0) {
                    const dt = new DataTransfer();
                    files.forEach(file => dt.items.add(file));
                    additionalImagesInput.files = dt.files;
                    handleAdditionalImages(additionalImagesInput);
                }
            });
        }

        if (additionalImagesInput) {
            additionalImagesInput.addEventListener('change', (e) => handleAdditionalImages(e.target));
        }

        // Limpiar localStorage cuando el formulario se envía exitosamente
        if (form) {
            form.addEventListener('submit', () => {
                // Guardamos el estado actual por si hay error
                const currentState = {
                    thumbnail: getFromLocalStorage('thumbnailImage'),
                    additionalImages: getFromLocalStorage('additionalImages')
                };

                // Almacenamos temporalmente en una key diferente
                saveToLocalStorage('tempFormState', JSON.stringify(currentState));
                clearLocalStorage();
            });
        }
    };

    // Restaurar imágenes si hay errores de validación
    const hasValidationErrors = document.querySelector('.alert-danger') ||
        document.querySelectorAll('[class*="text-red-"]').length > 0;

    if (hasValidationErrors) {
        const tempState = JSON.parse(getFromLocalStorage('tempFormState') || '{}');
        if (tempState.thumbnail) {
            saveToLocalStorage('thumbnailImage', tempState.thumbnail);
        }
        if (tempState.additionalImages) {
            saveToLocalStorage('additionalImages', tempState.additionalImages);
        }
        localStorage.removeItem('tempFormState');
    }

    // Inicializar
    setupEventListeners();
    restoreImagesFromStorage();
};
