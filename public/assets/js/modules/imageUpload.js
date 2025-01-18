export const initImageUpload = () => {
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
    };

    // Manejo de imágenes múltiples
    const handleAdditionalImages = (input) => {
        const previewGrid = document.getElementById('preview-grid');
        previewGrid.innerHTML = ''; // Limpiar el grid antes de agregar nuevas imágenes

        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = createImagePreviewElement(e.target.result, index);
                    previewGrid.appendChild(div);
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

        // Agregar event listener para el botón de eliminar
        const removeButton = div.querySelector('.remove-image');
        removeButton.addEventListener('click', () => removeAdditionalImage(removeButton, index));

        return div;
    };

    const removeAdditionalImage = (button, index) => {
        const container = button.closest('.aspect-square');
        const input = document.getElementById('additional-images');
        const dt = new DataTransfer();

        Array.from(input.files).forEach((file, i) => {
            if (i !== index) dt.items.add(file);
        });

        input.files = dt.files;
        container.remove();
    };

    // Event Listeners
    const setupEventListeners = () => {
        // Para imagen principal
        const thumbnailInput = document.getElementById('thumbnail');
        const thumbnailPreviewArea = document.getElementById('thumbnail-preview-area');
        const removeThumbnailBtn = document.getElementById('remove-thumbnail');

        const dropZone = document.getElementById('drop-zone');
        const additionalImagesInput = document.getElementById('additional-images');

        if (thumbnailPreviewArea) {
            thumbnailPreviewArea.addEventListener('click', () => {
                thumbnailInput.click();
            });
        }

        if (thumbnailInput) {
            thumbnailInput.addEventListener('change', (e) => handleThumbnailUpload(e.target));
        }

        if (removeThumbnailBtn) {
            removeThumbnailBtn.addEventListener('click', removeThumbnail);
        }

        // Para imágenes adicionales


        console.log('Drop Zone:', dropZone);
        console.log('Additional Images Input:', additionalImagesInput);

        if (dropZone && additionalImagesInput) {
            // Prevent the click handler from being added multiple times
            dropZone.removeEventListener('click', dropZoneClickHandler);
            dropZone.addEventListener('click', dropZoneClickHandler);

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
    };

    const dropZoneClickHandler = (e) => {
        e.preventDefault();
        e.stopPropagation();
        const additionalImagesInput = document.getElementById('additional-images');
        if (additionalImagesInput) {
            additionalImagesInput.click();
        }
    };

    // Inicializar
    setupEventListeners();
};
