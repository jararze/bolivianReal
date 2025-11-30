<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Gestión de Inquilinos</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('backend.tenants.list') }}" class="btn btn-light">
                <i class="ki-filled ki-people"></i>
                Ver Inquilinos Únicos
            </a>
            <a href="{{ route('backend.tenants.export', 'csv') }}" class="btn btn-success">
                <i class="ki-filled ki-file-down"></i>
                Exportar CSV
            </a>
        </div>
    </x-slot>

    <div class="container-fixed">
        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-7.5">
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-lg bg-primary-light flex items-center justify-center">
                            <i class="ki-filled ki-document text-2xl text-primary"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Contratos</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-lg bg-success-light flex items-center justify-center">
                            <i class="ki-filled ki-check-circle text-2xl text-success"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Activos</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['active'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-lg bg-danger-light flex items-center justify-center">
                            <i class="ki-filled ki-cross-circle text-2xl text-danger"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Expirados</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['expired'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-lg bg-gray-light flex items-center justify-center">
                            <i class="ki-filled ki-minus-circle text-2xl text-gray-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Terminados</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['terminated'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card mb-5">
            <div class="card-body">
                <form method="GET" action="{{ route('backend.tenants.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="md:col-span-2">
                            <input type="text" name="search" class="input w-full"
                                   placeholder="Buscar por nombre, CI, teléfono o email..."
                                   value="{{ request('search') }}">
                        </div>
                        <div>
                            <select name="status" class="select w-full">
                                <option value="">Todos los Estados</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expirados</option>
                                <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Terminados</option>
                                <option value="renewed" {{ request('status') === 'renewed' ? 'selected' : '' }}>Renovados</option>
                            </select>
                        </div>
                        <div>
                            <select name="contract_type" class="select w-full">
                                <option value="">Todos los Tipos</option>
                                <option value="rent" {{ request('contract_type') === 'rent' ? 'selected' : '' }}>Alquiler</option>
                                <option value="anticretico" {{ request('contract_type') === 'anticretico' ? 'selected' : '' }}>Anticrético</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="btn btn-primary flex-1">
                                <i class="ki-filled ki-filter"></i>
                                Filtrar
                            </button>
                            <a href="{{ route('backend.tenants.index') }}" class="btn btn-light">
                                <i class="ki-filled ki-cross"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Contratos -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Contratos con Inquilinos</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-rounded">
                        <thead>
                        <tr>
                            <th>Inquilino</th>
                            <th>Contacto</th>
                            <th>Propiedad</th>
                            <th>Tipo</th>
                            <th>Vigencia</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($contracts as $contract)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="size-10 rounded-full bg-primary-light flex items-center justify-center">
                                            <i class="ki-filled ki-profile-user text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $contract->tenant_name }}</p>
                                            @if($contract->tenant_ci)
                                                <p class="text-xs text-gray-600">CI: {{ $contract->tenant_ci }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col gap-1">
                                        @if($contract->tenant_phone)
                                            <a href="tel:{{ $contract->tenant_phone }}" class="text-sm text-gray-700 hover:text-primary flex items-center gap-1">
                                                <i class="ki-filled ki-phone text-xs"></i>
                                                {{ $contract->tenant_phone }}
                                            </a>
                                        @endif
                                        @if($contract->tenant_email)
                                            <a href="mailto:{{ $contract->tenant_email }}" class="text-sm text-gray-700 hover:text-primary flex items-center gap-1">
                                                <i class="ki-filled ki-sms text-xs"></i>
                                                {{ $contract->tenant_email }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($contract->property)
                                        <a href="{{ route('backend.properties.edit', $contract->property) }}" class="text-gray-900 hover:text-primary">
                                            <p class="font-semibold">{{ Str::limit($contract->property->name, 30) }}</p>
                                            <p class="text-xs text-gray-600">{{ $contract->property->citys->name ?? '' }}</p>
                                        </a>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td>
                                        <span class="badge badge-{{ $contract->contract_type === 'rent' ? 'primary' : 'warning' }}">
                                            {{ $contract->contract_type === 'rent' ? 'Alquiler' : 'Anticrético' }}
                                        </span>
                                </td>
                                <td>
                                    <div class="text-sm">
                                        <p class="text-gray-900">{{ $contract->start_date->format('d/m/Y') }}</p>
                                        <p class="text-gray-600">{{ $contract->end_date->format('d/m/Y') }}</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="font-semibold text-gray-900">{{ $contract->currency }} {{ number_format($contract->amount, 2) }}</p>
                                    @if($contract->contract_type === 'rent')
                                        <p class="text-xs text-gray-600">mensual</p>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'active' => 'success',
                                            'expired' => 'danger',
                                            'terminated' => 'gray',
                                            'renewed' => 'info'
                                        ];
                                        $statusLabels = [
                                            'active' => 'Activo',
                                            'expired' => 'Expirado',
                                            'terminated' => 'Terminado',
                                            'renewed' => 'Renovado'
                                        ];
                                    @endphp
                                    <span class="badge badge-{{ $statusColors[$contract->status] ?? 'light' }}">
                                            {{ $statusLabels[$contract->status] ?? $contract->status }}
                                        </span>
                                </td>
                                <td>
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('backend.tenants.show', $contract) }}"
                                           class="btn btn-sm btn-light" title="Ver Detalles">
                                            <i class="ki-filled ki-eye"></i>
                                        </a>
                                        @if($contract->tenant_ci)
                                            <a href="{{ route('backend.tenants.history', ['ci' => $contract->tenant_ci]) }}"
                                               class="btn btn-sm btn-info" title="Ver Historial">
                                                <i class="ki-filled ki-time"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8">
                                    <i class="ki-filled ki-document text-6xl text-gray-300"></i>
                                    <p class="text-gray-500 mt-2">No se encontraron contratos con inquilinos</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($contracts->hasPages())
                <div class="card-footer">
                    {{ $contracts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
