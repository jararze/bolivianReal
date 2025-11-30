<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Historial del Inquilino</h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.tenants.index') }}">
                Inquilinos
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">{{ $tenant->tenant_name ?? 'Historial' }}</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        @if($tenant)
            <!-- Información del Inquilino -->
            <div class="card mb-7.5">
                <div class="card-body">
                    <div class="flex items-start gap-6">
                        <div class="size-20 rounded-full bg-primary-light flex items-center justify-center">
                            <span class="text-3xl font-bold text-primary">{{ strtoupper(substr($tenant->tenant_name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $tenant->tenant_name }}</h2>
                            <div class="grid md:grid-cols-4 gap-4">
                                @if($tenant->tenant_ci)
                                    <div>
                                        <p class="text-xs text-gray-600">CI/Documento</p>
                                        <p class="font-semibold text-gray-900">{{ $tenant->tenant_ci }}</p>
                                    </div>
                                @endif
                                @if($tenant->tenant_phone)
                                    <div>
                                        <p class="text-xs text-gray-600">Teléfono</p>
                                        <a href="tel:{{ $tenant->tenant_phone }}" class="font-semibold text-gray-900 hover:text-primary">
                                            {{ $tenant->tenant_phone }}
                                        </a>
                                    </div>
                                @endif
                                @if($tenant->tenant_email)
                                    <div>
                                        <p class="text-xs text-gray-600">Email</p>
                                        <a href="mailto:{{ $tenant->tenant_email }}" class="font-semibold text-gray-900 hover:text-primary">
                                            {{ $tenant->tenant_email }}
                                        </a>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-xs text-gray-600">Total Contratos</p>
                                    <p class="font-semibold text-primary text-xl">{{ $contracts->count() }}</p>
                                </div>
                            </div>
                            @if($tenant->tenant_address)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <p class="text-xs text-gray-600">Dirección</p>
                                    <p class="text-gray-900">{{ $tenant->tenant_address }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Línea de Tiempo de Contratos -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Historial de Contratos ({{ $contracts->count() }})</h3>
            </div>
            <div class="card-body">
                @forelse($contracts as $contract)
                    <div class="flex gap-4 pb-6 {{ !$loop->last ? 'border-b border-gray-200 mb-6' : '' }}">
                        <!-- Indicador de Estado -->
                        <div class="flex flex-col items-center">
                            <div class="size-12 rounded-full bg-{{ $contract->status === 'active' ? 'success' : ($contract->status === 'expired' ? 'danger' : 'gray') }}-light flex items-center justify-center">
                                @if($contract->status === 'active')
                                    <i class="ki-filled ki-check-circle text-success text-xl"></i>
                                @elseif($contract->status === 'expired')
                                    <i class="ki-filled ki-cross-circle text-danger text-xl"></i>
                                @elseif($contract->status === 'renewed')
                                    <i class="ki-filled ki-arrow-circle-right text-info text-xl"></i>
                                @else
                                    <i class="ki-filled ki-minus-circle text-gray-500 text-xl"></i>
                                @endif
                            </div>
                            @if(!$loop->last)
                                <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                            @endif
                        </div>

                        <!-- Contenido del Contrato -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-bold text-gray-900">Contrato #{{ $contract->id }}</h4>
                                        <span class="badge badge-{{ $contract->contract_type === 'rent' ? 'primary' : 'warning' }}">
                                            {{ $contract->getContractTypeLabel() }}
                                        </span>
                                        <span class="badge badge-{{ $contract->getStatusBadgeClass() }}">
                                            {{ $contract->getStatusLabel() }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        {{ $contract->start_date->format('d/m/Y') }} - {{ $contract->end_date->format('d/m/Y') }}
                                        ({{ $contract->duration_months }} meses)
                                    </p>
                                </div>
                                <p class="text-xl font-bold text-primary">{{ $contract->getFormattedAmount() }}</p>
                            </div>

                            <!-- Información de la Propiedad -->
                            @if($contract->property)
                                <div class="flex gap-3 p-3 bg-gray-50 rounded-lg mb-3">
                                    @if($contract->property->thumbnail)
                                        <img src="{{ asset('storage/' . $contract->property->thumbnail) }}" class="size-16 rounded-lg object-cover">
                                    @else
                                        <div class="size-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <i class="ki-filled ki-home text-2xl text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('backend.properties.edit', $contract->property) }}" class="font-semibold text-gray-900 hover:text-primary">
                                            {{ $contract->property->name }}
                                        </a>
                                        <p class="text-sm text-gray-600">{{ $contract->property->citys->name ?? '' }}</p>
                                        <p class="text-xs text-gray-500">{{ $contract->property->propertyType->type_name ?? '' }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($contract->notes)
                                <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">
                                    <p class="font-semibold text-gray-900 mb-1">Notas:</p>
                                    <p class="whitespace-pre-line">{{ Str::limit($contract->notes, 200) }}</p>
                                </div>
                            @endif

                            <!-- Acciones -->
                            <div class="flex gap-2 mt-3">
                                <a href="{{ route('backend.tenants.show', $contract) }}" class="btn btn-sm btn-light">
                                    <i class="ki-filled ki-eye"></i>
                                    Ver Detalles
                                </a>
                                @if($contract->property)
                                    <a href="{{ route('backend.properties.edit', $contract->property) }}" class="btn btn-sm btn-light">
                                        <i class="ki-filled ki-home"></i>
                                        Ver Propiedad
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="ki-filled ki-document text-6xl text-gray-300"></i>
                        <p class="text-gray-500 mt-2">No se encontraron contratos para este inquilino</p>
                    </div>
                @endforelse
            </div>

            <div class="card-footer">
                <a href="{{ route('backend.tenants.list') }}" class="btn btn-light">
                    <i class="ki-filled ki-left"></i>
                    Volver a Inquilinos
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
