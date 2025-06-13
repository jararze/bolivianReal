@push('styles')
    <link href="{{ asset('assets/css/createpropertie.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <!-- Trumbowyg CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" />
@endpush

@push('scripts')
    <!-- jQuery primero (requerido por Trumbowyg) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Luego Trumbowyg -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>

    <!-- Después otros scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar Trumbowyg para el campo de descripción larga
            try {
                $('#long_description').trumbowyg({
                    btns: [
                        ['formatting'],
                        ['strong', 'em', 'del'],
                        ['superscript', 'subscript'],
                        ['link'],
                        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                        ['unorderedList', 'orderedList'],
                        ['horizontalRule'],
                        ['removeformat']
                    ],
                    autogrow: true
                });
                console.log('Trumbowyg initialized successfully');
            } catch (error) {
                console.error('Error initializing Trumbowyg:', error);
            }
        });
    </script>

    <script>
        // Función para cargar los barrios en base a la ciudad seleccionada
        function loadNeighborhoods(cityId) {
            const neighborhoodSelect = document.getElementById('neighborhood_id');

            // Limpiar opciones actuales
            neighborhoodSelect.innerHTML = '<option value="">Cargando barrios...</option>';

            if (!cityId) {
                neighborhoodSelect.innerHTML = '<option value="">Primero seleccione una ciudad</option>';
                return;
            }

            // Usar la URL generada por Laravel
            const url = `/api/neighborhoods/by-city/${cityId}`;

            // Realizar petición AJAX para obtener los barrios
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    neighborhoodSelect.innerHTML = '<option value="">Seleccione un barrio</option>';

                    data.forEach(neighborhood => {
                        const option = document.createElement('option');
                        option.value = neighborhood.id;
                        option.textContent = neighborhood.name;

                        // Marcar como seleccionado si coincide con el valor actual
                        if (neighborhood.id == {{ $property->neighborhood_id ?? 'null' }}) {
                            option.selected = true;
                        }

                        neighborhoodSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error cargando barrios:', error);
                    neighborhoodSelect.innerHTML = '<option value="">Error cargando barrios</option>';
                });
        }

        // Llamar a la función si hay una ciudad seleccionada por defecto
        document.addEventListener('DOMContentLoaded', function() {
            const citySelect = document.getElementById('city');
            if (citySelect && citySelect.value) {
                loadNeighborhoods(citySelect.value);
            }
        });
    </script>

    <!-- Si tienes el archivo createPropertie.js, úsalo en lugar de editProperty.js -->
    <script type="module" src="{{ asset('assets/js/createPropertie.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/editProperty.js') }}"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Propiedades') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.properties.index') }}">
                {{ __('Propiedades') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Editar Propiedad: {{ $property->name }}</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <form action="{{ route('backend.properties.update', $property->id) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if(session('error') || $errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    @if(session('error'))
                        <p>{{ session('error') }}</p>
                    @endif

                    @if($errors->any())
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex grow gap-5 lg:gap-7.5">
                <!-- Menú lateral -->
                <div class="hidden lg:block w-[230px] shrink-0">
                    <div class="w-[230px]" data-sticky="true" data-sticky-animation="true"
                         data-sticky-class="fixed z-[4] left-auto top-[3rem]" data-sticky-name="scrollspy"
                         data-sticky-offset="200" data-sticky-target="#scrollable_content">
                        <x-primary-button class="px-6 py-2 mb-3">{{ __('Guardar Cambios') }}</x-primary-button>
                        <!-- Menú de navegación -->
                        <div
                            class="flex flex-col grow relative before:absolute before:left-[11px] before:top-0 before:bottom-0 before:border-l before:border-gray-200"
                            data-scrollspy="true" data-scrollspy-offset="80px|lg:110px"
                            data-scrollspy-target="#scrollable_content">

                            <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-1.5 active border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                               data-scrollspy-anchor="true" href="#basic_info">
                            <span
                                class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                Información Básica
                            </a>
                            <div class="flex flex-col">
                                <div class="pl-6 pr-2.5 py-2.5 text-2sm font-semibold text-gray-900">
                                    Que tiene?
                                </div>
                                <div class="flex flex-col">
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#prices">
                                    <span
                                        class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Precios
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#spaces">
                                    <span
                                        class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Ambientes
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#description">
                                    <span
                                        class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Descripcion
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#imagesUpload">
                                    <span
                                        class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Imagen & Video Principal
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#location">
                                    <span
                                        class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Ubicacion
                                    </a>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="pl-6 pr-2.5 py-2.5 text-2sm font-semibold text-gray-900">
                                    Extras
                                </div>
                                <div class="flex flex-col">
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#features">
                                    <span
                                        class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Servicios cercanos
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#amenities">
                                    <span
                                        class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Amenities
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#extra-data">
                                    <span
                                        class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Datos Extras
                                    </a>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="pl-6 pr-2.5 py-2.5 text-2sm font-semibold text-gray-900">
                                    Proyecto
                                </div>
                                <div class="flex flex-col">
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#project">
                                    <span
                                        class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Pertenece a un proyecto?
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-stretch grow gap-5 lg:gap-7.5">
                    <!-- Información Básica -->
                    <div class="card p-6">
                        <div class="card-header mb-6" id="basic_info">
                            <h3 class="text-xl font-semibold">Información Básica</h3>
                        </div>
                        <div class="space-y-6">
                            <!-- Nombre -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="name" :value="__('Nombre')" class="text-gray-700"/>
                                <div class="col-span-3">
                                    <x-text-input id="name" name="name" type="text"
                                                  :value="old('name', $property->name)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('name')"/>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="address" :value="__('Direccion')" class="text-gray-700"/>
                                <div class="col-span-3">
                                    <x-text-input
                                        id="address"
                                        name="address"
                                        type="text"
                                        :value="old('address', $property->address)"
                                        class="w-full"
                                        placeholder="Ingresa la dirección y presiona Enter para buscar"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('address')"/>
                                </div>
                            </div>

                            <!-- Zona, Superficie terreno, Superficie Construido -->
                            <!-- En la sección de Información Básica, reemplaza la parte de Zona, Superficie terreno, Superficie Construido -->
                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="neighborhood_id" :value="__('Zona')" class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="neighborhood_id"
                                        name="neighborhood_id"
                                        :options="['' => 'Primero seleccione una ciudad']"
                                        selected="{{ old('neighborhood_id', $property->neighborhood_id) }}"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('neighborhood_id')"/>
                                </div>
                                <div>
                                    <x-input-label for="size" :value="__('Superficie terreno (MT2)')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-text-input id="size" name="size" type="number"
                                                  :value="old('size', $property->size)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('size')"/>
                                </div>
                                <div>
                                    <x-input-label for="size_max" :value="__('Superficie Construido (MT2)')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-text-input id="size_max" name="size_max" type="number"
                                                  :value="old('size_max', $property->size_max)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('size_max')"/>
                                </div>
                            </div>

                            <!-- También en la sección de Ciudad, agregar el onchange para cargar neighborhoods -->
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="city" :value="__('Ciudad')" class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="city"
                                        name="city"
                                        onchange="loadNeighborhoods(this.value)"
                                        :options="['' => 'Seleccione una ciudad'] + $cities->pluck('name', 'id')->toArray()"
                                        :selected="old('city', $property->city)"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('city')"/>
                                </div>
                                <div>
                                    <x-input-label for="country" :value="__('Pais')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="country" name="country" type="text"
                                                  :value="old('country', $property->country)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('country')"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Precios -->
                    <div class="card pb-2.5 mt-5">
                        <div class="card-header" id="prices">
                            <h3 class="card-title">Precios</h3>
                        </div>
                        <div class="card-body grid gap-5 pt-7.5">
                            <div class="grid grid-cols-4 gap-6">
                                <div>
                                    <x-input-label for="propertytype_id" :value="__('¿Tipo Propiedad?')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="propertytype_id"
                                        name="propertytype_id"
                                        :options="['' => 'Seleccione un tipo de propiedad'] + $propertyTypes->pluck('type_name', 'id')->toArray()"
                                        :selected="old('propertytype_id', $property->propertytype_id)"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('propertytype_id')"/>
                                </div>
                                <div>
                                    <x-input-label for="service_type_id" :value="__('¿Propiedad para?')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="service_type_id"
                                        name="service_type_id"
                                        :options="['' => 'Seleccione un servicio'] + $serviceTypes->pluck('name', 'id')->toArray()"
                                        :selected="old('service_type_id', $property->service_type_id)"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('service_type_id')"/>
                                </div>
                                <div>
                                    <x-input-label for="currency" :value="__('Moneda')" class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="currency"
                                        name="currency"
                                        :options="[
                                            'Bs' => 'Bolivianos',
                                            '$us' => 'Dólares'
                                        ]"
                                        :selected="old('currency', $property->currency)"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('currency')"/>
                                </div>
                                <div>
                                    <x-input-label for="chosen_currency" :value="__('¿Precio a mostrar?')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="chosen_currency"
                                        name="chosen_currency"
                                        :options="['1' => 'Bolivianos', '0' => 'Dolares']"
                                        :selected="old('chosen_currency', $property->chosen_currency)"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('chosen_currency')"/>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="lowest_price" :value="__('Precio minimo')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-text-input id="lowest_price" name="lowest_price" type="number"
                                                  :value="old('lowest_price', $property->lowest_price)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('lowest_price')"/>
                                </div>
                                <div>
                                    <x-input-label for="max_price" :value="__('Precio maximo')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-text-input id="max_price" name="max_price" type="number"
                                                  :value="old('max_price', $property->max_price)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('max_price')"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ambientes -->
                    <div class="card mt-5">
                        <div class="card-header" id="spaces">
                            <h3 class="card-title">Ambientes</h3>
                        </div>
                        <div class="card-body grid gap-5 pt-7.5">
                            <div class="grid grid-cols-4 gap-6">
                                <div>
                                    <x-input-label for="bedrooms" :value="__('Numero habitaciones')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-text-input id="bedrooms" name="bedrooms" type="number"
                                                  :value="old('bedrooms', $property->bedrooms)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('bedrooms')"/>
                                </div>
                                <div>
                                    <x-input-label for="bathrooms" :value="__('Numero de banos')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-text-input id="bathrooms" name="bathrooms" type="number"
                                                  :value="old('bathrooms', $property->bathrooms)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('bathrooms')"/>
                                </div>
                                <div>
                                    <x-input-label for="garage" :value="__('Espacios en el garaje')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-text-input id="garage" name="garage" type="number"
                                                  :value="old('garage', $property->garage)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('garage')"/>
                                </div>
                                <div>
                                    <x-input-label for="garage_size" :value="__('Superficie garaje en MT2')"
                                                   class="mb-2 text-gray-700"/>
                                    <x-text-input id="garage_size" name="garage_size" type="number"
                                                  :value="old('garage_size', $property->garage_size)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('garage_size')"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="card mt-5">
                        <div class="card-header mt-5" id="description">
                            <h3 class="card-title">Descripcion</h3>
                        </div>
                        <div class="card-body">
                            <div class="w-full">
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-7">
                                    <x-input-label for="short_description" :value="__('Descripcion corta')"
                                                   class="form-label max-w-56"/>
                                    <div class="flex flex-col tems-start grow gap-3 w-full">
                                        <x-text-input id="short_description" name="short_description" type="text"
                                                      :value="old('short_description', $property->short_description)"
                                                      required
                                                      autocomplete="short_description" class="w-full"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('short_description')"/>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-7">
                                    <x-input-label for="long_description" :value="__('Descripcion larga')"
                                                   class="form-label max-w-56"/>
                                    <div class="flex flex-col tems-start grow gap-3 w-full">
                                        <textarea
                                            id="long_description"
                                            name="long_description"
                                            placeholder="Descripción larga"
                                            rows="10"
                                            class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        >{{ old('long_description', $property->long_description) }}</textarea>
                                        <x-input-error class="mt-2" :messages="$errors->get('long_description')"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Imágenes -->
                    <div class="card my-5">
                        <div class="card-header" id="imagesUpload">
                            <h3 class="card-title">Imágenes</h3>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Imagen Principal -->
                                <div>
                                    <label class="text-gray-700 text-sm font-medium mb-2">Imagen Principal</label>
                                    <div class="mt-2">
                                        <div
                                            class="border-2 border-dashed border-gray-300 rounded-lg w-full h-[300px] relative">
                                            <input type="file"
                                                   id="thumbnail"
                                                   name="thumbnail"
                                                   accept="image/*"
                                                   class="hidden"
                                                   tabindex="-1"
                                            />
                                            @error('thumbnail')
                                            <div class="alert alert-danger mt-2">
                                                @foreach($errors->get('thumbnail') as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @enderror
                                            <!-- Área de vista previa -->
                                            <div id="thumbnail-preview-area"
                                                 class="w-full h-full flex flex-col items-center justify-center cursor-pointer">
                                                @if($property->thumbnail)
                                                    <img id="thumbnail-preview"
                                                         src="{{ asset('storage/' . $property->thumbnail) }}"
                                                         alt="Imagen principal" class="max-h-full object-cover">
                                                    <div id="thumbnail-placeholder" class="text-center hidden">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                             stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                        </svg>
                                                        <p class="mt-1 text-sm text-gray-500">Click para cambiar<br>(PNG,
                                                            JPG)
                                                        </p>
                                                    </div>
                                                @else
                                                    <img id="thumbnail-preview" src="" alt=""
                                                         class="max-h-full hidden object-cover">
                                                    <div id="thumbnail-placeholder" class="text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                             stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                        </svg>
                                                        <p class="mt-1 text-sm text-gray-500">Click para subir<br>(PNG,
                                                            JPG)
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Botón de eliminar -->
                                            <button type="button"
                                                    id="remove-thumbnail"
                                                    class="absolute top-2 right-2 {{ $property->thumbnail ? '' : 'hidden' }} bg-white rounded-full p-1 shadow-sm hover:bg-gray-100">
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <x-input-error class="mt-2" :messages="$errors->get('thumbnail')"/>
                                    </div>
                                </div>

                                <!-- Área de Drop para Imágenes Adicionales -->
                                <div>
                                    <label class="text-gray-700 text-sm font-medium mb-2">Imágenes Adicionales</label>
                                    <div class="mt-2">
                                        <div
                                            class="border-2 border-dashed border-gray-300 rounded-lg h-[300px] relative flex items-center justify-center hover:cursor"
                                            id="drop-zone">
                                            <input type="file"
                                                   id="additional-images"
                                                   name="images[]"
                                                   multiple
                                                   accept="image/*"
                                                   class="hidden"
                                            />

                                            <!-- Mensajes de error para imágenes -->
                                            @if($errors->has('images.*') || $errors->has('images'))
                                                <div
                                                    class="alert alert-danger mt-2 absolute top-2 left-2 right-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                                    @foreach($errors->get('images') as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach

                                                    @foreach($errors->get('images.*') as $index => $messages)
                                                        @foreach($messages as $message)
                                                            <div>
                                                                Imagen {{ intval(str_replace('images.', '', $index)) + 1 }}
                                                                : {{ $message }}</div>
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div id="drop-placeholder" class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                     stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mt-1 text-sm text-gray-500">Arrastra más imágenes aquí<br>o
                                                    click para seleccionar</p>
                                            </div>
                                        </div>

                                        <!-- Mensaje de error adicional fuera del área de drop -->
                                        @if($errors->has('images.*') || $errors->has('images'))
                                            <div class="mt-2 p-2 bg-red-100 border border-red-400 text-red-700 rounded">
                                                @foreach($errors->get('images') as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach

                                                @foreach($errors->get('images.*') as $index => $messages)
                                                    @foreach($messages as $message)
                                                        <div>Imagen {{ intval(str_replace('images.', '', $index)) + 1 }}
                                                            : {{ $message }}</div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Grid de imágenes existentes -->
                            <div class="mt-6">
                                <h4 class="text-gray-700 text-sm font-medium mb-2">Imágenes Actuales</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4" id="existing-images">
                                    @foreach($property->images as $index => $image)
                                        <div class="relative group image-container" data-image-id="{{ $image->id }}">
                                            <img src="{{ asset('storage/' . $image->name) }}"
                                                 alt="Imagen de propiedad"
                                                 class="w-full h-32 object-cover rounded">
                                            <button type="button"
                                                    class="delete-image absolute top-2 right-2 bg-red-500 text-white rounded-full p-1
                                                        opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            <input type="hidden" name="delete_images[{{ $index }}]" value="0"
                                                   class="delete-image-input">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Grid de vista previa de imágenes nuevas -->
                            <div class="mt-6">
                                <h4 class="text-gray-700 text-sm font-medium mb-2">Vista previa de nuevas imágenes</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4"
                                     id="preview-grid"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Ubicación -->
                    <div class="card">
                        <div class="card-header" id="location">
                            <h3 class="card-title">Ubicación</h3>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-4 gap-4 items-center mb-6">
                                <x-input-label for="address2" :value="__('Buscar ubicacion')" class="text-gray-700"/>
                                <div class="col-span-3">
                                    <x-text-input
                                        id="address2"
                                        name="address2"
                                        type="text"
                                        :value="old('address2', $property->address)"
                                        class="w-full"
                                        placeholder="Ingresa la dirección y presiona Enter para buscar"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('address2')"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Latitud -->
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="latitude" :value="__('Latitud')"
                                                       class="form-label max-w-56"/>
                                        <div class="flex flex-col items-start grow gap-3 w-full">
                                            <x-text-input
                                                id="latitude"
                                                name="latitude"
                                                type="text"
                                                :value="old('latitude', $property->latitude)"
                                                class="w-full"
                                                placeholder="-17.123456"
                                            />
                                            <x-input-error class="mt-2" :messages="$errors->get('latitude')"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Longitud -->
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="longitude" :value="__('Longitud')"
                                                       class="form-label max-w-56"/>
                                        <div class="flex flex-col items-start grow gap-3 w-full">
                                            <x-text-input
                                                id="longitude"
                                                name="longitude"
                                                type="text"
                                                :value="old('longitude', $property->longitude)"
                                                class="w-full"
                                                placeholder="-66.123456"
                                            />
                                            <x-input-error class="mt-2" :messages="$errors->get('longitude')"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mapa -->
                            <div id="map" class="w-full h-[400px] rounded-lg overflow-hidden"></div>
                            <input type="hidden" id="map-initial-lat" value="{{ $property->latitude }}">
                            <input type="hidden" id="map-initial-lng" value="{{ $property->longitude }}">
                        </div>
                    </div>

                    <!-- Servicios cercanos -->
                    <div class="card my-5">
                        <div class="card-header" id="features">
                            <h3 class="card-title">Servicios cercanos</h3>
                        </div>
                        <div class="card-body">
                            <div id="services-container" class="space-y-4">
                                @if($property->facilities->count() > 0)
                                    @foreach($property->facilities as $index => $facility)
                                        <div class="service-row grid grid-cols-12 gap-4 items-start">
                                            <div class="col-span-4">
                                                <x-select-input
                                                    class="w-full"
                                                    name="features[]"
                                                    :options="['' => 'Seleccione un servicio'] + $features->pluck('name', 'id')->toArray()"
                                                    :selected="old('features.'.$index, $facility->pivot->facility_id)"
                                                />
                                            </div>
                                            <div class="col-span-4">
                                                <x-text-input
                                                    name="place_names[]"
                                                    type="text"
                                                    :value="old('place_names.'.$index, $facility->pivot->name)"
                                                    class="w-full"
                                                    placeholder="Nombre del servicio"
                                                />
                                            </div>
                                            <div class="col-span-3">
                                                <x-text-input
                                                    name="distances[]"
                                                    type="text"
                                                    :value="old('distances.'.$index, $facility->pivot->distance)"
                                                    class="w-full"
                                                    placeholder="Distancia (Cuadras)"
                                                />
                                            </div>
                                            <div class="col-span-1 flex justify-end">
                                                @if($index === 0)
                                                    <button type="button"
                                                            class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600 add-service">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                @else
                                                    <button type="button"
                                                            class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-service">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Fila inicial si no hay servicios -->
                                    <div class="service-row grid grid-cols-12 gap-4 items-start">
                                        <div class="col-span-4">
                                            <x-select-input
                                                class="w-full"
                                                name="features[]"
                                                :options="['' => 'Seleccione un servicio'] + $features->pluck('name', 'id')->toArray()"
                                                :selected="old('features.0')"
                                            />
                                        </div>
                                        <div class="col-span-4">
                                            <x-text-input
                                                name="place_names[]"
                                                type="text"
                                                :value="old('place_names.0')"
                                                class="w-full"
                                                placeholder="Nombre del servicio"
                                            />
                                        </div>
                                        <div class="col-span-3">
                                            <x-text-input
                                                name="distances[]"
                                                type="text"
                                                :value="old('distances.0')"
                                                class="w-full"
                                                placeholder="Distancia (Cuadras)"
                                            />
                                        </div>
                                        <div class="col-span-1 flex justify-end">
                                            <button type="button"
                                                    class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600 add-service">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Amenidades -->
                    <div class="card">
                        <div class="card-header" id="amenities">
                            <h3 class="card-title">Amenidades</h3>
                        </div>
                        <div class="card-body">
                            <div class="w-full">
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                    <x-input-label :value="__('Selecciona las amenidades')" class="form-label w-full"/>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full mt-3">
                                        @foreach($amenities as $amenity)
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                       name="amenities[]"
                                                       value="{{ $amenity->id }}"
                                                       {{ (is_array(old('amenities', $property->amenities->pluck('id')->toArray())) &&
                                                           in_array($amenity->id, old('amenities', $property->amenities->pluck('id')->toArray()))) ? 'checked' : '' }}
                                                       class="rounded border-gray-300 text-blue-600 shadow-sm">
                                                <span class="ml-2">{{ $amenity->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos Extras -->
                    <div class="card my-5">
                        <div class="card-header" id="extra-data">
                            <h3 class="card-title">Datos Extras</h3>
                        </div>
                        <div class="card-body grid gap-5">
                            <!-- URL del Video -->
                            <div class="w-full">
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                    <x-input-label for="video" :value="__('URL del Video')"
                                                   class="form-label max-w-56"/>
                                    <div class="flex flex-col items-start grow gap-3 w-full">
                                        <x-text-input id="video" name="video" type="url"
                                                      :value="old('video', $property->video)"
                                                      placeholder="https://youtube.com/..." class="w-full"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('video')"/>
                                    </div>
                                </div>
                            </div>

                            <!-- Toggles -->
                            <div class="w-full">
                                <div class="space-y-4">
                                    <!-- Featured Toggle -->
                                    <div
                                        class="flex items-center justify-between flex-wrap border border-gray-200 rounded-xl gap-2 px-3.5 py-2.5">
                                        <div class="flex items-center flex-wrap gap-3.5">
                                            <div
                                                class="relative size-[50px] shrink-0 bg-gray-100 rounded-xl flex items-center justify-center">
                                                <i class="ki-solid ki-star text-xl text-gray-500"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900">Destacado</span>
                                                <span
                                                    class="text-2sm text-gray-700">Marcar propiedad como destacada.</span>
                                            </div>
                                        </div>
                                        <label class="switch switch-sm">
                                            <input type="checkbox" name="featured"
                                                   value="1" {{ old('featured', $property->featured) ? 'checked' : '' }}>
                                        </label>
                                    </div>

                                    <!-- Hot Property Toggle -->
                                    <div
                                        class="flex items-center justify-between flex-wrap border border-gray-200 rounded-xl gap-2 px-3.5 py-2.5">
                                        <div class="flex items-center flex-wrap gap-3.5">
                                            <div
                                                class="relative size-[50px] shrink-0 bg-gray-100 rounded-xl flex items-center justify-center">
                                                <i class="ki-solid ki-fire text-xl text-gray-500"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900">Hot Property</span>
                                                <span
                                                    class="text-2sm text-gray-700">Marcar como propiedad en demanda.</span>
                                            </div>
                                        </div>
                                        <label class="switch switch-sm">
                                            <input type="checkbox" name="hot"
                                                   value="1" {{ old('hot', $property->hot) ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Selects -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Agente -->
                                <div class="w-full">
                                    <div class="flex items-baseline gap-2.5">
                                        <x-input-label for="agent_id" :value="__('Agente')"
                                                       class="form-label w-24 shrink-0"/>
                                        <div class="grow">
                                            <x-select-input
                                                class="w-full"
                                                id="agent_id"
                                                name="agent_id"
                                                :options="['' => 'Seleccione un Agente'] + $agents->pluck('name', 'id')->toArray()"
                                                :selected="old('agent_id', $property->agent_id)"
                                            />
                                            <x-input-error class="mt-2" :messages="$errors->get('agent_id')"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="w-full">
                                    <div class="flex items-baseline gap-2.5">
                                        <x-input-label for="status" :value="__('Estado')"
                                                       class="form-label w-24 shrink-0"/>
                                        <div class="grow">
                                            <x-select-input
                                                onchange="toggleProjectFields(this.value)"
                                                class="w-full"
                                                id="status"
                                                name="status"
                                                :options="['1' => 'Activo', '0' => 'Inactivo']"
                                                :selected="old('status', $property->status)"
                                            />
                                            <x-input-error class="mt-2" :messages="$errors->get('status')"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Proyecto -->
                    <div class="card mt-5">
                        <div class="card-header" id="project">
                            <h3 class="card-title">Información de Proyecto</h3>
                        </div>
                        <div class="card-body grid gap-5">
                            <!-- ¿Es proyecto? -->
                            <div class="w-full">
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                    <x-input-label for="is_project" :value="__('¿Proyecto?')"
                                                   class="form-label max-w-56"/>
                                    <div class="grow">
                                        <x-select-input
                                            onchange="toggleProjectFields(this.value)"
                                            class="w-full"
                                            id="is_project"
                                            name="is_project"
                                            :options="['1' => 'Si', '0' => 'No']"
                                            :selected="old('is_project', $property->is_project)"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Campos de proyecto -->
                            <div id="project-fields" class="space-y-5"
                                 style="{{ $property->is_project ? '' : 'display: none;' }}">
                                <!-- Unidades -->
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="units" :value="__('Unidades')" class="form-label max-w-56"/>
                                        <div class="flex flex-col items-start grow gap-3 w-full">
                                            <x-text-input id="units" name="units" type="number"
                                                          :value="old('units', $property->units)"
                                                          class="w-full" {{ $property->is_project ? '' : 'disabled' }}/>
                                            <x-input-error class="mt-2" :messages="$errors->get('units')"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Proyecto asociado -->
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="project_id" :value="__('Proyecto asociado')"
                                                       class="form-label max-w-56"/>
                                        <div class="grow">
                                            <x-select-input
                                                class="w-full"
                                                id="project_id"
                                                name="project_id"
                                                :options="['' => 'Seleccione un proyecto'] + $projects->pluck('name', 'id')->toArray()"
                                                :selected="old('project_id', $property->project_id)"
                                            />
                                            <x-input-error class="mt-2" :messages="$errors->get('project_id')"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Función para mostrar/ocultar campos de proyecto
        function toggleProjectFields(value) {
            const projectFields = document.getElementById('project-fields');
            const unitsField = document.getElementById('units');

            if (value === '1') {
                projectFields.style.display = '';
                unitsField.disabled = false;
            } else {
                projectFields.style.display = 'none';
                unitsField.disabled = true;
            }
        }

        // Script para manejar la adición de servicios
        document.addEventListener('DOMContentLoaded', function () {
            // Agregar nuevo servicio
            document.querySelectorAll('.add-service').forEach(button => {
                button.addEventListener('click', function () {
                    const container = document.getElementById('services-container');
                    const serviceRows = container.querySelectorAll('.service-row');
                    const newRow = serviceRows[0].cloneNode(true);

                    // Resetear valores
                    newRow.querySelectorAll('input, select').forEach(input => {
                        if (input.type === 'text' || input.tagName === 'SELECT') {
                            input.value = '';
                        }
                    });

                    // Cambiar botón de agregar por botón de eliminar
                    const addButton = newRow.querySelector('.add-service');
                    if (addButton) {
                        const removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.className = 'p-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-service';
                        removeButton.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        `;

                        removeButton.addEventListener('click', function () {
                            this.closest('.service-row').remove();
                        });

                        addButton.parentNode.replaceChild(removeButton, addButton);
                    }

                    container.appendChild(newRow);
                });
            });

            // Eliminar servicio (para los botones existentes)
            document.querySelectorAll('.remove-service').forEach(button => {
                button.addEventListener('click', function () {
                    this.closest('.service-row').remove();
                });
            });

            // Manejar vista previa de imagen principal
            const thumbnailInput = document.getElementById('thumbnail');
            const thumbnailPreview = document.getElementById('thumbnail-preview');
            const thumbnailPlaceholder = document.getElementById('thumbnail-placeholder');
            const removeThumbnail = document.getElementById('remove-thumbnail');
            const thumbnailPreviewArea = document.getElementById('thumbnail-preview-area');

            if (thumbnailPreviewArea) {
                thumbnailPreviewArea.addEventListener('click', function () {
                    thumbnailInput.click();
                });
            }

            if (thumbnailInput) {
                thumbnailInput.addEventListener('change', function (e) {
                    if (e.target.files.length > 0) {
                        const file = e.target.files[0];
                        thumbnailPreview.src = URL.createObjectURL(file);
                        thumbnailPreview.classList.remove('hidden');
                        thumbnailPlaceholder.classList.add('hidden');
                        removeThumbnail.classList.remove('hidden');
                    }
                });
            }

            if (removeThumbnail) {
                removeThumbnail.addEventListener('click', function () {
                    thumbnailInput.value = '';
                    thumbnailPreview.src = '';
                    thumbnailPreview.classList.add('hidden');
                    thumbnailPlaceholder.classList.remove('hidden');
                    this.classList.add('hidden');

                    // Agregar campo para marcar la eliminación de la imagen actual
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'remove_thumbnail';
                    hiddenInput.value = '1';
                    document.querySelector('form').appendChild(hiddenInput);
                });
            }

            // Manejar drag & drop y vista previa de imágenes adicionales
            const dropZone = document.getElementById('drop-zone');
            const additionalImages = document.getElementById('additional-images');
            const previewGrid = document.getElementById('preview-grid');

            if (dropZone) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, unhighlight, false);
                });

                function highlight() {
                    dropZone.classList.add('border-primary');
                }

                function unhighlight() {
                    dropZone.classList.remove('border-primary');
                }

                dropZone.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;

                    if (files.length > 0) {
                        additionalImages.files = files;
                        updateImagePreviews(files);
                    }
                }

                dropZone.addEventListener('click', function () {
                    additionalImages.click();
                });

                additionalImages.addEventListener('change', function () {
                    updateImagePreviews(this.files);
                });

                function updateImagePreviews(files) {
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];

                        // Solo procesar imágenes
                        if (!file.type.match('image.*')) continue;

                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const previewContainer = document.createElement('div');
                            previewContainer.className = 'relative group';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = 'Vista previa';
                            img.className = 'w-full h-32 object-cover rounded';

                            const removeButton = document.createElement('button');
                            removeButton.type = 'button';
                            removeButton.className = 'absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity';
                            removeButton.innerHTML = `
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            `;

                            removeButton.addEventListener('click', function () {
                                previewContainer.remove();
                                // Crea una nueva lista de archivos sin el archivo eliminado
                                updateFileInputAfterRemoval(file);
                            });

                            previewContainer.appendChild(img);
                            previewContainer.appendChild(removeButton);
                            previewGrid.appendChild(previewContainer);
                        };

                        reader.readAsDataURL(file);
                    }
                }

                function updateFileInputAfterRemoval(fileToRemove) {
                    const dt = new DataTransfer();
                    const files = additionalImages.files;

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        if (file !== fileToRemove) {
                            dt.items.add(file);
                        }
                    }

                    additionalImages.files = dt.files;
                }
            }

            // Inicializar mapa con posición actual de la propiedad
            const initialLat = document.getElementById('map-initial-lat').value || -16.5;
            const initialLng = document.getElementById('map-initial-lng').value || -68.15;

            if (typeof L !== 'undefined') {
                const map = L.map('map').setView([initialLat, initialLng], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Agregar marcador inicial
                let marker = L.marker([initialLat, initialLng], {
                    draggable: true
                }).addTo(map);

                // Actualizar campos al mover el marcador
                marker.on('dragend', function (e) {
                    const position = marker.getLatLng();
                    document.getElementById('latitude').value = position.lat.toFixed(6);
                    document.getElementById('longitude').value = position.lng.toFixed(6);
                });

                // Geocodificación para buscar direcciones
                const geocoder = L.Control.Geocoder.nominatim();

                document.getElementById('address2').addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = this.value;

                        geocoder.geocode(query, function (results) {
                            if (results && results.length > 0) {
                                const result = results[0];
                                const latlng = result.center;

                                map.setView(latlng, 16);
                                marker.setLatLng(latlng);

                                document.getElementById('latitude').value = latlng.lat.toFixed(6);
                                document.getElementById('longitude').value = latlng.lng.toFixed(6);
                            }
                        });
                    }
                });
            }
        });
    </script>
</x-app-layout>
