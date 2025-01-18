export const initLocationMap = () => {
    // Default coordinates (Santa Cruz de la Sierra)
    const defaultLat = -17.783330;
    const defaultLng = -63.182127;

    const initializeMap = () => {
        const map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        return map;
    };

    const createMarker = (map, lat, lng) => {
        return L.marker([lat, lng], {
            draggable: true
        }).addTo(map);
    };

    const updateInputs = (lat, lng) => {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        if (latInput && lngInput) {
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);
        }
    };

    const validateCoordinates = (lat, lng) => {
        const validLat = Math.max(Math.min(lat, 90), -90);
        const validLng = Math.max(Math.min(lng, 180), -180);
        return { lat: validLat, lng: validLng };
    };

    const updateMarkerAndMap = (map, marker, lat, lng) => {
        const coords = validateCoordinates(lat, lng);
        marker.setLatLng([coords.lat, coords.lng]);
        map.panTo([coords.lat, coords.lng]);
        updateInputs(coords.lat, coords.lng);
    };

    // Initialize map
    const map = initializeMap();
    const marker = createMarker(map, defaultLat, defaultLng);

    // Map click event
    map.on('click', (e) => {
        updateMarkerAndMap(map, marker, e.latlng.lat, e.latlng.lng);
    });

    // Marker drag event
    marker.on('dragend', (e) => {
        const position = e.target.getLatLng();
        updateMarkerAndMap(map, marker, position.lat, position.lng);
    });

    // Input change events
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    const handleInputChange = () => {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);

        if (!isNaN(lat) && !isNaN(lng)) {
            updateMarkerAndMap(map, marker, lat, lng);
        }
    };

    if (latInput && lngInput) {
        latInput.addEventListener('change', handleInputChange);
        lngInput.addEventListener('change', handleInputChange);

        // Initial coordinates
        if (latInput.value && lngInput.value) {
            updateMarkerAndMap(
                map,
                marker,
                parseFloat(latInput.value),
                parseFloat(lngInput.value)
            );
        } else {
            updateInputs(defaultLat, defaultLng);
        }
    }

    // Adjust map size
    setTimeout(() => {
        map.invalidateSize();
    }, 100);
};
