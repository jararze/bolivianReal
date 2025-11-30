<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Detalles del Contrato</h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.tenants.index') }}">
                Inquilinos
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Contrato #{{ $contract->id }}</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5">

            <!-- Columna Principal (2/3) -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Información del Inquilino -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información del Inquilino</h3>
                        @if($contract->tenant_ci)
                            <a href="{{ route('backend.tenants.history', ['ci' => $contract->tenant_ci]) }}" class="btn btn-sm btn-info">
                                <i class="ki-filled ki-time"></i>
                                Ver Historial
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="size-16 rounded-full bg-primary-light flex items-center justify-center">
                                <span class="text-2xl font-bold text-primary">{{ strtoupper(substr($contract->tenant_name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $contract->tenant_name }}</h2>
                                @if($contract->tenant_ci)
                                    <p class="text-gray-600">CI: {{ $contract->tenant_ci }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            @if($contract->tenant_phone)
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Teléfono</p>
                                    <a href="tel:{{ $contract->tenant_phone }}" class="font-semibold text-gray-900 hover:text-primary">
                                        {{ $contract->tenant_phone }}
                                    </a>
                                </div>
                            @endif

                            @if($contract->tenant_email)
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Email</p>
                                    <a href="mailto:{{ $contract->tenant_email }}" class="font-semibold text-gray-900 hover:text-primary">
                                        {{ $contract->tenant_email }}
                                    </a>
                                </div>
                            @endif

                            @if($contract->tenant_address)
                                <div class="md:col-span-2">
                                    <p class="text-xs text-gray-600 mb-1">Dirección</p>
                                    <p class="font-semibold text-gray-900">{{ $contract->tenant_address }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información del Contrato -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detalles del Contrato</h3>
                        <span class="badge badge-{{ $contract->getStatusBadgeClass() }} badge-lg">
                            {{ $contract->getStatusLabel() }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-600 mb-1">Tipo de Contrato</p>
                                <span class="badge badge-{{ $contract->contract_type === 'rent' ? 'primary' : 'warning' }} badge-lg">
                                    {{ $contract->getContractTypeLabel() }}
                                </span>
                            </div>

                            <div>
                                <p class="text-xs text-gray-600 mb-1">Monto</p>
                                <p class="text-2xl font-bold text-primary">{{ $contract->getFormattedAmount() }}</p>
                                @if($contract->contract_type === 'rent')
                                    <p class="text-sm text-gray-600">Pago mensual</p>
                                @endif
                            </div>

                            <div>
                                <p class="text-xs text-gray-600 mb-1">Fecha de Inicio</p>
                                <p class="font-semibold text-gray-900">{{ $contract->start_date->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-600 mb-1">Fecha de Fin</p>
                                <p class="font-semibold text-gray-900">{{ $contract->end_date->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-600 mb-1">Duración</p>
                                <p class="font-semibold text-gray-900">{{ $contract->duration_months }} meses</p>
                            </div>

                            @if($contract->status === 'active')
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Días Restantes</p>
                                    <p class="font-semibold {{ $contract->getDaysRemaining() < 30 ? 'text-danger' : 'text-gray-900' }}">
                                        {{ $contract->getDaysRemaining() }} días
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if($contract->notes)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-xs text-gray-600 mb-2">Notas</p>
                                <p class="text-gray-700 whitespace-pre-line">{{ $contract->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Información de la Propiedad -->
                @if($contract->property)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Propiedad Arrendada</h3>
                            <a href="{{ route('backend.properties.edit', $contract->property) }}" class="btn btn-sm btn-light">
                                <i class="ki-filled ki-eye"></i>
                                Ver Propiedad
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="flex gap-4">
                                @if($contract->property->thumbnail)
                                    <img src="{{ asset('storage/' . $contract->property->thumbnail) }}" class="size-32 rounded-lg object-cover">
                                @else
                                    <div class="size-32 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="ki-filled ki-home text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $contract->property->name }}</h3>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <p class="text-xs text-gray-600">Tipo</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $contract->property->propertyType->type_name ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600">Ciudad</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $contract->property->citys->name ?? '-' }}</p>
                                        </div>
                                        @if($contract->property->client)
                                            <div class="col-span-2">
                                                <p class="text-xs text-gray-600">Propietario</p>
                                                <a href="{{ route('backend.clients.show', $contract->property->client) }}" class="text-sm font-semibold text-primary hover:underline">
                                                    {{ $contract->property->client->full_name }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Columna Lateral (1/3) -->
            <div class="space-y-5">

                <!-- Alertas del Contrato -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Alertas</h3>
                    </div>
                    <div class="card-body space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">3 meses</span>
                            @if($contract->alert_3months_sent)
                                <span class="badge badge-success">
                                    <i class="ki-filled ki-check"></i>
                                    Enviada
                                </span>
                            @else
                                <span class="badge badge-gray">Pendiente</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">1 mes</span>
                            @if($contract->alert_1month_sent)
                                <span class="badge badge-success">
                                    <i class="ki-filled ki-check"></i>
                                    Enviada
                                </span>
                            @else
                                <span class="badge badge-gray">Pendiente</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">1 semana</span>
                            @if($contract->alert_1week_sent)
                                <span class="badge badge-success">
                                    <i class="ki-filled ki-check"></i>
                                    Enviada
                                </span>
                            @else
                                <span class="badge badge-gray">Pendiente</span>
                            @endif
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
                            <p class="text-xs text-gray-600">Creado</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $contract->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($contract->createdBy)
                            <div>
                                <p class="text-xs text-gray-600">Creado por</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $contract->createdBy->full_name }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs text-gray-600">Última actualización</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $contract->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Acciones</h3>
                    </div>
                    <div class="card-body space-y-2">
                        @if($contract->property)
                            <a href="{{ route('backend.properties.edit', $contract->property) }}" class="btn btn-light w-full">
                                <i class="ki-filled ki-home"></i>
                                Ver Propiedad
                            </a>
                        @endif

                        @if($contract->tenant_ci)
                            <a href="{{ route('backend.tenants.history', ['ci' => $contract->tenant_ci]) }}" class="btn btn-info w-full">
                                <i class="ki-filled ki-time"></i>
                                Historial del Inquilino
                            </a>
                        @endif

                        <a href="{{ route('backend.tenants.index') }}" class="btn btn-light w-full">
                            <i class="ki-filled ki-left"></i>
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
