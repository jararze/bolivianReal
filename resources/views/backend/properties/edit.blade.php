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
    <!-- Leaflet scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endpush

@push('head')
    <meta name="current-neighborhood" content="{{ $property->neighborhood_id ?? '' }}">
@endpush

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">{{ __('Propiedades') }}</h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.properties.index') }}">
                {{ __('Propiedades') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Editar Propiedad: {{ $property->name }}</span>
        </div>
    </x-slot>

    @push('head')
        <meta name="current-neighborhood" content="{{ $property->neighborhood_id }}">
    @endpush

    <div class="container-fixed">
        <form action="{{ route('backend.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="reorder_images" value="1">

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
                                    <x-text-input id="name" name="name" type="text" :value="old('name', $property->name)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('name')"/>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="address" :value="__('Direccion')" class="text-gray-700"/>
                                <div class="col-span-3">
                                    <x-text-input id="address" name="address" type="text" :value="old('address', $property->address)" class="w-full" placeholder="Ingresa la dirección y presiona Enter para buscar"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('address')"/>
                                </div>
                            </div>

                            <!-- Zona, Superficie terreno, Superficie Construido -->
                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="neighborhood_id" :value="__('Zona')" class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="neighborhood_id"
                                        name="neighborhood_id"
                                        data-selected="{{ old('neighborhood_id', $property->neighborhood_id) }}"
                                        :options="['' => 'Primero seleccione una ciudad']"
                                        :selected="old('neighborhood_id', $property->neighborhood_id)"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('neighborhood_id')"/>
                                </div>
                                <div>
                                    <x-input-label for="size" :value="__('Superficie terreno (MT2)')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="size" name="size" type="number" :value="old('size', $property->size)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('size')"/>
                                </div>
                                <div>
                                    <x-input-label for="size_max" :value="__('Superficie Construido (MT2)')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="size_max" name="size_max" type="number" :value="old('size_max', $property->size_max)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('size_max')"/>
                                </div>
                            </div>

                            <!-- Ciudad y País -->
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="city" :value="__('Ciudad')" class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="city"
                                        name="city"
{{--                                        onchange="loadNeighborhoods(this.value)" --}}
                                        :options="['' => 'Seleccione una ciudad'] + $cities->pluck('name', 'id')->toArray()"
                                        :selected="old('city', $property->city)" />
                                    <x-input-error class="mt-1" :messages="$errors->get('city')"/>
                                </div>
                                <div>
                                    <x-input-label for="country" :value="__('Pais')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="country" name="country" type="text" :value="old('country', $property->country)" class="w-full"/>
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
                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="propertytype_id" :value="__('¿Tipo Propiedad?')" class="mb-2 text-gray-700"/>
                                    <x-select-input class="w-full" id="propertytype_id" name="propertytype_id" :options="['' => 'Seleccione un tipo de propiedad'] + $propertyTypes->pluck('type_name', 'id')->toArray()" :selected="old('propertytype_id', $property->propertytype_id)"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('propertytype_id')"/>
                                </div>
                                <div>
                                    <x-input-label for="service_type_id" :value="__('¿Propiedad para?')" class="mb-2 text-gray-700"/>
                                    <x-select-input class="w-full" id="service_type_id" name="service_type_id" :options="['' => 'Seleccione un servicio'] + $serviceTypes->pluck('name', 'id')->toArray()" :selected="old('service_type_id', $property->service_type_id)"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('service_type_id')"/>
                                </div>
                                <div>
                                    <x-input-label for="currency" :value="__('Moneda')" class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="currency"
                                        name="currency"
                                        :options="['Bs' => 'Bolivianos', '$us' => 'Dolares']"
                                        :selected="old('currency', $property->currency)" />
                                    <x-input-error class="mt-1" :messages="$errors->get('currency')"/>
                                </div>
{{--                                <div>--}}
{{--                                    <x-input-label for="chosen_currency" :value="__('¿Precio a mostrar?')" class="mb-2 text-gray-700"/>--}}
{{--                                    <x-select-input class="w-full" id="chosen_currency" name="chosen_currency" :options="['1' => 'Bolivianos', '0' => 'Dolares']" :selected="old('chosen_currency', $property->chosen_currency)"/>--}}
{{--                                    <x-input-error class="mt-1" :messages="$errors->get('chosen_currency')"/>--}}
{{--                                </div>--}}
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="lowest_price" :value="__('Precio minimo')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="lowest_price" name="lowest_price" type="number" :value="old('lowest_price', $property->lowest_price)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('lowest_price')"/>
                                </div>
                                <div>
                                    <x-input-label for="max_price" :value="__('Precio maximo')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="max_price" name="max_price" type="number" :value="old('max_price', $property->max_price)" class="w-full"/>
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
                                    <x-input-label for="bedrooms" :value="__('Numero habitaciones/ambientes')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="bedrooms" name="bedrooms" type="number" :value="old('bedrooms', $property->bedrooms)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('bedrooms')"/>
                                </div>
                                <div>
                                    <x-input-label for="bathrooms" :value="__('Numero de banos')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="bathrooms" name="bathrooms" type="number" :value="old('bathrooms', $property->bathrooms)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('bathrooms')"/>
                                </div>
                                <div>
                                    <x-input-label for="garage" :value="__('Espacios en el garaje')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="garage" name="garage" type="number" :value="old('garage', $property->garage)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('garage')"/>
                                </div>
                                <div>
                                    <x-input-label for="garage_size" :value="__('Baulera/s')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="garage_size" name="garage_size" type="number" :value="old('garage_size', $property->garage_size)" class="w-full"/>
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
                                        <x-text-input id="short_description" name="short_description" type="text" :value="old('short_description', $property->short_description)" required autocomplete="short_description" class="w-full"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('short_description')"/>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-7">
                                    <x-input-label for="long_description" :value="__('Descripcion larga')" class="form-label max-w-56"/>
                                    <div class="flex flex-col tems-start grow gap-3 w-full">
                                        <textarea id="long_description" name="long_description" placeholder="Descripción larga" rows="10" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('long_description', $property->long_description) }}</textarea>
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
                                                @if($property->thumbnail)
                                                    <img id="thumbnail-preview" src="{{ asset('storage/' . $property->thumbnail) }}" alt="Imagen principal" class="max-h-full max-w-full object-cover">
                                                    <div id="thumbnail-placeholder" class="text-center hidden">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                        </svg>
                                                        <p class="mt-1 text-sm text-gray-500">Click para subir<br>(PNG, JPG)</p>
                                                    </div>
                                                @else
                                                    <img id="thumbnail-preview" src="" alt="" class="max-h-full max-w-full hidden object-cover">
                                                    <div id="thumbnail-placeholder" class="text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                        </svg>
                                                        <p class="mt-1 text-sm text-gray-500">Click para subir<br>(PNG, JPG)</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" id="remove-thumbnail" class="absolute top-2 right-2 {{ $property->thumbnail ? '' : 'hidden' }} bg-white rounded-full p-1 shadow-sm hover:bg-gray-100">
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
                                    <label class="text-gray-700 text-sm font-medium mb-2">Agregar Más Imágenes</label>
                                    <div class="mt-2">
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg h-[300px] relative cursor-pointer transition-colors hover:border-blue-400" id="drop-zone">
                                            <input type="file" id="additional-images" name="images[]" multiple accept="image/*" class="hidden"/>
                                            <div id="drop-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mt-1 text-sm text-gray-500">Arrastra más imágenes aquí<br>o click para seleccionar</p>
                                                <p class="mt-2 text-xs text-blue-600 font-medium">Después podrás reordenarlas arrastrándolas ⇅</p>
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

                            <!-- Grid de imágenes existentes CON DRAG & DROP -->
                            @if($property->images_ordered->count() > 0)
                                <div class="mt-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-gray-700 text-sm font-medium">Imágenes Actuales</h4>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span>{{ $property->images_ordered->count() }} imágenes</span>
                                            <div class="flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                                </svg>
                                                <span>Arrastra para reordenar</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4" id="existing-images-sortable">
                                        @foreach($property->images_ordered as $image)
                                            <div class="relative group image-container sortable-item" data-image-id="{{ $image->id }}" data-image-name="{{ $image->name }}">
                                                <!-- Badge de orden extraído del nombre -->
                                                @php
                                                    $orderNumber = 999;
                                                    $filename = basename($image->name);
                                                    if (preg_match('/^(\d{2})_/', $filename, $matches)) {
                                                        $orderNumber = (int) $matches[1];
                                                    }
                                                @endphp

                                                <div class="relative bg-white rounded-lg shadow-md overflow-hidden border-2 border-transparent hover:border-blue-300">
                                                    <img src="{{ asset('storage/' . $image->name) }}" alt="Imagen de propiedad" class="w-full h-32 object-cover">

                                                    <!-- Badge de orden -->
                                                    <div class="absolute top-2 left-2 order-badge bg-gradient-to-r from-blue-500 to-blue-700 text-white text-xs font-bold px-2 py-1 rounded-full border-2 border-white shadow-md">
                                                        #{{ $orderNumber < 999 ? $orderNumber : $loop->iteration }}
                                                    </div>

                                                    <!-- Botón eliminar -->
                                                    <button type="button" class="delete-existing-image absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600" data-image-id="{{ $image->id }}" title="Eliminar imagen">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>

                                                    <!-- Indicador de drag -->
                                                    <div class="absolute bottom-1 right-1 text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity bg-black bg-opacity-50 rounded px-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="delete_images[{{ $image->id }}]" value="0" class="delete-image-input">
                                                <!-- Input hidden para el nuevo orden -->
                                                <input type="hidden" name="image_orders[{{ $image->id }}]" value="{{ $orderNumber < 999 ? $orderNumber : $loop->iteration }}" class="image-order-input">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Grid de vista previa de nuevas imágenes CON DRAG & DROP -->
                            <div class="mt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-gray-700 text-sm font-medium">Vista previa de nuevas imágenes</h4>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span id="new-image-count-display">0 imágenes</span>
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                            </svg>
                                            <span>Arrastra para reordenar</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Grid sorteable para nuevas imágenes -->
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 min-h-[120px]" id="sortable-preview-grid">
                                    <!-- Las nuevas imágenes aparecerán aquí -->
                                </div>

                                <!-- Mensaje cuando no hay imágenes nuevas -->
                                <div id="no-new-images-message" class="text-center py-8 text-gray-400">
                                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 011 1H5a2 2 0 01-2-2V6a2 2 0 012-2h6M14 6l4-4m0 0l4 4m-4-4v8"/>
                                    </svg>
                                    <p class="mt-2 text-sm">No hay nuevas imágenes seleccionadas</p>
                                    <p class="text-xs">Las nuevas imágenes aparecerán aquí para que puedas reordenarlas</p>
                                </div>
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
                                    <x-text-input id="address2" name="address2" type="text" :value="old('address2', $property->address)" class="w-full" placeholder="Ingresa la dirección y presiona Enter para buscar"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('address2')"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="latitude" :value="__('Latitud')" class="form-label max-w-56"/>
                                        <div class="flex flex-col items-start grow gap-3 w-full">
                                            <x-text-input id="latitude" name="latitude" type="text" :value="old('latitude', $property->latitude)" class="w-full" placeholder="-17.123456"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('latitude')"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="longitude" :value="__('Longitud')" class="form-label max-w-56"/>
                                        <div class="flex flex-col items-start grow gap-3 w-full">
                                            <x-text-input id="longitude" name="longitude" type="text" :value="old('longitude', $property->longitude)" class="w-full" placeholder="-66.123456"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('longitude')"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                <x-select-input class="w-full" name="features[]" :options="['' => 'Seleccione un servicio'] + $features->pluck('name', 'id')->toArray()" :selected="old('features.'.$index, $facility->pivot->facility_id)"/>
                                            </div>
                                            <div class="col-span-4">
                                                <x-text-input name="place_names[]" type="text" :value="old('place_names.'.$index, $facility->pivot->name)" class="w-full" placeholder="Nombre del servicio"/>
                                            </div>
                                            <div class="col-span-3">
                                                <x-text-input name="distances[]" type="text" :value="old('distances.'.$index, $facility->pivot->distance)" class="w-full" placeholder="Distancia (Cuadras)"/>
                                            </div>
                                            <div class="col-span-1 flex justify-end">
                                                @if($index === 0)
                                                    <button type="button" class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600 add-service">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                @else
                                                    <button type="button" class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-service">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="service-row grid grid-cols-12 gap-4 items-start">
                                        <div class="col-span-4">
                                            <x-select-input class="w-full" name="features[]" :options="['' => 'Seleccione un servicio'] + $features->pluck('name', 'id')->toArray()" :selected="old('features.0')"/>
                                        </div>
                                        <div class="col-span-4">
                                            <x-text-input name="place_names[]" type="text" :value="old('place_names.0')" class="w-full" placeholder="Nombre del servicio"/>
                                        </div>
                                        <div class="col-span-3">
                                            <x-text-input name="distances[]" type="text" :value="old('distances.0')" class="w-full" placeholder="Distancia (Cuadras)"/>
                                        </div>
                                        <div class="col-span-1 flex justify-end">
                                            <button type="button" class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600 add-service">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
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
                                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" {{ (is_array(old('amenities', $property->amenities->pluck('id')->toArray())) && in_array($amenity->id, old('amenities', $property->amenities->pluck('id')->toArray()))) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
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
                                        <x-text-input id="video" name="video" type="url" :value="old('video', $property->video)" placeholder="https://youtube.com/..." class="w-full"/>
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
                                            <input type="checkbox" name="featured" value="1" {{ old('featured', $property->featured) ? 'checked' : '' }}>
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
                                            <input type="checkbox" name="hot" value="1" {{ old('hot', $property->hot) ? 'checked' : '' }}>
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
                                            <x-select-input class="w-full" id="agent_id" name="agent_id" :options="['' => 'Seleccione un Agente'] + $agents->pluck('name', 'id')->toArray()" :selected="old('agent_id', $property->agent_id)"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('agent_id')"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="w-full">
                                    <div class="flex items-baseline gap-2.5">
                                        <x-input-label for="status" :value="__('Estado')" class="form-label w-24 shrink-0"/>
                                        <div class="grow">
                                            <x-select-input class="w-full" id="status" name="status" :options="['1' => 'Activo', '0' => 'Inactivo']" :selected="old('status', $property->status)"/>
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
                                        <x-select-input onchange="toggleProjectFields(this.value)" class="w-full" id="is_project" name="is_project" :options="['1' => 'Si', '0' => 'No']" :selected="old('is_project', $property->is_project)"/>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos de proyecto -->
                            <div id="project-fields" class="space-y-5" style="{{ $property->is_project ? '' : 'display: none;' }}">
                                <!-- Unidades -->
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="units" :value="__('Unidades')" class="form-label max-w-56"/>
                                        <div class="flex flex-col items-start grow gap-3 w-full">
                                            <x-text-input id="units" name="units" type="number" :value="old('units', $property->units)" class="w-full" {{ $property->is_project ? '' : 'disabled' }}/>
                                            <x-input-error class="mt-2" :messages="$errors->get('units')"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Proyecto asociado -->
                                <div class="w-full">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <x-input-label for="project_id" :value="__('Proyecto asociado')" class="form-label max-w-56"/>
                                        <div class="grow">
                                            <x-select-input class="w-full" id="project_id" name="project_id" :options="['' => 'Seleccione un proyecto'] + $projects->pluck('name', 'id')->toArray()" :selected="old('project_id', $property->project_id)"/>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <!-- SCRIPT ÚNICO Y LIMPIO CON COMPRESIÓN -->
    <script>
        // Evitar múltiples inicializaciones
        if (!window.editPropertyInitialized) {
            window.editPropertyInitialized = true;

            document.addEventListener('DOMContentLoaded', function() {
                console.log('🚀 Iniciando PropertyEdit v3.0 con Compresión');

                // ========== VARIABLES GLOBALES ==========
                let selectedNewFiles = [];
                let mapInstance = null;

                // ========== FUNCIONES DE COMPRESIÓN ==========
                function compressImage(file, maxSizeMB = 2, quality = 0.8) {
                    return new Promise((resolve) => {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        const img = new Image();

                        img.onload = function() {
                            // Calcular nuevas dimensiones manteniendo aspect ratio
                            let { width, height } = calculateDimensions(img.width, img.height, 1920, 1080);

                            canvas.width = width;
                            canvas.height = height;

                            // Dibujar imagen redimensionada
                            ctx.drawImage(img, 0, 0, width, height);

                            // Convertir a blob con compresión
                            canvas.toBlob((blob) => {
                                console.log(`📷 Imagen comprimida: ${(file.size / 1024 / 1024).toFixed(2)}MB → ${(blob.size / 1024 / 1024).toFixed(2)}MB`);

                                // Si aún es mayor a maxSizeMB, reducir más la calidad
                                if (blob.size > maxSizeMB * 1024 * 1024 && quality > 0.3) {
                                    const newFile = new File([blob], file.name, { type: file.type });
                                    compressImage(newFile, maxSizeMB, quality - 0.1).then(resolve);
                                } else {
                                    // Crear archivo con el nombre original
                                    const compressedFile = new File([blob], file.name, {
                                        type: file.type,
                                        lastModified: Date.now()
                                    });
                                    resolve(compressedFile);
                                }
                            }, file.type, quality);
                        };

                        img.src = URL.createObjectURL(file);
                    });
                }

                function calculateDimensions(width, height, maxWidth = 1920, maxHeight = 1080) {
                    if (width <= maxWidth && height <= maxHeight) {
                        return { width, height };
                    }

                    const ratio = Math.min(maxWidth / width, maxHeight / height);
                    return {
                        width: Math.round(width * ratio),
                        height: Math.round(height * ratio)
                    };
                }

                async function processFiles(files) {
                    const processedFiles = [];
                    const MAX_SIZE_MB = 2;

                    for (const file of files) {
                        if (!file.type.startsWith('image/')) {
                            alert(`${file.name} no es una imagen válida`);
                            continue;
                        }

                        // Mostrar indicador de procesamiento
                        showProcessingIndicator(file.name);

                        try {
                            if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                                console.log(`🔄 Comprimiendo ${file.name}...`);
                                const compressedFile = await compressImage(file, MAX_SIZE_MB);
                                processedFiles.push(compressedFile);
                                showCompressionResult(file, compressedFile);
                            } else {
                                console.log(`✅ ${file.name} ya está dentro del límite`);
                                processedFiles.push(file);
                            }
                        } catch (error) {
                            console.error(`❌ Error procesando ${file.name}:`, error);
                            alert(`Error procesando ${file.name}`);
                        } finally {
                            hideProcessingIndicator();
                        }
                    }

                    return processedFiles;
                }

                function showProcessingIndicator(fileName) {
                    let indicator = document.getElementById('processing-indicator');
                    if (!indicator) {
                        indicator = document.createElement('div');
                        indicator.id = 'processing-indicator';
                        indicator.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                        document.body.appendChild(indicator);
                    }
                    indicator.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        <span>Comprimiendo ${fileName}...</span>
                    </div>
                `;
                    indicator.style.display = 'block';
                }

                function hideProcessingIndicator() {
                    const indicator = document.getElementById('processing-indicator');
                    if (indicator) {
                        indicator.style.display = 'none';
                    }
                }

                function showCompressionResult(originalFile, compressedFile) {
                    const originalSize = (originalFile.size / 1024 / 1024).toFixed(2);
                    const compressedSize = (compressedFile.size / 1024 / 1024).toFixed(2);
                    const savings = ((1 - compressedFile.size / originalFile.size) * 100).toFixed(1);

                    // Mostrar notificación temporal
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    notification.innerHTML = `
                    📷 ${originalFile.name}<br>
                    ${originalSize}MB → ${compressedSize}MB (-${savings}%)
                `;
                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }

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

                // ========== FUNCIÓN: THUMBNAIL CON COMPRESIÓN ==========
                function initThumbnailWithCompression() {
                    const input = document.getElementById('thumbnail');
                    const preview = document.getElementById('thumbnail-preview');
                    const placeholder = document.getElementById('thumbnail-placeholder');
                    const removeBtn = document.getElementById('remove-thumbnail');
                    const previewArea = document.getElementById('thumbnail-preview-area');

                    if (!input || !previewArea) return;

                    previewArea.addEventListener('click', () => input.click());

                    input.addEventListener('change', async function(e) {
                        if (e.target.files[0]) {
                            const file = e.target.files[0];

                            // Procesar archivo (comprimir si es necesario)
                            const processedFiles = await processFiles([file]);

                            if (processedFiles.length > 0) {
                                const processedFile = processedFiles[0];

                                // Actualizar el input con el archivo procesado
                                const dt = new DataTransfer();
                                dt.items.add(processedFile);
                                input.files = dt.files;

                                // Mostrar preview
                                preview.src = URL.createObjectURL(processedFile);
                                preview.classList.remove('hidden');
                                if (placeholder) placeholder.classList.add('hidden');
                                if (removeBtn) removeBtn.classList.remove('hidden');
                            }
                        }
                    });

                    removeBtn?.addEventListener('click', function(e) {
                        e.stopPropagation();
                        input.value = '';
                        preview.src = '';
                        preview.classList.add('hidden');
                        if (placeholder) placeholder.classList.remove('hidden');
                        this.classList.add('hidden');

                        let hiddenInput = document.querySelector('input[name="remove_thumbnail"]');
                        if (!hiddenInput) {
                            hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'remove_thumbnail';
                            document.querySelector('form').appendChild(hiddenInput);
                        }
                        hiddenInput.value = '1';
                    });
                }

                // ========== FUNCIÓN: IMÁGENES ADICIONALES CON COMPRESIÓN ==========
                function initAdditionalImagesWithDragDropEdit() {
                    const dropZone = document.getElementById('drop-zone');
                    const input = document.getElementById('additional-images');
                    const previewGrid = document.getElementById('sortable-preview-grid');
                    const noNewImagesMessage = document.getElementById('no-new-images-message');
                    const newImageCountDisplay = document.getElementById('new-image-count-display');
                    const existingImagesGrid = document.getElementById('existing-images-sortable');

                    if (!dropZone || !input || !previewGrid) return;

                    // Array para almacenar archivos nuevos con su orden
                    let orderedNewFiles = [];

                    // Sortables para ambos grids
                    let existingSortable = null;
                    let newSortable = null;

                    // CSS para las animaciones de drag
                    const style = document.createElement('style');
                    style.textContent = `
        .sortable-ghost {
            opacity: 0.4;
            transform: scale(0.95);
        }
        .sortable-chosen {
            transform: scale(1.05);
        }
        .sortable-drag {
            transform: rotate(5deg);
        }
        .sortable-item {
            transition: all 0.2s ease;
            cursor: grab;
        }
        .sortable-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .order-badge {
            background: linear-gradient(45deg, #3b82f6, #1d4ed8);
            color: white;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
    `;
                    document.head.appendChild(style);

                    // Inicializar sortable para imágenes existentes
                    function initExistingSortable() {
                        if (existingSortable) {
                            existingSortable.destroy();
                        }

                        if (existingImagesGrid) {
                            existingSortable = new Sortable(existingImagesGrid, {
                                animation: 150,
                                ghostClass: 'sortable-ghost',
                                chosenClass: 'sortable-chosen',
                                dragClass: 'sortable-drag',
                                onEnd: function(evt) {
                                    // Actualizar el orden de las imágenes existentes
                                    updateExistingImagesOrder();
                                    console.log('📋 Orden de imágenes existentes actualizado');
                                }
                            });
                        }
                    }

                    // Inicializar sortable para nuevas imágenes
                    function initNewImagesSortable() {
                        if (newSortable) {
                            newSortable.destroy();
                        }

                        newSortable = new Sortable(previewGrid, {
                            animation: 150,
                            ghostClass: 'sortable-ghost',
                            chosenClass: 'sortable-chosen',
                            dragClass: 'sortable-drag',
                            onEnd: function(evt) {
                                // Reordenar el array de archivos nuevos según el nuevo orden
                                const newOrderedFiles = [];
                                const items = previewGrid.querySelectorAll('[data-file-index]');

                                items.forEach(item => {
                                    const fileIndex = parseInt(item.getAttribute('data-file-index'));
                                    newOrderedFiles.push(orderedNewFiles[fileIndex]);
                                });

                                orderedNewFiles = newOrderedFiles;
                                updateNewFileInput();
                                updateNewPreviewNumbers();

                                console.log('📋 Orden de nuevas imágenes actualizado:', orderedNewFiles.map((f, i) => `${i+1}. ${f.name}`));
                            }
                        });
                    }

                    // Actualizar orden de imágenes existentes
                    function updateExistingImagesOrder() {
                        const items = existingImagesGrid.querySelectorAll('.sortable-item');
                        items.forEach((item, index) => {
                            const badge = item.querySelector('.order-badge');
                            const orderInput = item.querySelector('.image-order-input');
                            const newOrder = index + 1;

                            if (badge) {
                                badge.textContent = `#${newOrder}`;
                            }
                            if (orderInput) {
                                orderInput.value = newOrder;
                            }
                        });
                    }

                    // Event listeners para drop zone (nuevas imágenes)
                    dropZone.addEventListener('click', () => input.click());

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

                    dropZone.addEventListener('drop', async function(e) {
                        console.log('📂 Drop detectado en edit');
                        await handleNewFiles(Array.from(e.dataTransfer.files));
                    });

                    input.addEventListener('change', async function() {
                        console.log('📎 Files seleccionados en edit:', this.files.length);
                        await handleNewFiles(Array.from(this.files));
                    });

                    // Manejar nuevos archivos
                    async function handleNewFiles(files) {
                        // Obtener el número actual de imágenes existentes para calcular el orden inicial
                        const existingCount = existingImagesGrid ? existingImagesGrid.querySelectorAll('.sortable-item').length : 0;

                        // Procesar archivos (usar función de compresión existente)
                        const processedFiles = await processFiles(files);

                        // Agregar archivos únicos al array ordenado
                        processedFiles.forEach(file => {
                            const isDuplicate = orderedNewFiles.some(existing =>
                                existing.name === file.name && existing.size === file.size
                            );

                            if (!isDuplicate) {
                                orderedNewFiles.push(file);
                            }
                        });

                        console.log('📊 Total archivos nuevos ordenados:', orderedNewFiles.length);
                        updateNewFileInput();
                        updateNewPreview();
                        updateNewUI();
                    }

                    // Actualizar input de archivos nuevos con orden
                    function updateNewFileInput() {
                        const dt = new DataTransfer();
                        const existingCount = existingImagesGrid ? existingImagesGrid.querySelectorAll('.sortable-item').length : 0;

                        orderedNewFiles.forEach((file, index) => {
                            // Crear nuevo nombre con prefijo de orden basado en la posición total
                            const totalOrder = existingCount + index + 1;
                            const orderPrefix = String(totalOrder).padStart(2, '0') + '_';
                            const newName = orderPrefix + file.name;

                            // Crear nuevo archivo con el nombre ordenado
                            const renamedFile = new File([file], newName, {
                                type: file.type,
                                lastModified: file.lastModified
                            });

                            dt.items.add(renamedFile);
                        });

                        input.files = dt.files;
                        console.log('📁 Input de nuevas imágenes actualizado con orden');
                    }

                    // Actualizar preview de nuevas imágenes
                    function updateNewPreview() {
                        previewGrid.innerHTML = '';
                        const existingCount = existingImagesGrid ? existingImagesGrid.querySelectorAll('.sortable-item').length : 0;

                        orderedNewFiles.forEach((file, index) => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const container = document.createElement('div');
                                container.className = 'relative group sortable-item';
                                container.setAttribute('data-file-index', index);

                                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                                const orderNumber = existingCount + index + 1;

                                container.innerHTML = `
                    <div class="relative bg-white rounded-lg shadow-md overflow-hidden border-2 border-transparent hover:border-blue-300">
                        <img src="${e.target.result}" class="w-full h-32 object-cover">

                        <!-- Badge de orden -->
                        <div class="absolute top-2 left-2 order-badge text-xs font-bold px-2 py-1 rounded-full">
                            #${orderNumber}
                        </div>

                        <!-- Info de archivo -->
                        <div class="absolute bottom-1 left-1 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">
                            ${fileSize}MB
                        </div>

                        <!-- Botón eliminar -->
                        <button type="button" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600" onclick="removeNewOrderedImage(${index})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <!-- Indicador de drag -->
                        <div class="absolute bottom-1 right-1 text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </div>
                `;

                                previewGrid.appendChild(container);
                            };
                            reader.readAsDataURL(file);
                        });

                        // Reinicializar Sortable después de actualizar el DOM
                        setTimeout(() => {
                            initNewImagesSortable();
                        }, 100);
                    }

                    // Actualizar números de orden en preview de nuevas imágenes
                    function updateNewPreviewNumbers() {
                        const existingCount = existingImagesGrid ? existingImagesGrid.querySelectorAll('.sortable-item').length : 0;
                        const items = previewGrid.querySelectorAll('[data-file-index]');

                        items.forEach((item, index) => {
                            const badge = item.querySelector('.order-badge');
                            if (badge) {
                                badge.textContent = `#${existingCount + index + 1}`;
                            }
                            item.setAttribute('data-file-index', index);
                        });
                    }

                    // Actualizar UI de nuevas imágenes
                    function updateNewUI() {
                        const count = orderedNewFiles.length;
                        newImageCountDisplay.textContent = `${count} ${count === 1 ? 'imagen' : 'imágenes'}`;

                        if (count > 0) {
                            noNewImagesMessage.style.display = 'none';
                            previewGrid.style.display = 'grid';
                        } else {
                            noNewImagesMessage.style.display = 'block';
                            previewGrid.style.display = 'none';
                        }
                    }

                    // Función global para eliminar nueva imagen
                    window.removeNewOrderedImage = function(index) {
                        orderedNewFiles.splice(index, 1);
                        updateNewFileInput();
                        updateNewPreview();
                        updateNewUI();
                        console.log('🗑️ Nueva imagen eliminada, nuevo orden:', orderedNewFiles.map((f, i) => `${i+1}. ${f.name}`));
                    };

                    // Inicializar sortables
                    initExistingSortable();
                    initNewImagesSortable();

                    // Inicializar UI
                    updateNewUI();
                }

                function initExistingImagesEdit() {
                    document.querySelectorAll('.delete-existing-image').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.stopPropagation();
                            const container = this.closest('.image-container');
                            const hiddenInput = container.querySelector('.delete-image-input');

                            if (confirm('¿Eliminar esta imagen?')) {
                                hiddenInput.value = '1';
                                container.style.opacity = '0.5';

                                const overlay = document.createElement('div');
                                overlay.className = 'absolute inset-0 bg-red-500 bg-opacity-50 flex items-center justify-center text-white font-bold rounded';
                                overlay.textContent = 'ELIMINADA';
                                container.appendChild(overlay);

                                this.innerHTML = '↻';
                                this.className = 'absolute top-2 right-2 bg-green-500 text-white rounded-full p-1 opacity-100';
                                this.title = 'Restaurar';

                                this.onclick = function() {
                                    hiddenInput.value = '0';
                                    container.style.opacity = '1';
                                    overlay.remove();
                                    this.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
                                    this.className = 'delete-existing-image absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity';
                                    this.title = 'Eliminar imagen';
                                };
                            }
                        });
                    });
                }

                // ========== FUNCIÓN: IMÁGENES EXISTENTES ==========
                function initExistingImages() {
                    document.querySelectorAll('.delete-existing-image').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.stopPropagation();
                            const container = this.closest('.image-container');
                            const hiddenInput = container.querySelector('.delete-image-input');

                            if (confirm('¿Eliminar esta imagen?')) {
                                hiddenInput.value = '1';
                                container.style.opacity = '0.5';

                                const overlay = document.createElement('div');
                                overlay.className = 'absolute inset-0 bg-red-500 bg-opacity-50 flex items-center justify-center text-white font-bold rounded';
                                overlay.textContent = 'ELIMINADA';
                                container.appendChild(overlay);

                                this.innerHTML = '↻';
                                this.className = 'absolute top-2 right-2 bg-green-500 text-white rounded-full p-1 opacity-100';
                                this.title = 'Restaurar';

                                this.onclick = function() {
                                    hiddenInput.value = '0';
                                    container.style.opacity = '1';
                                    overlay.remove();
                                    this.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
                                    this.className = 'delete-existing-image absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity';
                                    this.title = 'Eliminar imagen';
                                };
                            }
                        });
                    });
                }

                // ========== FUNCIÓN: MAPA ==========
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

                    const initialLat = document.getElementById('map-initial-lat')?.value || -16.5;
                    const initialLng = document.getElementById('map-initial-lng')?.value || -68.15;

                    mapInstance = L.map('map').setView([initialLat, initialLng], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(mapInstance);

                    let marker = L.marker([initialLat, initialLng], {
                        draggable: true
                    }).addTo(mapInstance);

                    // ========== EVENTO CLICK EN MAPA ==========
                    mapInstance.on('click', function(e) {
                        console.log('🗺️ Click en mapa detectado:', e.latlng);

                        marker.setLatLng(e.latlng);

                        const latInput = document.getElementById('latitude');
                        const lngInput = document.getElementById('longitude');

                        if (latInput && lngInput) {
                            latInput.value = e.latlng.lat.toFixed(6);
                            lngInput.value = e.latlng.lng.toFixed(6);
                            console.log('✅ Coordenadas actualizadas:', e.latlng.lat.toFixed(6), e.latlng.lng.toFixed(6));
                        }
                    });

                    // ========== EVENTO DRAG DEL MARCADOR ==========
                    marker.on('dragend', function(e) {
                        const position = marker.getLatLng();
                        console.log('🔄 Marcador arrastrado a:', position);

                        const latInput = document.getElementById('latitude');
                        const lngInput = document.getElementById('longitude');

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

                                        const latInput = document.getElementById('latitude');
                                        const lngInput = document.getElementById('longitude');

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
                    const latInput = document.getElementById('latitude');
                    const lngInput = document.getElementById('longitude');

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
                    }

                    console.log('✅ Mapa inicializado con eventos de click');
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
                window.loadNeighborhoods = function(cityId, selectedNeighborhoodId = null) {
                    const neighborhoodSelect = document.getElementById('neighborhood_id');

                    if (!neighborhoodSelect) {
                        console.error('❌ Select de barrios no encontrado');
                        return;
                    }

                    console.log('🔄 Cargando barrios para ciudad:', cityId, 'Preseleccionar:', selectedNeighborhoodId);

                    neighborhoodSelect.innerHTML = '<option value="">Cargando barrios...</option>';

                    if (!cityId) {
                        neighborhoodSelect.innerHTML = '<option value="">Primero seleccione una ciudad</option>';
                        return;
                    }

                    fetch(`/api/neighborhoods/by-city/${cityId}`)
                        .then(response => response.json())
                        .then(data => {
                            neighborhoodSelect.innerHTML = '<option value="">Seleccione un barrio</option>';

                            let foundSelected = false;

                            data.forEach(neighborhood => {
                                const option = document.createElement('option');
                                option.value = neighborhood.id;
                                option.textContent = neighborhood.name;

                                // Comparar como strings para evitar problemas de tipos
                                if (selectedNeighborhoodId && neighborhood.id == selectedNeighborhoodId) {
                                    option.selected = true;
                                    foundSelected = true;
                                    console.log('✅ Barrio preseleccionado:', neighborhood.name, '(ID:', neighborhood.id, ')');
                                }

                                neighborhoodSelect.appendChild(option);
                            });

                            if (selectedNeighborhoodId && !foundSelected) {
                                console.log('⚠️ No se encontró el barrio con ID:', selectedNeighborhoodId);
                            }

                            console.log('✅ Barrios cargados para ciudad:', cityId, 'Total:', data.length);
                        })
                        .catch(error => {
                            console.error('❌ Error cargando barrios:', error);
                            neighborhoodSelect.innerHTML = '<option value="">Error cargando barrios</option>';
                        });
                };

                function initNeighborhoodsAutoloadEdit() {
                    const citySelect = document.getElementById('city');
                    const neighborhoodSelect = document.getElementById('neighborhood_id');

                    if (!citySelect || !neighborhoodSelect) {
                        console.log('⚠️ Selects de ciudad o barrio no encontrados');
                        return;
                    }

                    const selectedCityId = citySelect.value;

                    // MEJOR: Obtener el neighborhood_id desde múltiples fuentes
                    let selectedNeighborhoodId = null;

                    // 1. Desde data-selected (más confiable para edit)
                    const dataSelected = neighborhoodSelect.getAttribute('data-selected');
                    if (dataSelected && dataSelected !== '' && dataSelected !== 'null') {
                        selectedNeighborhoodId = dataSelected;
                        console.log('📍 Neighborhood desde data-selected:', selectedNeighborhoodId);
                    }

                    // 2. Desde meta tag (por si acaso)
                    const metaNeighborhood = document.querySelector('meta[name="current-neighborhood"]');
                    if (!selectedNeighborhoodId && metaNeighborhood) {
                        const metaValue = metaNeighborhood.getAttribute('content');
                        if (metaValue && metaValue !== '' && metaValue !== 'null') {
                            selectedNeighborhoodId = metaValue;
                            console.log('📍 Neighborhood desde meta tag:', selectedNeighborhoodId);
                        }
                    }

                    console.log('🏙️ EDIT - Inicialización:');
                    console.log('   - Ciudad ID:', selectedCityId);
                    console.log('   - Barrio ID:', selectedNeighborhoodId);

                    // Si hay ciudad seleccionada, cargar barrios con preselección
                    if (selectedCityId && selectedCityId !== '') {
                        console.log('🔄 Cargando barrios automáticamente...');
                        loadNeighborhoods(selectedCityId, selectedNeighborhoodId);
                    } else {
                        console.log('⚠️ No hay ciudad seleccionada, no se cargan barrios');
                    }
                }

                // ========== INICIALIZACIÓN AUTOMÁTICA DE BARRIOS ==========
                function initNeighborhoodsAutoload() {
                    const citySelect = document.getElementById('city');
                    const neighborhoodSelect = document.getElementById('neighborhood_id');

                    if (!citySelect || !neighborhoodSelect) {
                        console.log('⚠️ Selects de ciudad o barrio no encontrados');
                        return;
                    }

                    const selectedCityId = citySelect.value;
                    let selectedNeighborhoodId = null;

                    // 1. Desde data-selected (incluye old y valor actual)
                    const dataSelected = neighborhoodSelect.getAttribute('data-selected');
                    if (dataSelected && dataSelected !== '') {
                        selectedNeighborhoodId = dataSelected;
                    }

                    // 2. Desde option marcado como selected
                    if (!selectedNeighborhoodId) {
                        const selectedOption = neighborhoodSelect.querySelector('option[selected]');
                        if (selectedOption) {
                            selectedNeighborhoodId = selectedOption.value;
                        }
                    }

                    // 3. Desde el valor actual del select
                    if (!selectedNeighborhoodId && neighborhoodSelect.value) {
                        selectedNeighborhoodId = neighborhoodSelect.value;
                    }

                    console.log('🏙️ EDIT - Ciudad inicial:', selectedCityId, 'Barrio inicial:', selectedNeighborhoodId);

                    // Si hay ciudad seleccionada, cargar barrios
                    if (selectedCityId) {
                        loadNeighborhoods(selectedCityId, selectedNeighborhoodId);
                    }
                }

                function initCityChangeHandlerEdit() {
                    const citySelect = document.getElementById('city');

                    if (citySelect) {
                        // REMOVER cualquier event listener anterior
                        citySelect.removeAttribute('onchange');

                        citySelect.addEventListener('change', function() {
                            const selectedCityId = this.value;
                            console.log('🏙️ Ciudad cambiada manualmente a:', selectedCityId);

                            if (selectedCityId && selectedCityId !== '') {
                                // Al cambiar ciudad manualmente, NO preseleccionar ningún barrio
                                loadNeighborhoods(selectedCityId, null);
                            } else {
                                // Si no hay ciudad, limpiar barrios
                                const neighborhoodSelect = document.getElementById('neighborhood_id');
                                if (neighborhoodSelect) {
                                    neighborhoodSelect.innerHTML = '<option value="">Primero seleccione una ciudad</option>';
                                }
                            }
                        });
                    }
                }

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
                initThumbnailWithCompression();
                initAdditionalImagesWithDragDropEdit();
                initExistingImagesEdit();
                initMap();
                initServices();
                initNeighborhoodsAutoloadEdit();
                initCityChangeHandlerEdit();

                // Inicializar campos de proyecto
                const isProjectSelect = document.getElementById('is_project');
                if (isProjectSelect) {
                    toggleProjectFields(isProjectSelect.value);
                }

                console.log('✅ PropertyEdit v3.0 con Compresión completamente inicializado');


            });
        }

        function debugNeighborhoodInfo() {
            const citySelect = document.getElementById('city');
            const neighborhoodSelect = document.getElementById('neighborhood_id');
            const metaTag = document.querySelector('meta[name="current-neighborhood"]');

            console.log('🐛 DEBUG NEIGHBORHOOD INFO:');
            console.log('   - Ciudad value:', citySelect?.value);
            console.log('   - Barrio data-selected:', neighborhoodSelect?.getAttribute('data-selected'));
            console.log('   - Barrio current value:', neighborhoodSelect?.value);
            console.log('   - Meta content:', metaTag?.getAttribute('content'));
            console.log('   - Barrio options count:', neighborhoodSelect?.options?.length);
        }

        // Llamar debug al inicio (temporal)
        setTimeout(() => {
            debugNeighborhoodInfo();
        }, 1000);
    </script>
</x-app-layout>
