// Crear el HTML del modal de carga
const createLoadingModal = () => {
    const modal = document.createElement('div');
    modal.className = 'loading-overlay';
    modal.id = 'loadingModal';
    modal.innerHTML = `
        <div class="loading-spinner-container">
            <svg class="spinner-loader h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div class="loading-text">Procesando...</div>
        </div>
    `;
    return modal;
};

// Mostrar el modal de carga
const showLoadingModal = () => {
    const modal = document.getElementById('loadingModal');
    if (modal) {
        modal.style.display = 'flex';
        // Prevenir scroll del body
        document.body.style.overflow = 'hidden';
    }
};

// Ocultar el modal de carga
const hideLoadingModal = () => {
    const modal = document.getElementById('loadingModal');
    if (modal) {
        modal.style.display = 'none';
        // Restaurar scroll del body
        document.body.style.overflow = '';
    }
};

// Función principal de inicialización
const initFormHandlers = () => {
    // Agregar el modal al body si no existe
    if (!document.getElementById('loadingModal')) {
        document.body.appendChild(createLoadingModal());
    }

    // Manejar envío de formularios
    document.addEventListener('submit', (e) => {
        if (e.target.tagName === 'FORM') {
            // Verificar si el formulario es válido
            if (e.target.checkValidity()) {
                showLoadingModal();
            }
        }
    });

    // Manejar errores y recarga de página
    window.addEventListener('pageshow', (event) => {
        hideLoadingModal();
    });

    // Manejar navegación por el historial
    window.addEventListener('popstate', () => {
        hideLoadingModal();
    });

    // Manejar tecla Escape para cerrar el modal en desarrollo
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && process.env.NODE_ENV === 'development') {
            hideLoadingModal();
        }
    });
};

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initFormHandlers);

// Manejar errores de red o servidor
window.addEventListener('error', () => {
    hideLoadingModal();
});

window.addEventListener('unhandledrejection', () => {
    hideLoadingModal();
});
