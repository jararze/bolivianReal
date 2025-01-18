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

// function handleThumbnailUpload(input) {
//     const preview = document.getElementById('thumbnail-preview');
//     const placeholder = document.getElementById('thumbnail-placeholder');
//     const removeBtn = document.getElementById('remove-thumbnail');
//
//     if (input.files && input.files[0]) {
//         const reader = new FileReader();
//
//         reader.onload = function (e) {
//             preview.src = e.target.result;
//             preview.classList.remove('hidden');
//             placeholder.classList.add('hidden');
//             removeBtn.classList.remove('hidden');
//         }
//
//         reader.readAsDataURL(input.files[0]);
//     }
// }
//
// function removeThumbnail() {
//     const input = document.getElementById('thumbnail');
//     const preview = document.getElementById('thumbnail-preview');
//     const placeholder = document.getElementById('thumbnail-placeholder');
//     const removeBtn = document.getElementById('remove-thumbnail');
//
//     input.value = '';
//     preview.src = '';
//     preview.classList.add('hidden');
//     placeholder.classList.remove('hidden');
//     removeBtn.classList.add('hidden');
// }
//
// function handleAdditionalImages(input) {
//     const previewGrid = document.getElementById('preview-grid');
//
//     if (input.files && input.files.length > 0) {
//         Array.from(input.files).forEach((file, index) => {
//             const reader = new FileReader();
//
//             reader.onload = function (e) {
//                 const div = document.createElement('div');
//                 div.className = 'relative aspect-square';
//                 div.innerHTML = `
//                     <img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">
//                     <button type="button"
//                             class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-sm hover:bg-gray-100"
//                             onclick="removeAdditionalImage(this, ${index})">
//                         <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
//                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
//                         </svg>
//                     </button>
//                 `;
//                 previewGrid.appendChild(div);
//             };
//
//             reader.readAsDataURL(file);
//         });
//     }
// }
//
// function removeAdditionalImage(button, index) {
//     const container = button.parentElement;
//     container.remove();
//
//     const input = document.getElementById('additional-images');
//     const dt = new DataTransfer();
//
//     Array.from(input.files).forEach((file, i) => {
//         if (i !== index) dt.items.add(file);
//     });
//
//     input.files = dt.files;
// }
//
// function handleDrop(e) {
//     e.preventDefault();
//     const dropZone = document.getElementById('drop-zone');
//     dropZone.classList.remove('border-primary-500');
//
//     const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
//     const input = document.getElementById('additional-images');
//
//     const dt = new DataTransfer();
//     if (input.files) {
//         Array.from(input.files).forEach(file => dt.items.add(file));
//     }
//     files.forEach(file => dt.items.add(file));
//
//     input.files = dt.files;
//     handleAdditionalImages(input);
// }
//
// function handleDragOver(e) {
//     e.preventDefault();
//     e.currentTarget.classList.add('border-primary-500');
// }
//
// function handleDragLeave(e) {
//     e.preventDefault();
//     e.currentTarget.classList.remove('border-primary-500');
// }
//
//
// document.addEventListener('DOMContentLoaded', function () {
//     // Coordenadas por defecto (Santa Cruz de la Sierra)
//     const defaultLat = -17.783330;
//     const defaultLng = -63.182127;
//
//     // Inicializar el mapa
//     const map = L.map('map').setView([defaultLat, defaultLng], 13);
//
//     // Añadir la capa de OpenStreetMap
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         attribution: '© OpenStreetMap contributors'
//     }).addTo(map);
//
//     // Crear marcador arrastrable
//     let marker = L.marker([defaultLat, defaultLng], {
//         draggable: true
//     }).addTo(map);
//
//     // Referencias a los inputs
//     const latInput = document.getElementById('latitude');
//     const lngInput = document.getElementById('longitude');
//
//     // Función para actualizar inputs
//     function updateInputs(lat, lng) {
//         latInput.value = lat.toFixed(6);
//         lngInput.value = lng.toFixed(6);
//     }
//
//     // Función para actualizar marcador y mapa
//     function updateMarkerAndMap(lat, lng) {
//         const validLat = Math.max(Math.min(lat, 90), -90);
//         const validLng = Math.max(Math.min(lng, 180), -180);
//
//         marker.setLatLng([validLat, validLng]);
//         map.panTo([validLat, validLng]);
//         updateInputs(validLat, validLng);
//     }
//
//     // Inicializar con valores existentes o default
//     if (latInput.value && lngInput.value) {
//         updateMarkerAndMap(
//             parseFloat(latInput.value),
//             parseFloat(lngInput.value)
//         );
//     } else {
//         updateInputs(defaultLat, defaultLng);
//     }
//
//     // Evento click en el mapa
//     map.on('click', function (e) {
//         updateMarkerAndMap(e.latlng.lat, e.latlng.lng);
//     });
//
//     // Evento al arrastrar el marcador
//     marker.on('dragend', function (e) {
//         const position = e.target.getLatLng();
//         updateMarkerAndMap(position.lat, position.lng);
//     });
//
//     // Eventos para los inputs
//     function handleInputChange() {
//         const lat = parseFloat(latInput.value);
//         const lng = parseFloat(lngInput.value);
//
//         if (!isNaN(lat) && !isNaN(lng)) {
//             updateMarkerAndMap(lat, lng);
//         }
//     }
//
//     latInput.addEventListener('change', handleInputChange);
//     lngInput.addEventListener('change', handleInputChange);
//
//     // Validación de inputs
//     function validateInput(input, min, max, fieldName) {
//         input.addEventListener('input', function (e) {
//             const value = parseFloat(e.target.value);
//             if (isNaN(value)) {
//                 input.setCustomValidity(`Por favor ingrese un número válido`);
//             } else if (value < min || value > max) {
//                 input.setCustomValidity(`${fieldName} debe estar entre ${min} y ${max}`);
//             } else {
//                 input.setCustomValidity('');
//             }
//         });
//     }
//
//     validateInput(latInput, -90, 90, 'La latitud');
//     validateInput(lngInput, -180, 180, 'La longitud');
//
//     // Ajustar el mapa cuando se muestra por primera vez
//     setTimeout(() => {
//         map.invalidateSize();
//     }, 100);
// });
//
//
// function toggleProjectFields(value) {
//     const projectFields = document.getElementById('project-fields');
//     const fields = projectFields.querySelectorAll('input, select');
//
//     if (value === '1') {
//         projectFields.style.display = 'block';
//         fields.forEach(field => field.disabled = false);
//     } else {
//         projectFields.style.display = 'none';
//         fields.forEach(field => {
//             field.disabled = true;
//             if (field.type === 'text' || field.type === 'number') {
//                 field.value = '';
//             }
//         });
//     }
// }
//
// // Inicializar estado de campos al cargar
// document.addEventListener('DOMContentLoaded', function () {
//     const isProject = document.getElementById('is_project').value;
//     toggleProjectFields(isProject);
// });
//
// document.addEventListener('DOMContentLoaded', function () {
//     const container = document.getElementById('services-container');
//
//     // Función para agregar nueva fila
//     function addServiceRow() {
//         // Obtener elementos originales para clonar estilos
//         const originalSelect = document.querySelector('select[name="features[]"]');
//         const originalInput = document.querySelector('input[name="place_names[]"]');
//
//         const newRow = document.createElement('div');
//         newRow.className = 'service-row grid grid-cols-12 gap-4 items-start';
//
//         newRow.innerHTML = `
//             <div class="col-span-4">
//                 <select name="features[]" class="${originalSelect.className}">
//                     ${originalSelect.innerHTML}
//                 </select>
//             </div>
//             <div class="col-span-4">
//                 <input type="text"
//                        name="place_names[]"
//                        class="${originalInput.className}"
//                        placeholder="Nombre del servicio">
//             </div>
//             <div class="col-span-3">
//                 <input type="text"
//                        name="distances[]"
//                        class="${originalInput.className}"
//                        placeholder="Distancia (Cuadras)">
//             </div>
//             <div class="col-span-1 flex space-x-1">
//                 <button type="button"
//                         class="flex items-center justify-center w-8 h-8 rounded-lg bg-success text-white hover:bg-success-dark add-service">
//                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
//                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
//                     </svg>
//                 </button>
//                 <button type="button"
//                         class="flex items-center justify-center w-8 h-8 rounded-lg bg-danger text-white hover:bg-danger-dark remove-service">
//                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
//                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"/>
//                     </svg>
//                 </button>
//             </div>
//         `;
//
//         // Copiar todos los atributos del select original al nuevo
//         const newSelect = newRow.querySelector('select');
//         Array.from(originalSelect.attributes).forEach(attr => {
//             if (attr.name !== 'id') { // No copiamos el ID para evitar duplicados
//                 newSelect.setAttribute(attr.name, attr.value);
//             }
//         });
//
//         // Copiar atributos de los inputs originales a los nuevos
//         const newInputs = newRow.querySelectorAll('input');
//         newInputs.forEach(input => {
//             Array.from(originalInput.attributes).forEach(attr => {
//                 if (attr.name !== 'id' && attr.name !== 'name' && attr.name !== 'value') {
//                     input.setAttribute(attr.name, attr.value);
//                 }
//             });
//         });
//
//         container.appendChild(newRow);
//         attachEventListeners(newRow);
//     }
//
//     // Función para eliminar fila
//     function removeServiceRow(button) {
//         const row = button.closest('.service-row');
//         if (container.children.length > 1) {
//             row.remove();
//         }
//     }
//
//     // Función para agregar event listeners a una fila
//     function attachEventListeners(row) {
//         const addButton = row.querySelector('.add-service');
//         const removeButton = row.querySelector('.remove-service');
//
//         if (addButton) {
//             addButton.addEventListener('click', addServiceRow);
//         }
//         if (removeButton) {
//             removeButton.addEventListener('click', function () {
//                 removeServiceRow(this);
//             });
//         }
//     }
//
//     // Agregar event listeners a la fila inicial
//     document.querySelectorAll('.service-row').forEach(row => {
//         attachEventListeners(row);
//     });
// });
