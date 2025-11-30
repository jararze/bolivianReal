<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Nuevo Cliente</h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.clients.index') }}">
                Clientes
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Nuevo</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <form action="{{ route('backend.clients.store') }}" method="POST">
            @csrf

            <div class="flex gap-5 lg:gap-7.5">
                <!-- Botón Guardar Sticky -->
                <div class="hidden lg:block w-[230px] shrink-0">
                    <div class="w-[230px]" data-sticky="true" data-sticky-class="fixed z-[4] left-auto top-[3rem]" data-sticky-offset="200">
                        <button type="submit" class="btn btn-primary w-full mb-3">
                            <i class="ki-filled ki-check"></i>
                            Guardar Cliente
                        </button>
                        <a href="{{ route('backend.clients.index') }}" class="btn btn-light w-full">
                            <i class="ki-filled ki-cross"></i>
                            Cancelar
                        </a>
                    </div>
                </div>

                <!-- Formulario Principal -->
                <div class="flex flex-col items-stretch grow gap-5 lg:gap-7.5">

                    <!-- Información Personal -->
                    <div class="card p-6">
                        <div class="card-header mb-6">
                            <h3 class="text-xl font-semibold">Información Personal</h3>
                        </div>
                        <div class="space-y-6">
                            <!-- Nombre y Apellido -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="name" value="Nombre Completo" class="text-gray-700 required" />
                                <div class="col-span-3 grid grid-cols-2 gap-4">
                                    <div>
                                        <x-text-input
                                            id="name"
                                            name="name"
                                            type="text"
                                            class="w-full"
                                            placeholder="Nombre"
                                            :value="old('name')"
                                            required
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('name')"/>
                                    </div>
                                    <div>
                                        <x-text-input
                                            id="lastname"
                                            name="lastname"
                                            type="text"
                                            class="w-full"
                                            placeholder="Apellido"
                                            :value="old('lastname')"
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('lastname')"/>
                                    </div>
                                </div>
                            </div>

                            <!-- CI/Documento -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="ci" value="CI/Documento" class="text-gray-700" />
                                <div class="col-span-3">
                                    <x-text-input
                                        id="ci"
                                        name="ci"
                                        type="text"
                                        class="w-full"
                                        placeholder="Cédula de Identidad o Documento"
                                        :value="old('ci')"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('ci')"/>
                                </div>
                            </div>

                            <!-- Tipo de Cliente -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="client_type" value="Tipo de Cliente" class="text-gray-700 required" />
                                <div class="col-span-3">
                                    <select id="client_type" name="client_type" class="select w-full" required>
                                        <option value="">Seleccionar tipo...</option>
                                        <option value="owner" {{ old('client_type') === 'owner' ? 'selected' : '' }}>Propietario</option>
                                        <option value="buyer" {{ old('client_type') === 'buyer' ? 'selected' : '' }}>Comprador</option>
                                        <option value="tenant" {{ old('client_type') === 'tenant' ? 'selected' : '' }}>Inquilino</option>
                                        <option value="both" {{ old('client_type') === 'both' ? 'selected' : '' }}>Propietario e Inquilino</option>
                                    </select>
                                    <x-input-error class="mt-1" :messages="$errors->get('client_type')"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="card p-6">
                        <div class="card-header mb-6">
                            <h3 class="text-xl font-semibold">Información de Contacto</h3>
                        </div>
                        <div class="space-y-6">
                            <!-- Teléfonos -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="phone" value="Teléfonos" class="text-gray-700" />
                                <div class="col-span-3 grid grid-cols-2 gap-4">
                                    <div>
                                        <x-text-input
                                            id="phone"
                                            name="phone"
                                            type="text"
                                            class="w-full"
                                            placeholder="Teléfono Principal"
                                            :value="old('phone')"
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('phone')"/>
                                    </div>
                                    <div>
                                        <x-text-input
                                            id="phone_secondary"
                                            name="phone_secondary"
                                            type="text"
                                            class="w-full"
                                            placeholder="Teléfono Secundario"
                                            :value="old('phone_secondary')"
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('phone_secondary')"/>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="email" value="Email" class="text-gray-700" />
                                <div class="col-span-3">
                                    <x-text-input
                                        id="email"
                                        name="email"
                                        type="email"
                                        class="w-full"
                                        placeholder="correo@ejemplo.com"
                                        :value="old('email')"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('email')"/>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="address" value="Dirección" class="text-gray-700" />
                                <div class="col-span-3">
                                    <x-text-input
                                        id="address"
                                        name="address"
                                        type="text"
                                        class="w-full"
                                        placeholder="Dirección completa"
                                        :value="old('address')"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('address')"/>
                                </div>
                            </div>

                            <!-- Ciudad -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="city" value="Ciudad" class="text-gray-700" />
                                <div class="col-span-3">
                                    <x-text-input
                                        id="city"
                                        name="city"
                                        type="text"
                                        class="w-full"
                                        placeholder="Ciudad"
                                        :value="old('city')"
                                    />
                                    <x-input-error class="mt-1" :messages="$errors->get('city')"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notas y Estado -->
                    <div class="card p-6">
                        <div class="card-header mb-6">
                            <h3 class="text-xl font-semibold">Información Adicional</h3>
                        </div>
                        <div class="space-y-6">
                            <!-- Notas -->
                            <div class="grid grid-cols-4 gap-4 items-start">
                                <x-input-label for="notes" value="Notas" class="text-gray-700 pt-2" />
                                <div class="col-span-3">
                                    <textarea
                                        id="notes"
                                        name="notes"
                                        rows="4"
                                        class="input w-full"
                                        placeholder="Observaciones, preferencias, información relevante..."
                                    >{{ old('notes') }}</textarea>
                                    <x-input-error class="mt-1" :messages="$errors->get('notes')"/>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="status" value="Estado" class="text-gray-700 required" />
                                <div class="col-span-3">
                                    <div class="flex items-center gap-2">
                                        <label class="switch">
                                            <input
                                                type="checkbox"
                                                name="status"
                                                id="status"
                                                value="1"
                                                {{ old('status', '1') ? 'checked' : '' }}
                                            >
                                        </label>
                                        <span class="text-sm text-gray-700">Cliente activo</span>
                                    </div>
                                    <x-input-error class="mt-1" :messages="$errors->get('status')"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones Mobile -->
                    <div class="lg:hidden flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1">
                            <i class="ki-filled ki-check"></i>
                            Guardar Cliente
                        </button>
                        <a href="{{ route('backend.clients.index') }}" class="btn btn-light flex-1">
                            <i class="ki-filled ki-cross"></i>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
