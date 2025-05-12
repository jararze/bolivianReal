import { initImageUpload } from './modules/imageUpload.js';
import { initLocationMap  } from './modules/locationMap.js';
import { initServices  } from './modules/services.js';
import { initProjectFields  } from './modules/projectFields.js';


document.addEventListener('DOMContentLoaded', function() {

    // Verificar si el mapa ya está inicializado
    const mapContainer = document.getElementById('map');

    if (mapContainer && !mapContainer._leaflet_id) {
        // Inicializar el mapa solo si no está ya inicializado
        initLocationMap();
    } else {
        console.log('Map already initialized or container not found');
    }


    initImageUpload();
    initServices();
    initProjectFields();
});

