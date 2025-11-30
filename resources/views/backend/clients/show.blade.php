<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Detalles del Cliente</h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.clients.index') }}">
                Clientes
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">{{ $client->full_name }}</span>
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
                        <div class="flex gap-2">
                            <a href="{{ route('backend.clients.edit', $client) }}" class="btn btn-sm btn-primary">
                                <i class="ki-filled ki-notepad-edit"></i>
                                Editar
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-600 mb-1">Nombre Completo</p>
                                <p class="font-semibold text-gray-900">{{ $client->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 mb-1">CI/Documento</p>
                                <p class="font-semibold text-gray-900">{{ $client->ci ?? 'No registrado' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 mb-1">Tipo de Cliente</p>
                                @php
                                    $typeLabels = [
                                        'owner' => 'Propietario',
                                        'buyer' => 'Comprador',
                                        'tenant' => 'Inquilino',
                                        'both' => 'Propietario e Inquilino'
                                    ];
                                    $typeColors = [
                                        'owner' => 'primary',
                                        'buyer' => 'success',
                                        'tenant' => 'warning',
                                        'both' => 'info'
                                    ];
                                @endphp
                                <span class="badge badge-{{ $typeColors[$client->client_type] ?? 'light' }}">
                                    {{ $typeLabels[$client->client_type] ?? 'N/A' }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 mb-1">Estado</p>
                                <span class="badge badge-{{ $client->status ? 'success' : 'danger' }}">
                                    {{ $client->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información de Contacto</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            @if($client->phone)
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-full bg-primary-light flex items-center justify-center">
                                        <i class="ki-filled ki-phone text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Teléfono Principal</p>
                                        <a href="tel:{{ $client->phone }}" class="font-semibold text-gray-900 hover:text-primary">
                                            {{ $client->phone }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($client->phone_secondary)
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-full bg-info-light flex items-center justify-center">
                                        <i class="ki-filled ki-phone text-info"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Teléfono Secundario</p>
                                        <a href="tel:{{ $client->phone_secondary }}" class="font-semibold text-gray-900 hover:text-primary">
                                            {{ $client->phone_secondary }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($client->email)
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-full bg-success-light flex items-center justify-center">
                                        <i class="ki-filled ki-sms text-success"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Email</p>
                                        <a href="mailto:{{ $client->email }}" class="font-semibold text-gray-900 hover:text-primary">
                                            {{ $client->email }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($client->address)
                                <div class="flex items-start gap-3">
                                    <div class="size-10 rounded-full bg-warning-light flex items-center justify-center">
                                        <i class="ki-filled ki-geolocation text-warning"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Dirección</p>
                                        <p class="font-semibold text-gray-900">{{ $client->address }}</p>
                                        @if($client->city)
                                            <p class="text-sm text-gray-600">{{ $client->city }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if(!$client->phone && !$client->email && !$client->address)
                                <p class="text-center text-gray-500 py-4">No hay información de contacto registrada</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notas -->
                @if($client->notes)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notas</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-gray-700 whitespace-pre-line">{{ $client->notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Propiedades Asociadas -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Propiedades Asociadas ({{ $client->properties->count() }})</h3>
                    </div>
                    <div class="card-body">
                        @forelse($client->properties as $property)
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
                                <p class="text-gray-500 mt-2">No hay propiedades asociadas a este cliente</p>
                                <a href="{{ route('backend.properties.create') }}" class="btn btn-sm btn-primary mt-3">
                                    <i class="ki-filled ki-plus"></i>
                                    Agregar Propiedad
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Columna Lateral (1/3) -->
            <div class="space-y-5">

                <!-- Resumen Rápido -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Resumen</h3>
                    </div>
                    <div class="card-body space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Propiedades</span>
                            <span class="badge badge-primary">{{ $client->properties->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Registrado</span>
                            <span class="text-sm text-gray-900">{{ $client->created_at->format('d/m/Y') }}</span>
                        </div>
                        @if($client->createdBy)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Creado por</span>
                                <span class="text-sm text-gray-900">{{ $client->createdBy->name }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Última actualización</span>
                            <span class="text-sm text-gray-900">{{ $client->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Acciones</h3>
                    </div>
                    <div class="card-body space-y-2">
                        <a href="{{ route('backend.clients.edit', $client) }}" class="btn btn-primary w-full">
                            <i class="ki-filled ki-notepad-edit"></i>
                            Editar Cliente
                        </a>
                        <a href="{{ route('backend.properties.create') }}" class="btn btn-success w-full">
                            <i class="ki-filled ki-plus"></i>
                            Nueva Propiedad
                        </a>
                        <form action="{{ route('backend.clients.toggle-status', $client) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="btn btn-warning w-full">
                                <i class="ki-filled ki-toggle-{{ $client->status ? 'off' : 'on' }}"></i>
                                {{ $client->status ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                        @if($client->properties->count() === 0)
                            <form action="{{ route('backend.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('¿Eliminar este cliente?')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-full">
                                    <i class="ki-filled ki-trash"></i>
                                    Eliminar Cliente
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
