<x-app-layout>

    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Configuracion') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.property-types.index') }}">
                {{ __('Tipos de propiedades') }}
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
            Editar propiedad
           </span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5 xl:w-[38.75rem] mx-auto">
            <div class="card pb-2.5">
                <div class="card-header" id="basic_settings">
                    <h3 class="card-title">
                        Tipos de propiedades
                    </h3>
                </div>
                <form method="post" action="{{ route('backend.property-types.update', $propertyType->id) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="card-body grid gap-5">
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="type_name" :value="__('Name')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-text-input id="type_name" name="type_name" type="text" :value="$propertyType->type_name" autofocus required
                                              autocomplete="type_name" class="w-full"/>
                                <x-input-error class="mt-2" :messages="$errors->get('type_name')"/>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="type_icon" :value="__('Icono')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-text-input id="type_icon" name="type_icon" type="text" :value="$propertyType->type_icon" autofocus required
                                              autocomplete="type_icon" class="w-full"/>
                                <x-input-error class="mt-2" :messages="$errors->get('type_icon')"/>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="status" :value="__('Estatus')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-select-input
                                    id="status"
                                    name="status"
                                    :options="['1' => 'Activo', '0' => 'Inactivo']"
                                    selected="{{ $propertyType->status }}"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('status')"/>
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
                                    value="{{ $propertyType->description }}"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('description')"/>
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
