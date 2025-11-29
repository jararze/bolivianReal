<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Alertas de Vencimiento') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.contracts.index') }}">
                {{ __('Contratos') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Alertas</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">

            <!-- Resumen de alertas -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
                <div class="card border-l-4 border-l-danger">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Vencen en 1 semana</p>
                                <p class="text-2xl font-bold text-danger">{{ $expiring1Week->count() }}</p>
                            </div>
                            <i class="ki-filled ki-notification-on text-4xl text-danger"></i>
                        </div>
                    </div>
                </div>

                <div class="card border-l-4 border-l-warning">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Vencen en 1 mes</p>
                                <p class="text-2xl font-bold text-warning">{{ $expiring1Month->count() }}</p>
                            </div>
                            <i class="ki-filled ki-notification-status text-4xl text-warning"></i>
                        </div>
                    </div>
                </div>

                <div class="card border-l-4 border-l-info">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Vencen en 3 meses</p>
                                <p class="text-2xl font-bold text-info">{{ $expiring3Months->count() }}</p>
                            </div>
                            <i class="ki-filled ki-time text-4xl text-info"></i>
                        </div>
                    </div>
                </div>

                <div class="card border-l-4 border-l-gray-400">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Ya vencidos</p>
                                <p class="text-2xl font-bold text-gray-700">{{ $expired->count() }}</p>
                            </div>
                            <i class="ki-filled ki-cross-circle text-4xl text-gray-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerta: Vencen en 1 semana (URGENTE) -->
            @if($expiring1Week->count() > 0)
                <div class="card border-2 border-danger">
                    <div class="card-header bg-danger-light">
                        <h3 class="card-title text-danger">
                            <i class="ki-filled ki-notification-on"></i>
                            Contratos por Vencer en 1 Semana (URGENTE)
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="grid gap-4">
                            @foreach($expiring1Week as $contract)
                                <div class="alert alert-danger">
                                    <div class="flex items-start gap-4">
                                        <i class="ki-filled ki-information-2 text-2xl"></i>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $contract->property->name }}</p>
                                                    <p class="text-sm text-gray-700">Código: {{ $contract->property->code }}</p>
                                                </div>
                                                <span class="badge badge-lg badge-danger">
                                                    {{ $contract->getDaysRemaining() }} días
                                                </span>
                                            </div>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                                <div>
                                                    <span class="text-gray-600">Inquilino:</span>
                                                    <p class="font-medium">{{ $contract->tenant_name ?? '-' }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-600">Vence:</span>
                                                    <p class="font-medium">{{ $contract->end_date->format('d/m/Y') }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-600">Tipo:</span>
                                                    <p class="font-medium">{{ $contract->getContractTypeLabel() }}</p>
                                                </div>
                                                <div>
                                                    <a href="{{ route('backend.contracts.show', $contract) }}" class="btn btn-sm btn-danger">
                                                        Ver Detalles
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Alerta: Vencen en 1 mes -->
            @if($expiring1Month->count() > 0)
                <div class="card">
                    <div class="card-header bg-warning-light">
                        <h3 class="card-title text-warning">
                            <i class="ki-filled ki-notification-status"></i>
                            Contratos por Vencer en 1 Mes
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="scrollable-x-auto">
                            <table class="table table-auto">
                                <thead>
                                <tr>
                                    <th>Propiedad</th>
                                    <th>Inquilino</th>
                                    <th>Teléfono</th>
                                    <th>Vencimiento</th>
                                    <th>Días Restantes</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($expiring1Month as $contract)
                                    <tr>
                                        <td>
                                            <div class="flex flex-col gap-0.5">
                                                <span class="font-medium text-gray-900">{{ $contract->property->name }}</span>
                                                <span class="text-xs text-gray-600">{{ $contract->property->code }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $contract->tenant_name ?? '-' }}</td>
                                        <td>{{ $contract->tenant_phone ?? '-' }}</td>
                                        <td>{{ $contract->end_date->format('d/m/Y') }}</td>
                                        <td>
                                                <span class="badge badge-warning">
                                                    {{ $contract->getDaysRemaining() }} días
                                                </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('backend.contracts.show', $contract) }}" class="btn btn-sm btn-light">
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Alerta: Vencen en 3 meses -->
            @if($expiring3Months->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-info">
                            <i class="ki-filled ki-time"></i>
                            Contratos por Vencer en 3 Meses
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="scrollable-x-auto">
                            <table class="table table-auto">
                                <thead>
                                <tr>
                                    <th>Propiedad</th>
                                    <th>Inquilino</th>
                                    <th>Tipo</th>
                                    <th>Vencimiento</th>
                                    <th>Meses Restantes</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($expiring3Months as $contract)
                                    <tr>
                                        <td>
                                            <div class="flex flex-col gap-0.5">
                                                <span class="font-medium text-gray-900">{{ $contract->property->name }}</span>
                                                <span class="text-xs text-gray-600">{{ $contract->property->code }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $contract->tenant_name ?? '-' }}</td>
                                        <td>
                                                <span class="badge badge-sm {{ $contract->contract_type === 'rent' ? 'badge-info' : 'badge-primary' }} badge-outline">
                                                    {{ $contract->getContractTypeLabel() }}
                                                </span>
                                        </td>
                                        <td>{{ $contract->end_date->format('d/m/Y') }}</td>
                                        <td>
                                                <span class="badge badge-info">
                                                    {{ $contract->getMonthsRemaining() }} meses
                                                </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('backend.contracts.show', $contract) }}" class="btn btn-sm btn-light">
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contratos Vencidos -->
            @if($expired->count() > 0)
                <div class="card">
                    <div class="card-header bg-gray-100">
                        <h3 class="card-title text-gray-700">
                            <i class="ki-filled ki-cross-circle"></i>
                            Contratos Vencidos (Últimos 10)
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="scrollable-x-auto">
                            <table class="table table-auto">
                                <thead>
                                <tr>
                                    <th>Propiedad</th>
                                    <th>Inquilino</th>
                                    <th>Venció el</th>
                                    <th>Días Vencidos</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($expired as $contract)
                                    <tr>
                                        <td>{{ $contract->property->name }}</td>
                                        <td>{{ $contract->tenant_name ?? '-' }}</td>
                                        <td>{{ $contract->end_date->format('d/m/Y') }}</td>
                                        <td>
                                                <span class="badge badge-gray">
                                                    {{ abs($contract->getDaysRemaining()) }} días
                                                </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('backend.contracts.show', $contract) }}" class="btn btn-sm btn-light">
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Si no hay alertas -->
            @if($expiring1Week->count() == 0 && $expiring1Month->count() == 0 && $expiring3Months->count() == 0 && $expired->count() == 0)
                <div class="card">
                    <div class="card-body text-center py-10">
                        <i class="ki-filled ki-shield-tick text-6xl text-success mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">¡Todo en orden!</h3>
                        <p class="text-gray-600">No hay contratos próximos a vencer que requieran atención.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
