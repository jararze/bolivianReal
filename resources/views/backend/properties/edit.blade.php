@push('styles')
    <link href="{{ asset('assets/css/createpropertie.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
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
        <form action="{{ route('backend.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex grow gap-5 lg:gap-7.5">
                <!-- Menú lateral -->
                <div class="hidden lg:block w-[230px] shrink-0">
                    <div class="w-[230px]" data-sticky="true" data-sticky-animation="true"
                         data-sticky-class="fixed z-[4] left-auto top-[3rem]" data-sticky-name="scrollspy"
                         data-sticky-offset="200" data-sticky-target="#scrollable_content">
                        <x-primary-button class="px-6 py-2 mb-3">{{ __('Guardar Cambios') }}</x-primary-button>
                        <!-- Mismo menú de navegación que en create -->
                        <div class="flex flex-col grow relative before:absolute before:left-[11px] before:top-0 before:bottom-0 before:border-l before:border-gray-200"
                             data-scrollspy="true" data-scrollspy-offset="80px|lg:110px"
                             data-scrollspy-target="#scrollable_content">
                            <!-- Mismo contenido del menú que en create -->
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
                                    <x-text-input id="address" name="address" type="text"
                                                  :value="old('address', $property->address)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('address')"/>
                                </div>
                            </div>

                            <!-- Zona, Superficie terreno, Superficie Construido -->
                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="neighborhood" :value="__('Zona')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="neighborhood" name="neighborhood" type="text"
                                                  :value="old('neighborhood', $property->neighborhood)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('neighborhood')"/>
                                </div>
                                <div>
                                    <x-input-label for="size" :value="__('Superficie terreno (MT2)')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="size" name="size" type="number"
                                                  :value="old('size', $property->size)" class="w-full"/>
                                    <x-input-error class="mt-1" :messages="$errors->get('size')"/>
                                </div>
                                <div>
                                    <x-input-label for="size_max" :value="__('Superficie Construido (MT2)')" class="mb-2 text-gray-700"/>
                                    <x-text-input id="size_max" name="size_max" type="number"
                                                  :value="old('size_max', $property->size_max)" class="w-full"/>
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
                                    <x-input-label for="propertytype_id" :value="__('¿Tipo Propiedad?')" class="mb-2 text-gray-700"/>
                                    <x-select-input
                                        class="w-full"
                                        id="propertytype_id"
                                        name="propertytype_id"
                                        :options="['' => 'Seleccione un tipo de propiedad'] + $propertyTypes->pluck('type_name', 'id')->toArray()"
                                        :selected="old('propertytype_id', $property->propertytype_id)"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('propertytype_id')"/>
                                </div>
                                <!-- Continuar con los demás campos... -->
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
                                            <div id="thumbnail-preview-area" class="w-full h-full flex flex-col items-center justify-center cursor-pointer">
                                                @if($property->thumbnail)
                                                    <img id="thumbnail-preview" src="{{ asset('storage/' . $property->thumbnail) }}"
                                                         alt="Imagen principal" class="max-h-full object-cover">
                                                @endif
                                                <div id="thumbnail-placeholder" class="text-center {{ $property->thumbnail ? 'hidden' : '' }}">
                                                    <!-- Placeholder content -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Imágenes Adicionales -->
                                <div>
                                    <label class="text-gray-700 text-sm font-medium mb-2">Imágenes Adicionales</label>
                                    <div class="mt-2">
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg h-[300px] relative" id="drop-zone">
                                            <input type="file" id="additional-images" name="images[]" multiple accept="image/*" class="hidden"/>
                                            <div id="drop-placeholder" class="text-center">
                                                <!-- Placeholder content -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Grid de imágenes existentes -->
                            <div class="mt-6">
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4" id="preview-grid">
                                    @foreach($property->images as $image)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $image->name) }}"
                                                 alt="Imagen de propiedad"
                                                 class="w-full h-32 object-cover rounded">
                                            <button type="button"
                                                    data-image-id="{{ $image->id }}"
                                                    class="delete-image absolute top-2 right-2 bg-red-500 text-white rounded-full p-1
                                                           opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Continuar con las demás secciones siguiendo el mismo patrón -->

                </div>
            </div>
        </form>
    </div>
</x-app-layout>
