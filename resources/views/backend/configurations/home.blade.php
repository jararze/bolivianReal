<x-app-layout>


    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Configuracion') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.configurations.index') }}">
                {{ __('Pagina principal') }}
            </a>
            <span class="text-gray-400 text-sm">
            /
           </span>
            <span class="text-gray-700">
            {{ __('Ajustes de la página principal') }}
           </span>
            <span class="text-gray-400 text-sm">
            /
           </span>
            <span class="text-gray-700">
            {{ __('Infomracion pagina inicio') }}
           </span>
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
                                Configuración de la Página Principal
                            </h3>
                        </div>
                        <form method="post" action="{{ route('backend.configurations.home.update') }}">
                            @csrf

                            <!-- Configuración General -->
                            <div class="card-body lg:py-7.5 py-5">
                                <div class="flex flex-col gap-y-5">
                                    <!-- Tiempo de refresco -->
                                    <div class="flex items-center gap-5">
                                        <div class="w-1/3 text-gray-900 text-sm font-medium">
                                            <x-input-label for="refresh_time" :value="__('Tiempo de refresco (segundos)')"
                                                           class="text-gray-900 text-sm font-medium"/>
                                        </div>
                                        <div class="w-2/3">
                                            <x-text-input id="refresh_time" name="refresh_time" type="number"
                                                          :value="old('refresh_time', $values['refresh_time'])"
                                                          min="1" max="60"
                                                          class="input w-full"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('refresh_time')"/>
                                        </div>
                                    </div>

                                    <!-- URL del video -->
                                    <div class="flex items-center gap-5">
                                        <div class="w-1/3 text-gray-900 text-sm font-medium">
                                            <x-input-label for="video_url" :value="__('URL del video')"
                                                           class="text-gray-900 text-sm font-medium"/>
                                        </div>
                                        <div class="w-2/3">
                                            <x-text-input id="video_url" name="video_url" type="url"
                                                          :value="old('video_url', $values['video_url'])"
                                                          class="input w-full"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('video_url')"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <!-- Sección de Publicar Propiedad -->
                            <div class="card-body lg:py-7.5 py-5">
                                <h3 class="text-lg font-medium text-gray-900 mb-5">
                                    Sección de Publicar Propiedad
                                </h3>
                                <div class="flex flex-col gap-y-5">
                                    <!-- Título -->
                                    <div class="flex items-center gap-5">
                                        <div class="w-1/3 text-gray-900 text-sm font-medium">
                                            <x-input-label for="upload_property_title" :value="__('Título')"
                                                           class="text-gray-900 text-sm font-medium"/>
                                        </div>
                                        <div class="w-2/3">
                                            <x-text-input id="upload_property_title" name="upload_property_title" type="text"
                                                          :value="old('upload_property_title', $values['upload_property_title'])"
                                                          class="input w-full"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('upload_property_title')"/>
                                        </div>
                                    </div>

                                    <!-- Descripción -->
                                    <div class="flex items-center gap-5">
                                        <div class="w-1/3 text-gray-900 text-sm font-medium">
                                            <x-input-label for="upload_property_description" :value="__('Descripción')"
                                                           class="text-gray-900 text-sm font-medium"/>
                                        </div>
                                        <div class="w-2/3">
                                            <x-textarea-input
                                                id="upload_property_description"
                                                name="upload_property_description"
                                                placeholder="Contamos con una amplia base de clientes y las herramientas necesarias para encontrar el comprador ideal para tu propiedad."
                                                rows="6"
                                                value="{{ old('upload_property_description', $values['upload_property_description']) }}"
                                            />
                                            <x-input-error class="mt-2" :messages="$errors->get('upload_property_description')"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <!-- Pasos del proceso -->
                            <div class="card-body lg:py-7.5 py-5">
                                <h3 class="text-lg font-medium text-gray-900 mb-5">
                                    Pasos del Proceso
                                </h3>
                                @foreach($values['steps'] as $index => $step)
                                    <div class="border-b border-gray-200 last:border-0 pb-5 mb-5 last:pb-0 last:mb-0">
                                        <h4 class="font-medium text-gray-900 mb-4">Paso {{ $index + 1 }}</h4>
                                        <div class="flex flex-col gap-y-5">
                                            <!-- Título del paso -->
                                            <div class="flex items-center gap-5">
                                                <div class="w-1/3 text-gray-900 text-sm font-medium">
                                                    <x-input-label :value="__('Título')" class="text-gray-900 text-sm font-medium"/>
                                                </div>
                                                <div class="w-2/3">
                                                    <x-text-input name="steps[{{ $index }}][title]" type="text"
                                                                  :value="old('steps.'.$index.'.title', $step['title'])"
                                                                  class="input w-full"/>
                                                </div>
                                            </div>

                                            <!-- Descripción del paso -->
                                            <div class="flex items-center gap-5">
                                                <div class="w-1/3 text-gray-900 text-sm font-medium">
                                                    <x-input-label :value="__('Descripción')" class="text-gray-900 text-sm font-medium"/>
                                                </div>
                                                <div class="w-2/3">
                                                    <x-textarea-input
                                                        id="steps[{{ $index }}][description]"
                                                        name="steps[{{ $index }}][description]"
                                                        rows="6"
                                                        value="{{ old('steps.'.$index.'.description', $step['description']) }}"
                                                    />
                                                </div>
                                            </div>

                                            <!-- Ícono del paso -->
                                            <div class="flex items-center gap-5">
                                                <div class="w-1/3 text-gray-900 text-sm font-medium">
                                                    <x-input-label :value="__('Ícono')" class="text-gray-900 text-sm font-medium"/>
                                                </div>
                                                <div class="w-2/3">
                                                    <x-text-input name="steps[{{ $index }}][icon]" type="text"
                                                                  :value="old('steps.'.$index.'.icon', $step['icon'])"
                                                                  class="input w-full"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <!-- Footer con botón de guardar -->
                            <div class="card-footer lg:py-7.5 py-5">
                                <div class="flex justify-end">
                                    <x-primary-button>{{ __('Guardar Cambios') }}</x-primary-button>
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
</x-app-layout>
