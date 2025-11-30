<!-- Card de Cliente/Propietario -->
<div class="card p-6" id="client_info">
    <div class="card-header mb-6">
        <h3 class="text-xl font-semibold">👤 Información del Cliente/Propietario</h3>
    </div>
    
    <!-- Buscador de Cliente -->
    <div class="mb-6">
        <label class="form-label font-semibold mb-2">Buscar Cliente Existente</label>
        <div class="flex gap-2">
            <div class="flex-1 relative">
                <i class="ki-filled ki-magnifier absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                <input 
                    type="text" 
                    id="client_search" 
                    class="input pl-10" 
                    placeholder="Buscar por nombre, teléfono, CI o email..."
                    autocomplete="off"
                >
                <!-- Resultados de búsqueda -->
                <div id="search_results" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg mt-1 shadow-lg hidden max-h-60 overflow-y-auto"></div>
            </div>
            <button type="button" id="new_client_btn" class="btn btn-primary shrink-0">
                <i class="ki-filled ki-plus"></i>
                Nuevo Cliente
            </button>
        </div>
    </div>

    <div class="separator my-6"></div>

    <!-- Formulario de Cliente -->
    <div id="client_form" class="hidden">
        <input type="hidden" name="client_id" id="client_id">
        
        <div class="space-y-6">
            <!-- Nombre y Apellido -->
            <div class="grid grid-cols-4 gap-4 items-center">
                <x-input-label for="client_name" value="Nombre" class="text-gray-700 required" />
                <div class="col-span-3 grid grid-cols-2 gap-4">
                    <div>
                        <x-text-input 
                            id="client_name" 
                            name="client_name" 
                            type="text" 
                            class="w-full" 
                            placeholder="Nombre"
                            required
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('client_name')"/>
                    </div>
                    <div>
                        <x-text-input 
                            id="client_lastname" 
                            name="client_lastname" 
                            type="text" 
                            class="w-full" 
                            placeholder="Apellido"
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('client_lastname')"/>
                    </div>
                </div>
            </div>

            <!-- Teléfono y Email -->
            <div class="grid grid-cols-4 gap-4 items-center">
                <x-input-label for="client_phone" value="Contacto" class="text-gray-700" />
                <div class="col-span-3 grid grid-cols-2 gap-4">
                    <div>
                        <x-text-input 
                            id="client_phone" 
                            name="client_phone" 
                            type="text" 
                            class="w-full" 
                            placeholder="Teléfono"
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('client_phone')"/>
                    </div>
                    <div>
                        <x-text-input 
                            id="client_email" 
                            name="client_email" 
                            type="email" 
                            class="w-full" 
                            placeholder="Email"
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('client_email')"/>
                    </div>
                </div>
            </div>

            <!-- CI y Ciudad -->
            <div class="grid grid-cols-4 gap-4 items-center">
                <x-input-label for="client_ci" value="CI/Documento" class="text-gray-700" />
                <div class="col-span-3 grid grid-cols-2 gap-4">
                    <div>
                        <x-text-input 
                            id="client_ci" 
                            name="client_ci" 
                            type="text" 
                            class="w-full" 
                            placeholder="Cédula de Identidad"
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('client_ci')"/>
                    </div>
                    <div>
                        <x-text-input 
                            id="client_city" 
                            name="client_city" 
                            type="text" 
                            class="w-full" 
                            placeholder="Ciudad"
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('client_city')"/>
                    </div>
                </div>
            </div>

            <!-- Dirección -->
            <div class="grid grid-cols-4 gap-4 items-center">
                <x-input-label for="client_address" value="Dirección" class="text-gray-700" />
                <div class="col-span-3">
                    <x-text-input 
                        id="client_address" 
                        name="client_address" 
                        type="text" 
                        class="w-full" 
                        placeholder="Dirección completa"
                    />
                    <x-input-error class="mt-1" :messages="$errors->get('client_address')"/>
                </div>
            </div>

            <!-- Notas -->
            <div class="grid grid-cols-4 gap-4 items-start">
                <x-input-label for="client_notes" value="Notas" class="text-gray-700 pt-2" />
                <div class="col-span-3">
                    <textarea 
                        id="client_notes" 
                        name="client_notes" 
                        rows="2" 
                        class="input w-full"
                        placeholder="Observaciones adicionales del cliente..."
                    ></textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('client_notes')"/>
                </div>
            </div>
        </div>

        <!-- Alerta de Cliente Seleccionado -->
        <div class="alert alert-primary mt-4 items-center" id="client_selected_alert" style="display: none;">
            <i class="ki-filled ki-information-2"></i>
            <span id="client_selected_text"></span>
            <button type="button" id="clear_client_btn" class="btn btn-xs btn-light ml-auto">
                <i class="ki-filled ki-cross"></i>
                Cambiar Cliente
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('client_search');
    const searchResults = document.getElementById('search_results');
    const clientForm = document.getElementById('client_form');
    const newClientBtn = document.getElementById('new_client_btn');
    const selectedAlert = document.getElementById('client_selected_alert');
    const selectedText = document.getElementById('client_selected_text');
    const clearClientBtn = document.getElementById('clear_client_btn');
    
    let searchTimeout;

    // Búsqueda de clientes con debounce
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const search = this.value.trim();

        if (search.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`/api/clients/search?q=${encodeURIComponent(search)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        searchResults.innerHTML = '<div class="p-3 text-sm text-gray-600 text-center">No se encontraron clientes. Crea uno nuevo.</div>';
                    } else {
                        searchResults.innerHTML = data.map(client => `
                            <div class="p-3 hover:bg-gray-50 cursor-pointer border-b last:border-b-0 transition-colors" onclick="selectClient(${client.id}, '${escapeHtml(client.name)}', '${escapeHtml(client.lastname || '')}', '${escapeHtml(client.phone || '')}', '${escapeHtml(client.email || '')}', '${escapeHtml(client.ci || '')}', '${escapeHtml(client.address || '')}', '${escapeHtml(client.city || '')}', '${escapeHtml(client.notes || '')}')">
                                <div class="font-semibold text-sm text-gray-900">${client.full_name}</div>
                                <div class="text-xs text-gray-600 mt-1">
                                    ${client.phone ? '<i class="ki-filled ki-phone text-xs"></i> ' + client.phone + ' ' : ''} 
                                    ${client.email ? '<i class="ki-filled ki-sms text-xs"></i> ' + client.email + ' ' : ''}
                                    ${client.ci ? '<i class="ki-filled ki-badge text-xs"></i> ' + client.ci : ''}
                                </div>
                            </div>
                        `).join('');
                    }
                    searchResults.classList.remove('hidden');
                })
                .catch(err => {
                    console.error('Error buscando clientes:', err);
                    searchResults.innerHTML = '<div class="p-3 text-sm text-red-600 text-center">Error al buscar. Intente nuevamente.</div>';
                    searchResults.classList.remove('hidden');
                });
        }, 300);
    });

    // Función para escapar HTML
    window.escapeHtml = function(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    };

    // Seleccionar cliente de resultados
    window.selectClient = function(id, name, lastname, phone, email, ci, address, city, notes) {
        document.getElementById('client_id').value = id;
        document.getElementById('client_name').value = name;
        document.getElementById('client_lastname').value = lastname;
        document.getElementById('client_phone').value = phone;
        document.getElementById('client_email').value = email;
        document.getElementById('client_ci').value = ci;
        document.getElementById('client_address').value = address;
        document.getElementById('client_city').value = city;
        document.getElementById('client_notes').value = notes;

        clientForm.classList.remove('hidden');
        searchResults.classList.add('hidden');
        searchInput.value = name + (lastname ? ' ' + lastname : '');
        
        selectedAlert.style.display = 'flex';
        selectedText.textContent = `Cliente seleccionado: ${name} ${lastname}`;
        
        // Deshabilitar campos para evitar edición accidental
        disableClientFields(true);
    };

    // Botón nuevo cliente
    newClientBtn.addEventListener('click', function() {
        clearClientForm();
        clientForm.classList.remove('hidden');
        searchInput.value = '';
        searchResults.classList.add('hidden');
        selectedAlert.style.display = 'none';
        disableClientFields(false);
        document.getElementById('client_name').focus();
    });

    // Botón limpiar/cambiar cliente
    clearClientBtn.addEventListener('click', function() {
        clearClientForm();
        searchInput.value = '';
        searchInput.focus();
        selectedAlert.style.display = 'none';
        disableClientFields(false);
    });

    // Función para limpiar formulario
    function clearClientForm() {
        document.getElementById('client_id').value = '';
        document.getElementById('client_name').value = '';
        document.getElementById('client_lastname').value = '';
        document.getElementById('client_phone').value = '';
        document.getElementById('client_email').value = '';
        document.getElementById('client_ci').value = '';
        document.getElementById('client_address').value = '';
        document.getElementById('client_city').value = '';
        document.getElementById('client_notes').value = '';
    }

    // Función para habilitar/deshabilitar campos
    function disableClientFields(disabled) {
        document.getElementById('client_name').disabled = disabled;
        document.getElementById('client_lastname').disabled = disabled;
        document.getElementById('client_phone').disabled = disabled;
        document.getElementById('client_email').disabled = disabled;
        document.getElementById('client_ci').disabled = disabled;
    }

    // Ocultar resultados al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
});
</script>
@endpush
