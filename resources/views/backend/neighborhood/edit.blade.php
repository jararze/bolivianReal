<x-app-layout>

    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Configuracion') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.property-types.index') }}">
                {{ __('Ciudades') }}
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
            Editar Barrio
           </span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5 xl:w-[38.75rem] mx-auto">
            <div class="card pb-2.5">
                <div class="card-header" id="basic_settings">
                    <h3 class="card-title">
                        Barrio
                    </h3>
                </div>
                <form method="post" action="{{ route('backend.neighborhood.update', $neighborhood->id) }}" class="mt-6 space-y-6">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="card-body grid gap-5">
                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="name" :value="__('Name')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-text-input id="name" name="name" type="text" :value="$neighborhood->name" autofocus required
                                              autocomplete="name" class="w-full"/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                            </div>
                        </div>

                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="city_id" :value="__('Ciudad')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-select-input
                                    id="city_id"
                                    name="city_id"
                                    :options="['' => 'Seleccione una ciudad'] + $neighborhood->city->pluck('name', 'id')->toArray()"
                                    selected="{{ $neighborhood->city_id }}"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('city_id')"/>
                            </div>

                        </div>

                        <div class="flex items-baseline gap-2.5 w-full">
                            <x-input-label for="status" :value="__('Estado')" class="w-1/4"/>
                            <div class="w-3/4">
                                <x-select-input
                                    id="status"
                                    name="status"
                                    :options="['1' => 'Activo', '0' => 'Inactivo']"
                                    selected="{{ $neighborhood->status }}"
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
