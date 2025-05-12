// editProperty.js - Script específico para la página de edición de propiedades
document.addEventListener('DOMContentLoaded', function() {
    console.log('editProperty.js loaded successfully');

    // No inicializar el mapa aquí, ya que createPropertie.js lo hace

    // Otras funciones específicas de la página de edición
    // Manejar eliminación de imágenes existentes
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
