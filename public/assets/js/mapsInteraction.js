// Variables globales
let map;
let marker;
const defaultLocation = { lat: -17.783330, lng: -63.182126 }; // Santa Cruz de la Sierra

// Inicializar el mapa
function initMap() {
    map = L.map('map').setView([defaultLocation.lat, defaultLocation.lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Crear marcador inicial
    marker = L.marker([defaultLocation.lat, defaultLocation.lng], {
        draggable: true
    }).addTo(map);

    // Manejar el evento de arrastrar el marcador
    marker.on('dragend', function(event) {
        const position = marker.getLatLng();
        updateCoordinates(position.lat, position.lng);
    });

    // Configurar el campo de dirección para la búsqueda
    const addressInput = document.getElementById('address');
    addressInput.addEventListener('change', searchAddress);
    addressInput.addEventListener('blur', searchAddress);
}

// Función para buscar dirección
async function searchAddress() {
    alert("dasdsa")
    const address = document.getElementById('address').value;
    const cityName = document.querySelector('#city option:checked').text;
    const country = document.getElementById('country').value;

    if (!address) return;

    try {
        const searchQuery = `${address}, ${cityName}, ${country}`;
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}`);
        const data = await response.json();

        if (data && data.length > 0) {
            const { lat, lon } = data[0];

            // Actualizar marcador y mapa
            marker.setLatLng([lat, lon]);
            map.setView([lat, lon], 16);

            // Actualizar campos de coordenadas
            updateCoordinates(lat, lon);
        }
    } catch (error) {
        console.error('Error al buscar la dirección:', error);
    }
}

// Función para actualizar las coordenadas en los campos
function updateCoordinates(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lng.toFixed(6);
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initMap);
