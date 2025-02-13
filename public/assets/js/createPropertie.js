import { initImageUpload } from './modules/imageUpload.js';
import { initLocationMap  } from './modules/locationMap.js';
import { initServices  } from './modules/services.js';
import { initProjectFields  } from './modules/projectFields.js';


document.addEventListener('DOMContentLoaded', function() {
    initImageUpload();
    initLocationMap();
    initServices();
    initProjectFields();
});

