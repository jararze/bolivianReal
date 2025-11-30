<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Editar Usuario</h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.users.index') }}">
                Usuarios
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">{{ $user->full_name }}</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <form action="{{ route('backend.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex gap-5 lg:gap-7.5">
                <!-- Botones Sticky -->
                <div class="hidden lg:block w-[230px] shrink-0">
                    <div class="w-[230px]" data-sticky="true" data-sticky-class="fixed z-[4] left-auto top-[3rem]" data-sticky-offset="200">
                        <button type="submit" class="btn btn-primary w-full mb-3">
                            <i class="ki-filled ki-check"></i>
                            Actualizar
                        </button>
                        <a href="{{ route('backend.users.show', $user) }}" class="btn btn-light w-full mb-2">
                            <i class="ki-filled ki-eye"></i>
                            Ver Detalles
                        </a>
                        <a href="{{ route('backend.users.index') }}" class="btn btn-light w-full">
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
                                            :value="old('name', $user->name)"
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
                                            :value="old('lastname', $user->lastname)"
                                            required
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('lastname')"/>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="email" value="Email" class="text-gray-700 required" />
                                <div class="col-span-3 grid grid-cols-2 gap-4">
                                    <div>
                                        <x-text-input
                                            id="email"
                                            name="email"
                                            type="email"
                                            class="w-full"
                                            placeholder="correo@ejemplo.com"
                                            :value="old('email', $user->email)"
                                            required
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('email')"/>
                                    </div>
                                    <div>
                                        <x-text-input
                                            id="username"
                                            name="username"
                                            type="text"
                                            class="w-full"
                                            placeholder="Nombre de usuario"
                                            :value="old('username', $user->username)"
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('username')"/>
                                    </div>
                                </div>
                            </div>

                            <!-- Cambiar Contraseña (Opcional) -->
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="password" value="Nueva Contraseña" class="text-gray-700" />
                                <div class="col-span-3 grid grid-cols-2 gap-4">
                                    <div>
                                        <x-text-input
                                            id="password"
                                            name="password"
                                            type="password"
                                            class="w-full"
                                            placeholder="Dejar en blanco para no cambiar"
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('password')"/>
                                    </div>
                                    <div>
                                        <x-text-input
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            type="password"
                                            class="w-full"
                                            placeholder="Confirmar contraseña"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="phone" value="Teléfono" class="text-gray-700" />
                                <div class="col-span-3 grid grid-cols-2 gap-4">
                                    <div>
                                        <x-text-input
                                            id="phone"
                                            name="phone"
                                            type="text"
                                            class="w-full"
                                            placeholder="Teléfono"
                                            :value="old('phone', $user->phone)"
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('phone')"/>
                                    </div>
                                    <div>
                                        <x-text-input
                                            id="jobtitle"
                                            name="jobtitle"
                                            type="text"
                                            class="w-full"
                                            placeholder="Cargo"
                                            :value="old('jobtitle', $user->jobtitle)"
                                        />
                                        <x-input-error class="mt-1" :messages="$errors->get('jobtitle')"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rol y Permisos -->
                    <div class="card p-6">
                        <div class="card-header mb-6">
                            <h3 class="text-xl font-semibold">Rol y Permisos</h3>
                        </div>
                        <div class="space-y-6">
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="role" value="Rol" class="text-gray-700 required" />
                                <div class="col-span-3">
                                    <select id="role" name="role" class="select w-full" required>
                                        <option value="">Seleccionar rol...</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                                        <option value="agent" {{ old('role', $user->role) === 'agent' ? 'selected' : '' }}>Agente</option>
                                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Usuario</option>
                                    </select>
                                    <x-input-error class="mt-1" :messages="$errors->get('role')"/>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="package_id" value="Paquete" class="text-gray-700" />
                                <div class="col-span-3">
                                    <select id="package_id" name="package_id" class="select w-full">
                                        <option value="">Sin paquete</option>
                                        @foreach(\App\Models\Package::where('status', true)->get() as $package)
                                            <option value="{{ $package->id }}" {{ old('package_id', $user->package_id) == $package->id ? 'selected' : '' }}>
                                                {{ $package->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-1" :messages="$errors->get('package_id')"/>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 items-center">
                                <x-input-label for="status" value="Estado" class="text-gray-700 required" />
                                <div class="col-span-3">
                                    <select id="status" name="status" class="select w-full" required>
                                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    <x-input-error class="mt-1" :messages="$errors->get('status')"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones Mobile -->
                    <div class="lg:hidden flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1">
                            <i class="ki-filled ki-check"></i>
                            Actualizar
                        </button>
                        <a href="{{ route('backend.users.index') }}" class="btn btn-light flex-1">
                            <i class="ki-filled ki-cross"></i>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
