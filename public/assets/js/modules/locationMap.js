export const initLocationMap = () => {
    // Default coordinates (Santa Cruz de la Sierra)
    const defaultLat = -17.783330;
    const defaultLng = -63.182127;

    const initializeMap = () => {
        console.log('Initializing map...');
        const map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Agregar el control de geocodificación
        const geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: 'Buscar dirección...',
            geocoder: L.Control.Geocoder.nominatim({
                geocodingQueryParams: {
                    countrycodes: 'bo',
                    limit: 5
                }
            })
        }).addTo(map);

        return { map, geocoder };
    };

    const createMarker = (map, lat, lng) => {
        console.log('Creating marker at:', lat, lng);
        return L.marker([lat, lng], {
            draggable: true
        }).addTo(map);
    };

    const updateInputs = (lat, lng, address = null) => {
        console.log('Updating input fields with:', lat, lng, address);
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const addressInput = document.getElementById('address');
        const address2Input = document.getElementById('address2');

        if (latInput && lngInput) {
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);
        }

        if (address) {
            if (addressInput) addressInput.value = address;
            if (address2Input) address2Input.value = address;
        }
    };

    const validateCoordinates = (lat, lng) => {
        const validLat = Math.max(Math.min(lat, 90), -90);
        const validLng = Math.max(Math.min(lng, 180), -180);
        return { lat: validLat, lng: validLng };
    };

    const updateMarkerAndMap = (map, marker, lat, lng, address = null) => {
        console.log('Updating marker and map to:', lat, lng);
        const coords = validateCoordinates(lat, lng);
        marker.setLatLng([coords.lat, coords.lng]);
        map.panTo([coords.lat, coords.lng]);
        map.setZoom(16);
        updateInputs(coords.lat, coords.lng, address);
    };

    // Función para búsqueda directa con Nominatim
    const searchAddress = async (query, map, marker) => {
        try {
            console.log('Searching address:', query);
            const encodedQuery = encodeURIComponent(query + ', Bolivia');
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodedQuery}&limit=1`;

            const response = await fetch(url);
            const data = await response.json();
            console.log('Search results:', data);

            if (data && data.length > 0) {
                const result = data[0];
                const lat = parseFloat(result.lat);
                const lng = parseFloat(result.lon);

                console.log('Found location:', lat, lng);
                updateMarkerAndMap(map, marker, lat, lng, result.display_name);
                return true;
            }
            return false;
        } catch (error) {
            console.error('Error searching address:', error);
            return false;
        }
    };

    // Initialize map and geocoder
    console.log('Starting map initialization...');
    const { map, geocoder } = initializeMap();
    const marker = createMarker(map, defaultLat, defaultLng);

    // Función para la búsqueda de dirección con geocoder
    const performGeocode = (geocoder, query) => {
        return new Promise((resolve) => {
            geocoder.options.geocoder.geocode(query, (results) => {
                if (results && results.length > 0) {
                    const { center, name } = results[0];
                    resolve({ lat: center.lat, lng: center.lng, address: name });
                } else {
                    resolve(null);
                }
            });
        });
    };

    // Evento para cuando se selecciona una dirección del geocoder
    geocoder.on('markgeocode', (e) => {
        const { center, name } = e.geocode;
        updateMarkerAndMap(map, marker, center.lat, center.lng, name);
    });

    // Configurar la búsqueda para el campo address2
    const setupAddress2Field = () => {
        const input = document.getElementById('address2');
        if (!input) {
            console.log('address2 input not found');
            return;
        }

        console.log('Setting up address2 search field');
        let timeoutId;

        // Evento input para autocompletado
        input.addEventListener('input', (e) => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                const query = e.target.value;
                if (query.length > 3) {
                    searchAddress(query, map, marker);
                }
            }, 500);
        });

        // Evento keypress para Enter
        input.addEventListener('keypress', async (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = e.target.value;
                if (query) {
                    await searchAddress(query, map, marker);
                }
            }
        });
    };

    // Configurar el campo de búsqueda
    setupAddress2Field();

    // Map click event
    map.on('click', (e) => {
        console.log('Map clicked at:', e.latlng);
        updateMarkerAndMap(map, marker, e.latlng.lat, e.latlng.lng);

        // Reverse geocoding al hacer clic
        geocoder.options.geocoder.reverse(e.latlng, map.options.crs.scale(map.getZoom()), (results) => {
            if (results.length > 0) {
                updateInputs(e.latlng.lat, e.latlng.lng, results[0].name);
            }
        });
    });

    // Marker drag event
    marker.on('dragend', (e) => {
        const position = e.target.getLatLng();
        console.log('Marker dragged to:', position);

        // Reverse geocoding al soltar el marcador
        geocoder.options.geocoder.reverse(position, map.options.crs.scale(map.getZoom()), (results) => {
            if (results.length > 0) {
                updateMarkerAndMap(map, marker, position.lat, position.lng, results[0].name);
            } else {
                updateMarkerAndMap(map, marker, position.lat, position.lng);
            }
        });
    });

    // Input change events for coordinates
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    const handleInputChange = () => {
        console.log('Coordinate inputs changed');
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
