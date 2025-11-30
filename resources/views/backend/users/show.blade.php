<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Detalles del Usuario</h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.users.index') }}">
                Usuarios
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">{{ $user->full_name }}</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5">

            <!-- Columna Principal (2/3) -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Perfil del Usuario -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información del Perfil</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('backend.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                <i class="ki-filled ki-notepad-edit"></i>
                                Editar
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex items-start gap-6 mb-6">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" class="size-24 rounded-full object-cover">
                            @else
                                <div class="size-24 rounded-full bg-primary-light flex items-center justify-center">
                                    <span class="text-4xl font-bold text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->full_name }}</h2>
                                @if($user->jobtitle)
                                    <p class="text-gray-600 mb-3">{{ $user->jobtitle }}</p>
                                @endif
                                <div class="flex gap-2">
                                    @php
                                        $roleColors = [
                                            'admin' => 'danger',
                                            'agent' => 'primary',
                                            'user' => 'info'
                                        ];
                                        $roleLabels = [
                                            'admin' => 'Administrador',
                                            'agent' => 'Agente',
                                            'user' => 'Usuario'
                                        ];
                                    @endphp
                                    <span class="badge badge-{{ $roleColors[$user->role] ?? 'light' }} badge-lg">
                                        {{ $roleLabels[$user->role] ?? $user->role }}
                                    </span>
                                    <span class="badge badge-{{ $user->status === 'active' ? 'success' : 'danger' }} badge-lg">
                                        {{ $user->status === 'active' ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-600 mb-1">Email</p>
                                <a href="mailto:{{ $user->email }}" class="font-semibold text-gray-900 hover:text-primary">
                                    {{ $user->email }}
                                </a>
                            </div>
                            @if($user->username)
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Nombre de Usuario</p>
                                    <p class="font-semibold text-gray-900">{{ $user->username }}</p>
                                </div>
                            @endif
                            @if($user->phone)
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Teléfono</p>
                                    <a href="tel:{{ $user->phone }}" class="font-semibold text-gray-900 hover:text-primary">
                                        {{ $user->phone }}
                                    </a>
                                </div>
                            @endif
                            @if($user->package)
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Paquete</p>
                                    <p class="font-semibold text-gray-900">{{ $user->package->name }}</p>
                                </div>
                            @endif
                        </div>

                        @if($user->address || $user->city || $user->country)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs text-gray-600 mb-1">Ubicación</p>
                                <p class="text-gray-900">
                                    @if($user->address){{ $user->address }}@endif
                                    @if($user->city), {{ $user->city }}@endif
                                    @if($user->country), {{ $user->country }}@endif
                                </p>
                            </div>
                        @endif

                        @if($user->aboutme)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs text-gray-600 mb-1">Acerca de</p>
                                <p class="text-gray-700 whitespace-pre-line">{{ $user->aboutme }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Propiedades del Usuario -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Propiedades Gestionadas ({{ $stats['properties'] }})</h3>
                    </div>
                    <div class="card-body">
                        @forelse($user->properties->take(10) as $property)
                            <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow mb-3">
                                @if($property->thumbnail)
                                    <img src="{{ asset('storage/' . $property->thumbnail) }}" class="size-20 rounded-lg object-cover">
                                @else
                                    <div class="size-20 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="ki-filled ki-home text-3xl text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <a href="{{ route('backend.properties.edit', $property) }}" class="font-semibold text-gray-900 hover:text-primary">
                                        {{ $property->name }}
                                    </a>
                                    <p class="text-sm text-gray-600">{{ $property->propertyType->type_name ?? 'Sin tipo' }}</p>
                                    <p class="text-sm text-gray-600">{{ $property->citys->name ?? 'Sin ciudad' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-primary">{{ $property->currency }} {{ number_format($property->lowest_price, 0) }}</p>
                                    <span class="badge badge-sm badge-{{ $property->status ? 'success' : 'danger' }}">
                                        {{ $property->status ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="ki-filled ki-home text-6xl text-gray-300"></i>
                                <p class="text-gray-500 mt-2">No hay propiedades gestionadas por este usuario</p>
                            </div>
                        @endforelse

                        @if($user->properties->count() > 10)
                            <div class="text-center mt-4">
                                <a href="{{ route('backend.properties.index', ['agent_id' => $user->id]) }}" class="btn btn-sm btn-light">
                                    Ver todas las propiedades ({{ $user->properties->count() }})
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Columna Lateral (1/3) -->
            <div class="space-y-5">

                <!-- Estadísticas -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estadísticas</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="size-12 rounded-lg bg-primary-light flex items-center justify-center">
                                <i class="ki-filled ki-home text-xl text-primary"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Propiedades</p>
                                <p class="text-xl font-bold text-gray-900">{{ $stats['properties'] }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="size-12 rounded-lg bg-success-light flex items-center justify-center">
                                <i class="ki-filled ki-check-circle text-xl text-success"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Activas</p>
                                <p class="text-xl font-bold text-gray-900">{{ $stats['active_properties'] }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="size-12 rounded-lg bg-info-light flex items-center justify-center">
                                <i class="ki-filled ki-document text-xl text-info"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Contratos</p>
                                <p class="text-xl font-bold text-gray-900">{{ $stats['contracts'] }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="size-12 rounded-lg bg-warning-light flex items-center justify-center">
                                <i class="ki-filled ki-people text-xl text-warning"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Clientes</p>
                                <p class="text-xl font-bold text-gray-900">{{ $stats['clients'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Sistema -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información del Sistema</h3>
                    </div>
                    <div class="card-body space-y-3">
                        <div>
                            <p class="text-xs text-gray-600">Fecha de Registro</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Última Actualización</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                        @if($user->email_verified_at)
                            <div>
                                <p class="text-xs text-gray-600">Email Verificado</p>
                                <p class="text-sm font-semibold text-success">
                                    <i class="ki-filled ki-check-circle"></i>
                                    {{ $user->email_verified_at->format('d/m/Y') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Acciones</h3>
                    </div>
                    <div class="card-body space-y-2">
                        <a href="{{ route('backend.users.edit', $user) }}" class="btn btn-primary w-full">
                            <i class="ki-filled ki-notepad-edit"></i>
                            Editar Usuario
                        </a>
                        <form action="{{ route('backend.users.toggle-status', $user) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="btn btn-warning w-full">
                                <i class="ki-filled ki-toggle-{{ $user->status === 'active' ? 'off' : 'on' }}"></i>
                                {{ $user->status === 'active' ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                        @if(auth()->id() !== $user->id && $user->properties->count() === 0)
                            <form action="{{ route('backend.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-full">
                                    <i class="ki-filled ki-trash"></i>
                                    Eliminar Usuario
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
