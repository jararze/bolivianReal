@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const MAX_SELECTIONS = 5;
            const checkboxes = document.querySelectorAll('input[name="property_ids[]"]');
            let selectedIds = {!! json_encode($settings['slider_ids'] ?? []) !!};

            // Agregar event listeners para los controles adicionales
            document.getElementById('active').addEventListener('change', function() {
                saveChanges(selectedIds);
            });

            document.getElementById('order').addEventListener('change', function() {
                saveChanges(selectedIds);
            });

            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white z-50`;
                notification.textContent = message;
                document.body.appendChild(notification);

                // Remover después de 3 segundos
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            function saveChanges() {
                const data = {
                    property_ids: selectedIds,
                    active: document.getElementById('active').checked,
                    order: document.getElementById('order').value,
                    _token: '{{ csrf_token() }}'
                };

                fetch('{{ route("backend.configurations.home-slider.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Cambios guardados correctamente');
                            updateCheckboxStates();
                        } else {
                            showNotification(data.message || 'Error al guardar los cambios', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Error al guardar los cambios', 'error');
                    });
            }

            function updateCheckboxStates() {
                const selectedCount = selectedIds.length;

                checkboxes.forEach(checkbox => {
                    const id = checkbox.value;
                    const isSelected = selectedIds.includes(id);

                    // Solo deshabilitar los no seleccionados cuando llegamos al límite
                    if (selectedCount >= MAX_SELECTIONS) {
                        checkbox.disabled = !isSelected;
                    } else {
                        checkbox.disabled = false;
                    }

                    const card = checkbox.closest('.flex.flex-col.border');
                    if (card) {
                        if (isSelected) {
                            card.classList.add('border-primary', 'bg-primary/5');
                            card.classList.remove('border-gray-200');
                        } else {
                            card.classList.remove('border-primary', 'bg-primary/5');
                            card.classList.add('border-gray-200');
                        }
                    }
                });
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const id = this.value;

                    if (this.checked) {
                        if (selectedIds.length >= MAX_SELECTIONS && !selectedIds.includes(id)) {
                            this.checked = false;
                            alert('Solo puede seleccionar hasta ' + MAX_SELECTIONS + ' propiedades');
                            return;
                        }
                        if (!selectedIds.includes(id)) {
                            selectedIds.push(id);
                        }
                    } else {
                        selectedIds = selectedIds.filter(selectedId => selectedId !== id);
                    }

                    updateCheckboxStates();
                    saveChanges();
                });
            });

            // Aplicar estado inicial
            updateCheckboxStates();
        });
    </script>
@endpush
<x-app-layout>


    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Configuracion') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.configurations.index') }}">
                {{ __('Pagina principal') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">{{ __('Ajustes de la página principal') }}</span>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">{{ __('Slider Principal') }}</span>
        </div>
    </x-slot>


    <!-- En home-slider.blade.php -->


    <div class="container-fixed">
        <!-- begin: grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-7.5">
            <div class="col-span-2">
                <div class="flex flex-col gap-5 lg:gap-7.5">

                    <div class="card min-w-full">
                        <div class="card-header">
                            <h3 class="card-title">
                                Configuración del Slider
                            </h3>
                        </div>

                        <div class="card-body lg:py-7.5 py-5">
                            <div class="mb-4">
                                <form method="GET" action="{{ route('backend.configurations.home-slider') }}"
                                      class="flex items-center gap-2">
                                    <!-- Mantener otros parámetros de URL que puedan existir -->
                                    @foreach(request()->except(['search', 'page']) as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach

                                    <div class="flex-1 flex items-center gap-2">
                                        <input type="text"
                                               name="search"
                                               value="{{ request('search') }}"
                                               placeholder="Buscar propiedades..."
                                               class="input flex-1">

                                        <button type="submit" class="btn btn-primary whitespace-nowrap">
                                            Buscar
                                        </button>

                                        @if(request('search'))
                                            <a href="{{ route('backend.configurations.home-slider') }}"
                                               class="btn btn-secondary whitespace-nowrap">
                                                Limpiar
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>

{{--                        <form method="post" action="{{ route('backend.configurations.home-slider.update') }}">--}}
{{--                            @csrf--}}
                            <div class="card-body lg:py-7.5 py-5">

                                <!-- Status Toggle -->
                                <div class="flex items-center gap-5">
                                    <div class="w-1/3 text-gray-900 text-sm font-medium">
                                        <x-input-label for="active" :value="__('Estado del Slider')"
                                                       class="text-gray-900 text-sm font-medium"/>
                                    </div>
                                    <div class="w-2/3">
                                        <div class="switch">
                                            <input type="checkbox"
                                                   id="active"
                                                   name="active"
                                                   value="1"
                                                {{ $settings['active'] ? 'checked' : '' }}>
                                        </div>
                                        <x-input-error class="mt-2" :messages="$errors->get('active')"/>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 my-7.5"></div>

                                <!-- Property Selection -->
                                <div class="flex flex-col">
                                    <div class="text-gray-900 text-sm font-medium mb-4">
                                        Propiedades en el Slider
                                    </div>

                                    <!-- Barra de búsqueda -->
                                    <!-- Barra de búsqueda -->


                                    <!-- Lista de propiedades paginada -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($properties as $property)
                                            <div class="flex flex-col border {{ in_array($property->id, $settings['slider_ids'] ?? []) ? 'border-primary bg-primary/5' : 'border-gray-200' }} rounded-xl p-4">
                                                <div class="flex justify-between items-start mb-2">
                                                    @if(in_array($property->id, $settings['slider_ids'] ?? []))
                                                        <span class="text-primary text-xs font-medium bg-primary/10 px-2 py-1 rounded">Seleccionada</span>
                                                    @endif
                                                </div>
                                                <img src="{{ $property->thumbnail }}"
                                                     alt="{{ $property->name }}"
                                                     class="w-full h-40 object-cover rounded-lg mb-3"
                                                     loading="lazy">
                                                <div class="flex items-center gap-2">
                                                    <input type="checkbox"
                                                           name="property_ids[]"
                                                           value="{{ $property->id }}"
                                                           {{ in_array($property->id, $settings['slider_ids'] ?? []) ? 'checked' : '' }}
                                                           class="checkbox">
                                                    <label class="text-sm font-medium text-gray-900">
                                                        {{ Str::limit($property->name, 30) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Paginación -->
                                    <div class="mt-4">
                                        {{ $properties->appends(request()->except('page'))->links() }}
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 my-7.5"></div>

                                <div class="flex items-center gap-5">
                                    <div class="w-1/3 text-gray-900 text-sm font-medium">
                                        <x-input-label for="order" :value="__('Orden de visualización')"
                                                       class="text-gray-900 text-sm font-medium"/>
                                    </div>
                                    <div class="w-2/3">
                                        <select id="order"
                                                name="order"
                                                class="select w-full"
                                                required>
                                            <option
                                                value="desc" {{ ($settings['order'] ?? 'desc') == 'desc' ? 'selected' : '' }}>
                                                Más recientes primero
                                            </option>
                                            <option
                                                value="asc" {{ ($settings['order'] ?? 'desc') == 'asc' ? 'selected' : '' }}>
                                                Más antiguos primero
                                            </option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('order')"/>
                                    </div>
                                </div>


                                <div class="border-t border-gray-200 my-7.5"></div>

{{--                                <div class="flex justify-end">--}}
{{--                                    <div class="flex justify-end">--}}
{{--                                        <x-primary-button name="action">Guardar Cambios</x-primary-button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
{{--                        </form>--}}

                    </div>


                </div>
            </div>
            @include('layouts.metronic.backend.sidebar')

        </div>
        <!-- end: grid -->
    </div>


</x-app-layout>
