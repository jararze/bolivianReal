@push('styles')
    <link href="{{ asset('assets/css/createpropertie.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" />
@endpush

@push('scripts')
    <!-- jQuery primero (requerido por Trumbowyg) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Luego Trumbowyg -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>
    <!-- Leaflet scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">{{ __('Propiedades') }}</h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.properties.index') }}">
                {{ __('Propiedades') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Agregar Nueva</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <form action="{{ route('backend.properties.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                        <x-primary-button class="px-6 py-2 mb-3">{{ __('Crear Propiedad') }}</x-primary-button>
                        <!-- Menú de navegación -->
                        <div class="flex flex-col grow relative before:absolute before:left-[11px] before:top-0 before:bottom-0 before:border-l before:border-gray-200"
                             data-scrollspy="true" data-scrollspy-offset="80px|lg:110px" data-scrollspy-target="#scrollable_content">

                            <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-1.5 active border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                               data-scrollspy-anchor="true" href="#basic_info">
                                <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                Información Básica
                            </a>
                            <div class="flex flex-col">
                                <div class="pl-6 pr-2.5 py-2.5 text-2sm font-semibold text-gray-900">
                                    Que tiene?
                                </div>
                                <div class="flex flex-col">
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#prices">
                                        <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Precios
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#spaces">
                                        <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Ambientes
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#description">
                                        <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Descripcion
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#imagesUpload">
                                        <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Imagen & Video Principal
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#location">
                                        <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
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
                                        <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Servicios cercanos
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#amenities">
                                        <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
                                        Amenities
                                    </a>
                                    <a class="flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 gap-3.5 border border-transparent text-2sm text-gray-800 hover:text-primary hover:font-medium scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100"
                                       data-scrollspy-anchor="true" href="#extra-data">
                                        <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
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
                                        <span class="flex w-1.5 relative before:absolute before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"></span>
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
                                    <x-text-input id="name" name="name" type="text" :value="old('name')" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('name')"/>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="address" :value="__('Direccion')" class="text-gray-700"/>
                                <div class="col-span-3">
                                    <x-text-input id="address" name="address" type="text" :value="old('address')" class="w-full" placeholder="Ingresa la dirección y presiona Enter para buscar"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('address')"/>
                                </div>
                            </div>

                            <!-- Zona, Superficie terreno, Superficie Construido -->
                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="neighborhood_id" :value="__('Zona')" class="mb-2 text-gray-700"/>
                                    <x-select-input class="w-full" id="neighborhood_id" name="neighborhood_id" :options="['' => 'Primero seleccione una ciudad']" selected="{{ old('neighborhood_id') }}"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('neighborhood_id')"/>
                                </div>
                                <div>
                                    <x-input-label for="size" :value="__('Superficie terreno (MT2)')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="size" name="size" type="number" :value="old('size')" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('size')"/>
                                </div>
                                <div>
                                    <x-input-label for="size_max" :value="__('Superficie Construido (MT2)')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="size_max" name="size_max" type="number" :value="old('size_max')" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('size_max')"/>
                                </div>
                            </div>

                            <!-- Ciudad y País -->
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="city" :value="__('Ciudad')" class="mb-2 text-gray-700"/>
                                    <x-select-input class="w-full" id="city" name="city" onchange="loadNeighborhoods(this.value)" :options="['' => 'Seleccione una ciudad'] + $cities->pluck('name', 'id')->toArray()" selected="{{ old('city') }}"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('city')"/>
                                </div>
                                <div>
                                    <x-input-label for="country" :value="__('Pais')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="country" name="country" type="text" :value="old('country')" class="w-full"/>
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
                                    <x-input-label for="propertytype_id" :value="__('¿Tipo Propiedad?')" class="mb-2 text-gray-700"/>
                                    <x-select-input class="w-full" id="propertytype_id" name="propertytype_id" :options="['' => 'Seleccione un tipo de propiedad'] + $propertyTypes->pluck('type_name', 'id')->toArray()" selected="{{ old('propertytype_id') }}"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('propertytype_id')"/>
                                </div>
                                <div>
                                    <x-input-label for="service_type_id" :value="__('¿Propiedad para?')" class="mb-2 text-gray-700"/>
                                    <x-select-input class="w-full" id="service_type_id" name="service_type_id" :options="['' => 'Seleccione un servicio'] + $serviceTypes->pluck('name', 'id')->toArray()" selected="{{ old('service_type_id') }}"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('service_type_id')"/>
                                </div>
                                <div>
                                    <x-input-label for="currency" :value="__('Moneda')" class="mb-2 text-gray-700"/>
                                    <x-select-input class="w-full" id="currency" name="currency" :options="['Bs' => 'Bolivianos', '$us' => 'Dólares']" selected="{{ old('currency', 'Bs') }}"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('currency')"/>
                                </div>
                                <div>
                                    <x-input-label for="chosen_currency" :value="__('¿Precio a mostrar?')" class="mb-2 text-gray-700"/>
                                    <x-select-input class="w-full" id="chosen_currency" name="chosen_currency" :options="['1' => 'Bolivianos', '0' => 'Dolares']" selected="1"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('chosen_currency')"/>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="lowest_price" :value="__('Precio minimo')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="lowest_price" name="lowest_price" type="number" :value="old('lowest_price')" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('lowest_price')"/>
                                </div>
                                <div>
                                    <x-input-label for="max_price" :value="__('Precio maximo')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="max_price" name="max_price" type="number" :value="old('max_price')" class="w-full"/>
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
                                    <x-input-label for="bedrooms" :value="__('Numero habitaciones')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="bedrooms" name="bedrooms" type="number" :value="old('bedrooms')" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('bedrooms')"/>
                                </div>
                                <div>
                                    <x-input-label for="bathrooms" :value="__('Numero de banos')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="bathrooms" name="bathrooms" type="number" :value="old('bathrooms')" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('bathrooms')"/>
                                </div>
                                <div>
                                    <x-input-label for="garage" :value="__('Espacios en el garaje')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="garage" name="garage" type="number" :value="old('garage')" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('garage')"/>
                                </div>
                                <div>
                                    <x-input-label for="garage_size" :value="__('Superficie garaje en MT2')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="garage_size" name="garage_size" type="number" :value="old('garage_size')" class="w-full"/>
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
                                    <x-input-label for="short_description" :value="__('Descripcion corta')" class="form-label max-w-56"/>
                                    <div class="flex flex-col tems-start grow gap-3 w-full">
                                        <x-text-input id="short_description" name="short_description" type="text" :value="old('short_description')" required autocomplete="short_description" class="w-full"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('short_description')"/>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-7">
                                    <x-input-label for="long_description" :value="__('Descripcion larga')" class="form-label max-w-56"/>
                                    <div class="flex flex-col tems-start grow gap-3 w-full">
                                        <textarea id="long_description" name="long_description" placeholder="Descripción larga" rows="10" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('long_description') }}</textarea>
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
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg w-full h-[300px] relative">
                                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="hidden"/>
                                            @error('thumbnail')
                                            <div class="alert alert-danger mt-2">
                                                @foreach($errors->get('thumbnail') as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @enderror
                                            <div id="thumbnail-preview-area" class="w-full h-full flex flex-col items-center justify-center cursor-pointer">
                                                <img id="thumbnail-preview" src="" alt="" class="max-h-full max-w-full hidden object-cover">
                                                <div id="thumbnail-placeholder" class="text-center">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                    </svg>
                                                    <p class="mt-1 text-sm text-gray-500">Click para subir<br>(PNG, JPG)</p>
                                                </div>
                                            </div>
                                            <button type="button" id="remove-thumbnail" class="absolute top-2 right-2 hidden bg-white rounded-full p-1 shadow-sm hover:bg-gray-100">
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg h-[300px] relative cursor-pointer transition-colors hover:border-blue-400" id="drop-zone">
                                            <input type="file" id="additional-images" name="images[]" multiple accept="image/*" class="hidden"/>
                                            <div id="drop-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mt-1 text-sm text-gray-500">Arrastra las imágenes aquí<br>o click para seleccionar</p>
                                            </div>
                                        </div>
                                        @if($errors->has('images.*') || $errors->has('images'))
                                            <div class="mt-2 p-2 bg-red-100 border border-red-400 text-red-700 rounded">
                                                <strong>Errores en imágenes:</strong>
                                                @foreach($errors->get('images') as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                                @foreach($errors->get('images.*') as $index => $messages)
                                                    @foreach($messages as $message)
                                                        <div>Imagen {{ intval(str_replace('images.', '', $index)) + 1 }}: {{ $message }}</div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Grid de vista previa de imágenes adicionales -->
                            <div class="mt-6">
                                <h4 class="text-gray-700 text-sm font-medium mb-2">Vista previa de imágenes</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4" id="preview-grid"></div>
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
                                    <x-text-input id="address2" name="address2" type="text" :value="old('address2')" class="w-full" placeholder="Ingresa la dirección y presiona Enter para buscar"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('address2')"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="latitude" :value="__('Latitud')" class="form-label max-w-56"/>
                                        <div class="flex flex-col items-start grow gap-3 w-full">
                                            <x-text-input id="latitude" name="latitude" type="text" :value="old('latitude')" class="w-full" placeholder="-17.123456"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('latitude')"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="longitude" :value="__('Longitud')" class="form-label max-w-56"/>
                                        <div class="flex flex-col items-start grow gap-3 w-full">
                                            <x-text-input id="longitude" name="longitude" type="text" :value="old('longitude')" class="w-full" placeholder="-66.123456"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('longitude')"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="map" class="w-full h-[400px] rounded-lg overflow-hidden"></div>
                        </div>
                    </div>

                    <!-- Servicios cercanos -->
                    <div class="card my-5">
                        <div class="card-header" id="features">
                            <h3 class="card-title">Servicios cercanos</h3>
                        </div>
                        <div class="card-body">
                            <div id="services-container" class="space-y-4">
                                <div class="service-row grid grid-cols-12 gap-4 items-start">
                                    <div class="col-span-4">
                                        <x-select-input class="w-full" id="features" name="features[]" :options="['' => 'Seleccione un servicio'] + $features->pluck('name', 'id')->toArray()" :selected="old('features.0')"/>
                                    </div>
                                    <div class="col-span-4">
                                        <x-text-input id="place_names" name="place_names[]" type="text" :value="old('place_names.0')" class="w-full" placeholder="Nombre del servicio"/>
                                    </div>
                                    <div class="col-span-3">
                                        <x-text-input id="distances" name="distances[]" type="text" :value="old('distances.0')" class="w-full" placeholder="Distancia (Cuadras)"/>
                                    </div>
                                    <div class="col-span-1 flex justify-end">
                                        <button type="button" class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600 add-service">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
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
                                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" {{ is_array(old('amenities')) && in_array($amenity->id, old('amenities')) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
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
                                    <x-input-label for="video" :value="__('URL del Video')" class="form-label max-w-56"/>
                                    <div class="flex flex-col items-start grow gap-3 w-full">
                                        <x-text-input id="video" name="video" type="url" :value="old('video')" placeholder="https://youtube.com/..." class="w-full"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('video')"/>
                                    </div>
                                </div>
                            </div>

                            <!-- Toggles -->
                            <div class="w-full">
                                <div class="space-y-4">
                                    <!-- Featured Toggle -->
                                    <div class="flex items-center justify-between flex-wrap border border-gray-200 rounded-xl gap-2 px-3.5 py-2.5">
                                        <div class="flex items-center flex-wrap gap-3.5">
                                            <div class="relative size-[50px] shrink-0 bg-gray-100 rounded-xl flex items-center justify-center">
                                                <i class="ki-solid ki-star text-xl text-gray-500"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900">Destacado</span>
                                                <span class="text-2sm text-gray-700">Marcar propiedad como destacada.</span>
                                            </div>
                                        </div>
                                        <label class="switch switch-sm">
                                            <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                                        </label>
                                    </div>

                                    <!-- Hot Property Toggle -->
                                    <div class="flex items-center justify-between flex-wrap border border-gray-200 rounded-xl gap-2 px-3.5 py-2.5">
                                        <div class="flex items-center flex-wrap gap-3.5">
                                            <div class="relative size-[50px] shrink-0 bg-gray-100 rounded-xl flex items-center justify-center">
                                                <i class="ki-solid ki-fire text-xl text-gray-500"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900">Hot Property</span>
                                                <span class="text-2sm text-gray-700">Marcar como propiedad en demanda.</span>
                                            </div>
                                        </div>
                                        <label class="switch switch-sm">
                                            <input type="checkbox" name="hot" value="1" {{ old('hot') ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Selects -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Agente -->
                                <div class="w-full">
                                    <div class="flex items-baseline gap-2.5">
                                        <x-input-label for="agent_id" :value="__('Agente')" class="form-label w-24 shrink-0"/>
                                        <div class="grow">
                                            <x-select-input class="w-full" id="agent_id" name="agent_id" :options="['' => 'Seleccione un Agente'] + $agents->pluck('name', 'id')->toArray()" selected="{{ old('agent_id') }}"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('agent_id')"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="w-full">
                                    <div class="flex items-baseline gap-2.5">
                                        <x-input-label for="status" :value="__('Estado')" class="form-label w-24 shrink-0"/>
                                        <div class="grow">
                                            <x-select-input class="w-full" id="status" name="status" :options="['1' => 'Activo', '0' => 'Inactivo']" selected="1"/>
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
                                    <x-input-label for="is_project" :value="__('¿Proyecto?')" class="form-label max-w-56"/>
                                    <div class="grow">
                                        <x-select-input onchange="toggleProjectFields(this.value)" class="w-full" id="is_project" name="is_project" :options="['1' => 'Si', '0' => 'No']" selected="0"/>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos de proyecto -->
                            <div id="project-fields" class="space-y-5" style="display: none;">
                                <!-- Unidades -->
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="units" :value="__('Unidades')" class="form-label max-w-56"/>
                                        <div class="flex flex-col items-start grow gap-3 w-full">
                                            <x-text-input id="units" name="units" type="number" :value="old('units')" class="w-full" disabled/>
                                            <x-input-error class="mt-2" :messages="$errors->get('units')"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Proyecto asociado -->
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="project_id" :value="__('Proyecto asociado')" class="form-label max-w-56"/>
                                        <div class="grow">
                                            <x-select-input class="w-full" id="project_id" name="project_id" :options="['' => 'Seleccione un proyecto'] + $projects->pluck('name', 'id')->toArray()" selected="{{ old('project_id') }}"/>
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

    <!-- SCRIPT ÚNICO Y LIMPIO -->
    <script>
        // Evitar múltiples inicializaciones
        if (!window.createPropertyInitialized) {
            window.createPropertyInitialized = true;

            document.addEventListener('DOMContentLoaded', function() {
                console.log('🚀 Iniciando PropertyCreate v2.0');

                // ========== VARIABLES GLOBALES ==========
                let selectedNewFiles = [];
                let mapInstance = null;

                // ========== INICIALIZAR TRUMBOWYG ==========
                if (typeof $ !== 'undefined' && $.fn.trumbowyg) {
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
                        console.log('✅ Trumbowyg inicializado');
                    } catch (error) {
                        console.error('❌ Error inicializando Trumbowyg:', error);
                    }
                }

                // ========== FUNCIÓN: THUMBNAIL ==========
                function initThumbnail() {
                    const input = document.getElementById('thumbnail');
                    const preview = document.getElementById('thumbnail-preview');
                    const placeholder = document.getElementById('thumbnail-placeholder');
                    const removeBtn = document.getElementById('remove-thumbnail');
                    const previewArea = document.getElementById('thumbnail-preview-area');

                    if (!input || !previewArea) return;

                    previewArea.addEventListener('click', () => input.click());

                    input.addEventListener('change', function(e) {
                        if (e.target.files[0]) {
                            const file = e.target.files[0];
                            preview.src = URL.createObjectURL(file);
                            preview.classList.remove('hidden');
                            placeholder.classList.add('hidden');
                            removeBtn.classList.remove('hidden');
                        }
                    });

                    removeBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        input.value = '';
                        preview.src = '';
                        preview.classList.add('hidden');
                        placeholder.classList.remove('hidden');
                        this.classList.add('hidden');
                    });
                }

                // ========== FUNCIÓN: IMÁGENES ADICIONALES ==========
                function initAdditionalImages() {
                    const dropZone = document.getElementById('drop-zone');
                    const input = document.getElementById('additional-images');
                    const previewGrid = document.getElementById('preview-grid');

                    if (!dropZone || !input || !previewGrid) return;

                    // Click para abrir selector
                    dropZone.addEventListener('click', () => input.click());

                    // Drag & Drop
                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        dropZone.addEventListener(eventName, e => {
                            e.preventDefault();
                            e.stopPropagation();
                        });
                    });

                    ['dragenter', 'dragover'].forEach(eventName => {
                        dropZone.addEventListener(eventName, () => {
                            dropZone.classList.add('border-blue-500', 'bg-blue-50');
                        });
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        dropZone.addEventListener(eventName, () => {
                            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
                        });
                    });

                    dropZone.addEventListener('drop', function(e) {
                        console.log('📂 Drop detectado');
                        handleFiles(Array.from(e.dataTransfer.files));
                    });

                    input.addEventListener('change', function() {
                        console.log('📎 Files seleccionados:', this.files.length);
                        handleFiles(Array.from(this.files));
                    });

                    function handleFiles(files) {
                        const imageFiles = files.filter(file => file.type.startsWith('image/'));

                        if (imageFiles.length === 0) {
                            alert('Solo se permiten archivos de imagen');
                            return;
                        }

                        // Agregar archivos únicos
                        imageFiles.forEach(file => {
                            const isDuplicate = selectedNewFiles.some(existing =>
                                existing.name === file.name &&
                                existing.size === file.size &&
                                existing.lastModified === file.lastModified
                            );

                            if (!isDuplicate) {
                                selectedNewFiles.push(file);
                            }
                        });

                        console.log('📊 Total archivos:', selectedNewFiles.length);
                        updateFileInput();
                        updatePreview();
                    }

                    function updateFileInput() {
                        const dt = new DataTransfer();
                        selectedNewFiles.forEach(file => dt.items.add(file));
                        input.files = dt.files;
                    }

                    function updatePreview() {
                        previewGrid.innerHTML = '';

                        selectedNewFiles.forEach((file, index) => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const container = document.createElement('div');
                                container.className = 'relative group';
                                container.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-32 object-cover rounded">
                                <button type="button" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity" onclick="removeNewImage(${index})">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            `;
                                previewGrid.appendChild(container);
                            };
                            reader.readAsDataURL(file);
                        });
                    }

                    // Función global para eliminar
                    window.removeNewImage = function(index) {
                        selectedNewFiles.splice(index, 1);
                        updateFileInput();
                        updatePreview();
                    };
                }

                // ========== FUNCIÓN: MAPA (CORREGIDA PARA CREATE - SIN REDECLARACIÓN) ==========
                function initMap() {
                    if (typeof L === 'undefined') {
                        console.log('❌ Leaflet no disponible');
                        return;
                    }

                    const mapContainer = document.getElementById('map');
                    if (!mapContainer || mapContainer._leaflet_id) {
                        console.log('⚠️ Mapa ya inicializado o contenedor no encontrado');
                        return;
                    }

                    const defaultLat = -16.524678;
                    const defaultLng = -68.108196;

                    // DECLARAR UNA SOLA VEZ LOS INPUTS
                    const latInput = document.getElementById('latitude');
                    const lngInput = document.getElementById('longitude');

                    mapInstance = L.map('map').setView([defaultLat, defaultLng], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(mapInstance);

                    let marker = L.marker([defaultLat, defaultLng], {
                        draggable: true
                    }).addTo(mapInstance);

                    // ========== EVENTO CLICK EN MAPA (CORREGIDO) ==========
                    mapInstance.on('click', function(e) {
                        console.log('🗺️ Click en mapa detectado:', e.latlng);

                        // Mover el marcador a la nueva posición
                        marker.setLatLng(e.latlng);

                        // Actualizar los campos de input (USAR VARIABLES YA DECLARADAS)
                        if (latInput && lngInput) {
                            latInput.value = e.latlng.lat.toFixed(6);
                            lngInput.value = e.latlng.lng.toFixed(6);
                            console.log('✅ Coordenadas actualizadas:', e.latlng.lat.toFixed(6), e.latlng.lng.toFixed(6));
                        } else {
                            console.log('❌ Campos de latitud/longitud no encontrados');
                        }
                    });

                    // ========== EVENTO DRAG DEL MARCADOR (CORREGIDO) ==========
                    marker.on('dragend', function(e) {
                        const position = marker.getLatLng();
                        console.log('🔄 Marcador arrastrado a:', position);

                        // Usar las variables ya declaradas
                        if (latInput && lngInput) {
                            latInput.value = position.lat.toFixed(6);
                            lngInput.value = position.lng.toFixed(6);
                            console.log('✅ Coordenadas actualizadas por drag:', position.lat.toFixed(6), position.lng.toFixed(6));
                        }
                    });

                    // ========== GEOCODIFICACIÓN ==========
                    if (typeof L.Control.Geocoder !== 'undefined') {
                        const geocoder = L.Control.Geocoder.nominatim();

                        document.getElementById('address2')?.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                const query = this.value;

                                geocoder.geocode(query, function(results) {
                                    if (results && results.length > 0) {
                                        const result = results[0];
                                        const latlng = result.center;

                                        console.log('🔍 Dirección encontrada:', latlng);

                                        mapInstance.setView(latlng, 16);
                                        marker.setLatLng(latlng);

                                        // Actualizar campos (usar variables ya declaradas)
                                        if (latInput && lngInput) {
                                            latInput.value = latlng.lat.toFixed(6);
                                            lngInput.value = latlng.lng.toFixed(6);
                                        }
                                    }
                                });
                            }
                        });
                    }

                    // ========== EVENTO CAMBIO EN INPUTS DE COORDENADAS ==========
                    if (latInput && lngInput) {
                        function updateMapFromInputs() {
                            const lat = parseFloat(latInput.value);
                            const lng = parseFloat(lngInput.value);

                            if (!isNaN(lat) && !isNaN(lng)) {
                                console.log('📍 Actualizando mapa desde inputs:', lat, lng);
                                const newLatLng = L.latLng(lat, lng);
                                marker.setLatLng(newLatLng);
                                mapInstance.setView(newLatLng, mapInstance.getZoom());
                            }
                        }

                        latInput.addEventListener('change', updateMapFromInputs);
                        lngInput.addEventListener('change', updateMapFromInputs);
                        latInput.addEventListener('blur', updateMapFromInputs);
                        lngInput.addEventListener('blur', updateMapFromInputs);

                        // Establecer coordenadas por defecto en los inputs
                        latInput.value = defaultLat.toFixed(6);
                        lngInput.value = defaultLng.toFixed(6);
                    }

                    console.log('✅ Mapa inicializado con eventos de click y coordenadas por defecto');
                }

                // ========== FUNCIÓN: SERVICIOS ==========
                function initServices() {
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.add-service')) {
                            e.preventDefault();
                            const container = document.getElementById('services-container');
                            const serviceRows = container.querySelectorAll('.service-row');
                            const newRow = serviceRows[0].cloneNode(true);

                            newRow.querySelectorAll('input, select').forEach(input => {
                                input.value = '';
                            });

                            const addButton = newRow.querySelector('.add-service');
                            if (addButton) {
                                addButton.className = 'p-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-service';
                                addButton.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`;
                            }

                            container.appendChild(newRow);
                        }

                        if (e.target.closest('.remove-service')) {
                            e.preventDefault();
                            e.target.closest('.service-row').remove();
                        }
                    });
                }

                // ========== FUNCIÓN: BARRIOS ==========
                window.loadNeighborhoods = function(cityId) {
                    const neighborhoodSelect = document.getElementById('neighborhood_id');
                    neighborhoodSelect.innerHTML = '<option value="">Cargando barrios...</option>';

                    if (!cityId) {
                        neighborhoodSelect.innerHTML = '<option value="">Primero seleccione una ciudad</option>';
                        return;
                    }

                    fetch(`/api/neighborhoods/by-city/${cityId}`)
                        .then(response => response.json())
                        .then(data => {
                            neighborhoodSelect.innerHTML = '<option value="">Seleccione un barrio</option>';
                            data.forEach(neighborhood => {
                                const option = document.createElement('option');
                                option.value = neighborhood.id;
                                option.textContent = neighborhood.name;
                                neighborhoodSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error cargando barrios:', error);
                            neighborhoodSelect.innerHTML = '<option value="">Error cargando barrios</option>';
                        });
                };

                // ========== FUNCIÓN: CAMPOS DE PROYECTO ==========
                window.toggleProjectFields = function(value) {
                    const projectFields = document.getElementById('project-fields');
                    const unitsField = document.getElementById('units');

                    if (value === '1') {
                        if (projectFields) projectFields.style.display = '';
                        if (unitsField) unitsField.disabled = false;
                    } else {
                        if (projectFields) projectFields.style.display = 'none';
                        if (unitsField) unitsField.disabled = true;
                    }
                };

                // ========== INICIALIZAR TODO ==========
                initThumbnail();
                initAdditionalImages();
                initMap();
                initServices();

                // Inicializar campos de proyecto
                const isProjectSelect = document.getElementById('is_project');
                if (isProjectSelect) {
                    toggleProjectFields(isProjectSelect.value);
                }

                console.log('✅ PropertyCreate v2.0 completamente inicializado');
            });
        }
    </script>
</x-app-layout>
