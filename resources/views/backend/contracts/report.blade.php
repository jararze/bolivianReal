<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ $title }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.contracts.index') }}">
                {{ __('Contratos') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">{{ $title }}</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">

            <!-- Header con acciones -->
            <div class="card">
                <div class="card-body flex flex-wrap justify-between items-center gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
                        <p class="text-sm text-gray-600 mt-1">{{ $contracts->total() }} contratos encontrados</p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('backend.contracts.index') }}" class="btn btn-sm btn-light">
                            <i class="ki-filled ki-left"></i>
                            Volver
                        </a>

                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:hover">
                                <button class="btn btn-sm btn-primary menu-toggle">
                                    <i class="ki-filled ki-exit-down"></i>
                                    Exportar Reporte
                                    <span class="menu-arrow">
                                        <i class="ki-filled ki-down text-2xs"></i>
                                    </span>
                                </button>
                                <div class="menu-dropdown menu-default w-48">
                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route('backend.contracts.export', ['format' => 'excel', 'type' => $type]) }}">
                                            <span class="menu-icon">
                                                <i class="ki-filled ki-file-down text-success"></i>
                                            </span>
                                            <span class="menu-title">Excel (.xlsx)</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route('backend.contracts.export', ['format' => 'pdf', 'type' => $type]) }}">
                                            <span class="menu-icon">
                                                <i class="ki-filled ki-file-down text-danger"></i>
                                            </span>
                                            <span class="menu-title">PDF</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route('backend.contracts.export', ['format' => 'csv', 'type' => $type]) }}">
                                            <span class="menu-icon">
                                                <i class="ki-filled ki-file-down text-info"></i>
                                            </span>
                                            <span class="menu-title">CSV</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de contratos -->
            <div class="card">
                <div class="card-body">
                    <div class="scrollable-x-auto">
                        <table class="table table-auto table-border">
                            <thead>
                            <tr>
                                <th class="min-w-[250px]">Propiedad</th>
                                <th class="min-w-[120px]">Tipo</th>
                                <th class="min-w-[180px]">Inquilino</th>
                                <th class="min-w-[100px]">Inicio</th>
                                <th class="min-w-[100px]">Vencimiento</th>
                                <th class="min-w-[100px]">Monto</th>
                                <th class="min-w-[100px]">Estado</th>
                                <th class="min-w-[80px] text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($contracts as $contract)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            @if($contract->property->thumbnail)
                                                <img
                                                    src="{{ asset('storage/' . $contract->property->thumbnail) }}"
                                                    class="rounded size-10 shrink-0 object-cover"
                                                    alt="{{ $contract->property->name }}"
                                                >
                                            @endif
                                            <div class="flex flex-col gap-0.5">
                                                <a href="{{ route('backend.properties.edit', $contract->property) }}"
                                                   class="text-sm font-semibold text-gray-900 hover:text-primary">
                                                    {{ $contract->property->name }}
                                                </a>
                                                <span class="text-xs text-gray-600">
                                                        {{ $contract->property->code }}
                                                    </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                            <span class="badge {{ $contract->contract_type === 'rent' ? 'badge-info' : 'badge-primary' }} badge-outline">
                                                {{ $contract->getContractTypeLabel() }}
                                            </span>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-0.5">
                                            <span class="text-sm text-gray-900 font-medium">{{ $contract->tenant_name ?? '-' }}</span>
                                            @if($contract->tenant_phone)
                                                <span class="text-xs text-gray-600">
                                                        <i class="ki-filled ki-phone text-xs"></i>
                                                        {{ $contract->tenant_phone }}
                                                    </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                            <span class="text-sm text-gray-700">
                                                {{ $contract->start_date->format('d/m/Y') }}
                                            </span>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-1">
                                                <span class="text-sm text-gray-900 font-medium">
                                                    {{ $contract->end_date->format('d/m/Y') }}
                                                </span>
                                            @if($contract->isExpiringInMonths(3) && $contract->status === 'active')
                                                @php
                                                    $daysRemaining = $contract->getDaysRemaining();
                                                    $badgeClass = $daysRemaining <= 7 ? 'badge-danger' : ($daysRemaining <= 30 ? 'badge-warning' : 'badge-info');
                                                @endphp
                                                <span class="badge badge-sm {{ $badgeClass }} badge-outline">
                                                        <i class="ki-filled ki-time text-xs"></i>
                                                        {{ $daysRemaining }} días
                                                    </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                            <span class="text-sm font-semibold text-gray-900">
                                                {{ $contract->getFormattedAmount() }}
                                            </span>
                                    </td>
                                    <td>
                                            <span class="badge {{ $contract->getStatusBadgeClass() }} badge-outline">
                                                {{ $contract->getStatusLabel() }}
                                            </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('backend.contracts.show', $contract) }}"
                                           class="btn btn-sm btn-light btn-icon"
                                           title="Ver detalles">
                                            <i class="ki-filled ki-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-10">
                                        <div class="flex flex-col items-center gap-3">
                                            <i class="ki-filled ki-information-2 text-6xl text-gray-300"></i>
                                            <p class="text-gray-600">No hay contratos en esta categoría</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($contracts->hasPages())
                        <div class="mt-5">
                            {{ $contracts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
