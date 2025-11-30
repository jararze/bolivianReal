<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Mi Perfil</h1>
        <div class="flex items-center gap-2">
            @if(auth()->user()->role === 'agent')
                <a href="{{ route('backend.properties.index', ['agent_id' => auth()->id()]) }}" class="btn btn-light btn-sm">
                    <i class="ki-filled ki-home-2"></i>
                    Mis Propiedades
                </a>
            @endif
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5">

            <!-- Columna Principal (2/3) -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Información Personal -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información Personal</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-5">
                                <!-- Foto de Perfil -->
                                <div class="flex items-start gap-4">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" class="size-24 rounded-full object-cover">
                                    @else
                                        <div class="size-24 rounded-full bg-primary-light flex items-center justify-center">
                                            <span class="text-4xl font-bold text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <x-input-label for="photo" value="Foto de Perfil" class="mb-2" />
                                        <input type="file" id="photo" name="photo" class="input" accept="image/*">
                                        <p class="text-xs text-gray-600 mt-1">JPG, PNG o GIF. Máximo 2MB.</p>
                                        <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                                    </div>
                                </div>

                                <!-- Nombre y Apellido -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="name" value="Nombre *" />
                                        <x-text-input id="name" name="name" type="text" class="w-full mt-1"
                                                      :value="old('name', $user->name)" required />
                                        <x-input-error class="mt-1" :messages="$errors->get('name')" />
                                    </div>
                                    <div>
                                        <x-input-label for="lastname" value="Apellido *" />
                                        <x-text-input id="lastname" name="lastname" type="text" class="w-full mt-1"
                                                      :value="old('lastname', $user->lastname)" required />
                                        <x-input-error class="mt-1" :messages="$errors->get('lastname')" />
                                    </div>
                                </div>

                                <!-- Email y Username -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="email" value="Email *" />
                                        <x-text-input id="email" name="email" type="email" class="w-full mt-1"
                                                      :value="old('email', $user->email)" required />
                                        <x-input-error class="mt-1" :messages="$errors->get('email')" />

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                            <div class="mt-2">
                                                <p class="text-sm text-warning">Tu email no está verificado.</p>
                                                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-sm text-primary hover:underline">
                                                        Reenviar email de verificación
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <x-input-label for="username" value="Nombre de Usuario" />
                                        <x-text-input id="username" name="username" type="text" class="w-full mt-1"
                                                      :value="old('username', $user->username)" />
                                        <x-input-error class="mt-1" :messages="$errors->get('username')" />
                                    </div>
                                </div>

                                <!-- Teléfono y Cargo -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="phone" value="Teléfono" />
                                        <x-text-input id="phone" name="phone" type="text" class="w-full mt-1"
                                                      :value="old('phone', $user->phone)" />
                                        <x-input-error class="mt-1" :messages="$errors->get('phone')" />
                                    </div>
                                    <div>
                                        <x-input-label for="jobtitle" value="Cargo" />
                                        <x-text-input id="jobtitle" name="jobtitle" type="text" class="w-full mt-1"
                                                      :value="old('jobtitle', $user->jobtitle)"
                                                      placeholder="Ej: Agente Senior, Broker" />
                                        <x-input-error class="mt-1" :messages="$errors->get('jobtitle')" />
                                    </div>
                                </div>

                                <!-- Dirección -->
                                <div>
                                    <x-input-label for="address" value="Dirección" />
                                    <x-text-input id="address" name="address" type="text" class="w-full mt-1"
                                                  :value="old('address', $user->address)" />
                                    <x-input-error class="mt-1" :messages="$errors->get('address')" />
                                </div>

                                <!-- Ciudad y País -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="city" value="Ciudad" />
                                        <x-text-input id="city" name="city" type="text" class="w-full mt-1"
                                                      :value="old('city', $user->city)" />
                                        <x-input-error class="mt-1" :messages="$errors->get('city')" />
                                    </div>
                                    <div>
                                        <x-input-label for="country" value="País" />
                                        <x-text-input id="country" name="country" type="text" class="w-full mt-1"
                                                      :value="old('country', $user->country)" />
                                        <x-input-error class="mt-1" :messages="$errors->get('country')" />
                                    </div>
                                </div>

                                <!-- Acerca de Mí -->
                                <div>
                                    <x-input-label for="aboutme" value="Acerca de Mí" />
                                    <textarea id="aboutme" name="aboutme" rows="4" class="input w-full mt-1"
                                              placeholder="Cuéntanos sobre ti...">{{ old('aboutme', $user->aboutme) }}</textarea>
                                    <x-input-error class="mt-1" :messages="$errors->get('aboutme')" />
                                </div>

                                <!-- Botón Guardar -->
                                <div class="flex items-center gap-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ki-filled ki-check"></i>
                                        Guardar Cambios
                                    </button>

                                    @if (session('status') === 'profile-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition
                                           x-init="setTimeout(() => show = false, 3000)"
                                           class="text-sm text-success">
                                            <i class="ki-filled ki-check-circle"></i>
                                            ¡Perfil actualizado!
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="card" id="password">
                    <div class="card-header">
                        <h3 class="card-title">Cambiar Contraseña</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="space-y-5">
                                <div>
                                    <x-input-label for="current_password" value="Contraseña Actual *" />
                                    <x-text-input id="current_password" name="current_password" type="password"
                                                  class="w-full mt-1" required />
                                    <x-input-error class="mt-1" :messages="$errors->updatePassword->get('current_password')" />
                                </div>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="password" value="Nueva Contraseña *" />
                                        <x-text-input id="password" name="password" type="password"
                                                      class="w-full mt-1" required />
                                        <x-input-error class="mt-1" :messages="$errors->updatePassword->get('password')" />
                                    </div>
                                    <div>
                                        <x-input-label for="password_confirmation" value="Confirmar Contraseña *" />
                                        <x-text-input id="password_confirmation" name="password_confirmation"
                                                      type="password" class="w-full mt-1" required />
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ki-filled ki-key"></i>
                                        Actualizar Contraseña
                                    </button>

                                    @if (session('status') === 'password-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition
                                           x-init="setTimeout(() => show = false, 3000)"
                                           class="text-sm text-success">
                                            <i class="ki-filled ki-check-circle"></i>
                                            ¡Contraseña actualizada!
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Eliminar Cuenta -->
                <div class="card border-danger">
                    <div class="card-header">
                        <h3 class="card-title text-danger">Zona de Peligro</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3">
                            <h4 class="font-semibold text-gray-900">Eliminar Mi Cuenta</h4>
                            <p class="text-sm text-gray-600">
                                Una vez que elimines tu cuenta, todos los datos asociados serán borrados permanentemente.
                                Esta acción no se puede deshacer.
                            </p>
                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                    class="btn btn-danger">
                                <i class="ki-filled ki-trash"></i>
                                Eliminar Mi Cuenta
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Lateral (1/3) -->
            <div class="space-y-5">

                <!-- Información de la Cuenta -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información de la Cuenta</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div>
                            <p class="text-xs text-gray-600">Rol</p>
                            @php
                                $roleColors = ['admin' => 'danger', 'agent' => 'primary', 'user' => 'info'];
                                $roleLabels = ['admin' => 'Administrador', 'agent' => 'Agente', 'user' => 'Usuario'];
                            @endphp
                            <span class="badge badge-{{ $roleColors[$user->role] ?? 'light' }} badge-lg mt-1">
                                {{ $roleLabels[$user->role] ?? $user->role }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs text-gray-600">Estado</p>
                            <span class="badge badge-{{ $user->status === 'active' ? 'success' : 'danger' }} badge-lg mt-1">
                                {{ $user->status === 'active' ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>

                        @if($user->package)
                            <div>
                                <p class="text-xs text-gray-600">Paquete</p>
                                <p class="font-semibold text-gray-900 mt-1">{{ $user->package->name }}</p>
                            </div>
                        @endif

                        <div>
                            <p class="text-xs text-gray-600">Miembro desde</p>
                            <p class="font-semibold text-gray-900 mt-1">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas (solo para agentes) -->
                @if($user->role === 'agent')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Mis Estadísticas</h3>
                        </div>
                        <div class="card-body space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="size-12 rounded-lg bg-primary-light flex items-center justify-center">
                                    <i class="ki-filled ki-home text-xl text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Propiedades</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $user->properties()->count() }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="size-12 rounded-lg bg-success-light flex items-center justify-center">
                                    <i class="ki-filled ki-check-circle text-xl text-success"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Activas</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $user->properties()->where('status', true)->count() }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="size-12 rounded-lg bg-info-light flex items-center justify-center">
                                    <i class="ki-filled ki-people text-xl text-info"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Clientes</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $user->createdClients()->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación para Eliminar Cuenta -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                ¿Estás seguro que deseas eliminar tu cuenta?
            </h2>

            <p class="text-sm text-gray-600 mb-6">
                Una vez eliminada, todos tus datos serán borrados permanentemente.
                Por favor ingresa tu contraseña para confirmar.
            </p>

            <div class="mb-6">
                <x-input-label for="password" value="Contraseña" class="mb-2" />
                <x-text-input id="password" name="password" type="password" class="w-full"
                              placeholder="Tu contraseña actual" required />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="btn btn-light">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-danger">
                    Eliminar Cuenta
                </button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
