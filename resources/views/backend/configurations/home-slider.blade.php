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
                        <form method="post" action="{{ route('backend.configurations.home-slider.update') }}">
                            @csrf
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
                                <div class="flex flex-wrap justify-between gap-5">
                                    <div class="flex flex-col">
                                        <div class="text-gray-900 text-sm font-medium">
                                            Propiedades en el Slider
                                        </div>
                                        <span class="text-gray-700 text-2sm">Seleccione las propiedades que desea mostrar en el slider principal</span>
                                        <x-input-error class="mt-2" :messages="$errors->get('property_ids')"/>
                                    </div>
                                    <div class="flex flex-wrap gap-5 lg:gap-7.5 w-full">
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                                            @foreach($properties as $property)
                                                <div class="flex flex-col border border-gray-200 rounded-xl p-4">
                                                    <img src="{{ $property->thumbnail }}"
                                                         alt="{{ $property->name }}"
                                                         class="w-full h-40 object-cover rounded-lg mb-3">

                                                    <div class="flex items-center gap-2">
                                                        <input type="checkbox"
                                                               name="property_ids[]"
                                                               value="{{ $property->id }}"
                                                               {{ in_array($property->id, $settings['slider_ids'] ?? []) ? 'checked' : '' }}
                                                               class="checkbox">
                                                        <label class="text-sm font-medium text-gray-900">
                                                            {{ $property->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 my-7.5"></div>

                                <div class="flex items-center gap-5">
                                    <div class="w-1/3 text-gray-900 text-sm font-medium">
                                        <x-input-label for="order" :value="__('Orden de visualización')" class="text-gray-900 text-sm font-medium"/>
                                    </div>
                                    <div class="w-2/3">
                                        <select id="order"
                                                name="order"
                                                class="select w-full"
                                                required>
                                            <option value="desc" {{ ($settings['order'] ?? 'desc') == 'desc' ? 'selected' : '' }}>
                                                Más recientes primero
                                            </option>
                                            <option value="asc" {{ ($settings['order'] ?? 'desc') == 'asc' ? 'selected' : '' }}>
                                                Más antiguos primero
                                            </option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('order')"/>
                                    </div>
                                </div>



                                <div class="border-t border-gray-200 my-7.5"></div>

                                <div class="flex justify-end">
                                    <div class="flex justify-end">
                                        <x-primary-button name="action">Guardar Cambios</x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>


                </div>
            </div>
            @include('layouts.metronic.backend.sidebar')

        </div>
        <!-- end: grid -->
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const MAX_SELECTIONS = 5;
            const checkboxes = document.querySelectorAll('input[name="property_ids[]"]');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checked = document.querySelectorAll('input[name="property_ids[]"]:checked');

                    if (checked.length > MAX_SELECTIONS) {
                        this.checked = false;
                        alert('Solo puede seleccionar hasta ' + MAX_SELECTIONS + ' propiedades');
                    }
                });
            });
        });
    </script>

</x-app-layout>
