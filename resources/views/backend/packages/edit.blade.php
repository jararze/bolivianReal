<x-app-layout>

    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Configuracion') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.packages.index') }}">
                {{ __('Paquetes') }}
            </a>
            <span class="text-gray-400 text-sm">
            /
           </span>
            <span class="text-gray-700">
            Listado
           </span>
            <span class="text-gray-400 text-sm">
            /
           </span>
            <span class="text-gray-900">
            Editar paquete
           </span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5 xl:w-[38.75rem] mx-auto">
            <div class="card pb-2.5">
                <div class="card-header" id="basic_settings">
                    <h3 class="card-title">
                        Paquetes
                    </h3>
                </div>
                <form method="post" action="{{ route('backend.packages.update', $package->id) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="card-body grid gap-5">
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="name" :value="__('Name')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-text-input id="name" name="name" type="text" :value="$package->name" autofocus required
                                              autocomplete="name" class="w-full"/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="description" :value="__('Descripcion')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-textarea-input
                                    id="description"
                                    name="description"
                                    placeholder="Descripción"
                                    rows="6"
                                    value="{{ $package->description }}"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('description')"/>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="price" :value="__('Precio')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-text-input id="price" name="price" type="text" :value="$package->price" autofocus required
                                              autocomplete="price" class="w-full"/>
                                <x-input-error class="mt-2" :messages="$errors->get('price')"/>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="duration" :value="__('Duracion')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-text-input id="duration" name="duration" type="text" :value="$package->duration" autofocus required
                                              autocomplete="duration" class="w-full"/>
                                <x-input-error class="mt-2" :messages="$errors->get('duration')"/>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="credits" :value="__('Creditos')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-text-input id="credits" name="credits" type="text" :value="$package->credits" autofocus required
                                              autocomplete="credits" class="w-full"/>
                                <x-input-error class="mt-2" :messages="$errors->get('credits')"/>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="front_display" :value="__('Se muestra en pantalla?')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-select-input
                                    id="front_display"
                                    name="front_display"
                                    :options="['1' => 'Si', '0' => 'No']"
                                    selected="{{ $package->front_display }}"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('front_display')"/>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="status" :value="__('Estatus')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-select-input
                                    id="status"
                                    name="status"
                                    :options="['1' => 'Activo', '0' => 'Inactivo']"
                                    selected="{{ $package->status }}"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('status')"/>
                            </div>
                        </div>


                        <div class="flex justify-end">
                            <x-primary-button>Guardar Cambios</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>


</x-app-layout>
