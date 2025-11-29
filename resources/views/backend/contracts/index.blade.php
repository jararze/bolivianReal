<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Gestión de Contratos') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.properties.index') }}">
                {{ __('Residencias') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Contratos</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">

            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 lg:grid-cols-6 gap-5">
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <i class="ki-filled ki-file-sheet text-3xl text-gray-500"></i>
                                <span class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</span>
                            </div>
                            <span class="text-sm text-gray-600">Total Contratos</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <i class="ki-filled ki-check-circle text-3xl text-success"></i>
                                <span class="text-2xl font-bold text-success">{{ $stats['active'] }}</span>
                            </div>
                            <span class="text-sm text-gray-600">Activos</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <i class="ki-filled ki-information-2 text-3xl text-warning"></i>
                                <span class="text-2xl font-bold text-warning">{{ $stats['expiring_soon'] }}</span>
                            </div>
                            <span class="text-sm text-gray-600">Por Vencer</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <i class="ki-filled ki-cross-circle text-3xl text-danger"></i>
                                <span class="text-2xl font-bold text-danger">{{ $stats['expired'] }}</span>
                            </div>
                            <span class="text-sm text-gray-600">Vencidos</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <i class="ki-filled ki-home text-3xl text-info"></i>
                                <span class="text-2xl font-bold text-info">{{ $stats['rent'] }}</span>
                            </div>
                            <span class="text-sm text-gray-600">Alquileres</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <i class="ki-filled ki-home-2 text-3xl text-primary"></i>
                                <span class="text-2xl font-bold text-primary">{{ $stats['anticretico'] }}</span>
                            </div>
                            <span class="text-sm text-gray-600">Anticréticos</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros y tabla -->
            <div class="card card-grid min-w-full">
                <div class="card-header py-5">
                    <h3 class="card-title">
                        Todos los Contratos
                    </h3>

                    <div class="flex flex-col gap-4 w-full mt-4">
                        <!-- Formulario de búsqueda y filtros -->
                        <form method="GET" class="flex flex-wrap gap-3 items-end">
                            <!-- Búsqueda -->
                            <div class="flex-1 min-w-[200px]">
                                <label class="form-label text-xs mb-1">Buscar</label>
                                <div class="relative">
                                    <i class="ki-filled ki-magnifier text-md text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                                    <input
                                        class="input input-sm pl-8 w-full"
                                        name="search"
                                        placeholder="Inquilino, propiedad..."
                                        type="text"
                                        value="{{ request('search') }}"
                                    />
                                </div>
                            </div>

                            <!-- Filtro Estado -->
                            <div class="w-40">
                                <label class="form-label text-xs mb-1">Estado</label>
                                <select class="select select-sm w-full" name="status">
                                    <option value="">Todos</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activos</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expirados</option>
                                    <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminados</option>
                                    <option value="renewed" {{ request('status') == 'renewed' ? 'selected' : '' }}>Renovados</option>
                                </select>
                            </div>

                            <!-- Filtro Tipo -->
                            <div class="w-40">
                                <label class="form-label text-xs mb-1">Tipo</label>
                                <select class="select select-sm w-full" name="contract_type">
                                    <option value="">Todos</option>
                                    <option value="rent" {{ request('contract_type') == 'rent' ? 'selected' : '' }}>Alquiler</option>
                                    <option value="anticretico" {{ request('contract_type') == 'anticretico' ? 'selected' : '' }}>Anticrético</option>
                                </select>
                            </div>

                            <!-- Botones -->
                            <div class="flex gap-2">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="ki-filled ki-filter"></i>
                                    Filtrar
                                </button>

                                @if(request()->hasAny(['search', 'status', 'contract_type']))
                                    <a href="{{ route('backend.contracts.index') }}" class="btn btn-sm btn-light">
                                        <i class="ki-filled ki-cross"></i>
                                        Limpiar
                                    </a>
                                @endif
                            </div>
                        </form>

                        <!-- Botón de exportar separado -->
                        <div class="flex justify-end">
                            <div class="menu" data-menu="true">
                                <div class="menu-item" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:hover">
                                    <button class="btn btn-sm btn-light menu-toggle">
                                        <i class="ki-filled ki-exit-down"></i>
                                        Exportar
                                        <span class="menu-arrow">
                            <i class="ki-filled ki-down text-2xs"></i>
                        </span>
                                    </button>
                                    <div class="menu-dropdown menu-default w-48">
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route('backend.contracts.export', ['format' => 'excel'] + request()->all()) }}">
                                <span class="menu-icon">
                                    <i class="ki-filled ki-file-down text-success"></i>
                                </span>
                                                <span class="menu-title">Excel (.xlsx)</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route('backend.contracts.export', ['format' => 'pdf'] + request()->all()) }}">
                                <span class="menu-icon">
                                    <i class="ki-filled ki-file-down text-danger"></i>
                                </span>
                                                <span class="menu-title">PDF</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route('backend.contracts.export', ['format' => 'csv'] + request()->all()) }}">
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

                <div class="card-body">
                    <div data-datatable="true" data-datatable-page-size="15">
                        <div class="scrollable-x-auto">
                            <table class="table table-auto table-border" data-datatable-table="true">
                                <thead>
                                <tr>
                                    <th class="min-w-[300px]">Propiedad</th>
                                    <th class="min-w-[140px]">Tipo</th>
                                    <th class="min-w-[180px]">Inquilino</th>
                                    <th class="min-w-[120px]">Inicio</th>
                                    <th class="min-w-[120px]">Vencimiento</th>
                                    <th class="min-w-[100px]">Monto</th>
                                    <th class="min-w-[100px]">Estado</th>
                                    <th class="min-w-[100px] text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($contracts as $contract)
                                    <tr>
                                        <td>
                                            <div class="flex flex-col gap-0.5">
                                                <a href="{{ route('backend.properties.edit', $contract->property) }}"
                                                   class="text-sm font-semibold text-gray-900 hover:text-primary">
                                                    {{ $contract->property->name }}
                                                </a>
                                                <span class="text-xs text-gray-600">
                                                        {{ $contract->property->code }} - {{ $contract->property->propertyType->type_name }}
                                                    </span>
                                            </div>
                                        </td>
                                        <td>
                                                <span class="badge {{ $contract->contract_type === 'rent' ? 'badge-info' : 'badge-primary' }} badge-outline">
                                                    {{ $contract->getContractTypeLabel() }}
                                                </span>
                                        </td>
                                        <td>
                                            <div class="flex flex-col gap-0.5">
                                                <span class="text-sm text-gray-900">{{ $contract->tenant_name ?? '-' }}</span>
                                                @if($contract->tenant_ci)
                                                    <span class="text-xs text-gray-600">CI: {{ $contract->tenant_ci }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                                <span class="text-sm text-gray-700">
                                                    {{ $contract->start_date->format('d/m/Y') }}
                                                </span>
                                        </td>
                                        <td>
                                            <div class="flex flex-col gap-0.5">
                                                    <span class="text-sm text-gray-900">
                                                        {{ $contract->end_date->format('d/m/Y') }}
                                                    </span>
                                                @if($contract->isExpiringInMonths(3) && $contract->status === 'active')
                                                    <span class="badge badge-sm badge-warning badge-outline">
                                                            {{ $contract->getDaysRemaining() }} días
                                                        </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ $contract->getFormattedAmount() }}
                                                </span>
                                        </td>
                                        <td>
                                                <span class="badge {{ $contract->getStatusBadgeClass() }} badge-outline">
                                                    {{ $contract->getStatusLabel() }}
                                                </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('backend.contracts.show', $contract) }}"
                                                   class="btn btn-sm btn-light btn-icon"
                                                   title="Ver detalles">
                                                    <i class="ki-filled ki-eye"></i>
                                                </a>

                                                <a href="{{ route('backend.properties.lastPhase.index') }}"
                                                   class="btn btn-sm btn-light btn-icon"
                                                   title="Ver propiedad">
                                                    <i class="ki-filled ki-home"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-10">
                                            <div class="flex flex-col items-center gap-3">
                                                <i class="ki-filled ki-file-sheet text-6xl text-gray-300"></i>
                                                <p class="text-gray-600">No hay contratos registrados</p>
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
    </div>
</x-app-layout>
