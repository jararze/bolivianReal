<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Inquilinos Únicos</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('backend.tenants.index') }}" class="btn btn-light">
                <i class="ki-filled ki-document"></i>
                Ver Todos los Contratos
            </a>
            <a href="{{ route('backend.tenants.export', 'csv') }}" class="btn btn-success">
                <i class="ki-filled ki-file-down"></i>
                Exportar CSV
            </a>
        </div>
    </x-slot>

    <div class="container-fixed">
        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-7.5">
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-lg bg-primary-light flex items-center justify-center">
                            <i class="ki-filled ki-people text-2xl text-primary"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Inquilinos Únicos</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['unique_tenants'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-lg bg-info-light flex items-center justify-center">
                            <i class="ki-filled ki-document text-2xl text-info"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Contratos</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_contracts'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Inquilinos Únicos -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Inquilinos</h3>
                <p class="text-sm text-gray-600">Inquilinos agrupados por CI/Documento</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-rounded">
                        <thead>
                        <tr>
                            <th>Inquilino</th>
                            <th>CI/Documento</th>
                            <th>Contacto</th>
                            <th>Dirección</th>
                            <th>Contratos</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tenants as $tenant)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="size-10 rounded-full bg-primary-light flex items-center justify-center">
                                            <span class="text-primary font-bold">{{ strtoupper(substr($tenant->tenant_name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $tenant->tenant_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($tenant->tenant_ci)
                                        <span class="text-gray-900">{{ $tenant->tenant_ci }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex flex-col gap-1">
                                        @if($tenant->tenant_phone)
                                            <a href="tel:{{ $tenant->tenant_phone }}" class="text-sm text-gray-700 hover:text-primary flex items-center gap-1">
                                                <i class="ki-filled ki-phone text-xs"></i>
                                                {{ $tenant->tenant_phone }}
                                            </a>
                                        @endif
                                        @if($tenant->tenant_email)
                                            <a href="mailto:{{ $tenant->tenant_email }}" class="text-sm text-gray-700 hover:text-primary flex items-center gap-1">
                                                <i class="ki-filled ki-sms text-xs"></i>
                                                {{ $tenant->tenant_email }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($tenant->tenant_address)
                                        <span class="text-sm text-gray-700">{{ Str::limit($tenant->tenant_address, 40) }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                        <span class="badge badge-info badge-lg">
                                            {{ $tenant->contracts_count }}
                                        </span>
                                </td>
                                <td>
                                    <div class="flex justify-center gap-2">
                                        @if($tenant->tenant_ci)
                                            <a href="{{ route('backend.tenants.history', ['ci' => $tenant->tenant_ci]) }}"
                                               class="btn btn-sm btn-primary" title="Ver Historial">
                                                <i class="ki-filled ki-time"></i>
                                                Historial
                                            </a>
                                        @else
                                            <a href="{{ route('backend.tenants.history', ['name' => $tenant->tenant_name]) }}"
                                               class="btn btn-sm btn-primary" title="Ver Historial">
                                                <i class="ki-filled ki-time"></i>
                                                Historial
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8">
                                    <i class="ki-filled ki-people text-6xl text-gray-300"></i>
                                    <p class="text-gray-500 mt-2">No se encontraron inquilinos</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($tenants->hasPages())
                <div class="card-footer">
                    {{ $tenants->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
