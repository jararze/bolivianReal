<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Gestión de Propiedades') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.properties.index') }}">
                {{ __('Residencias') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Gestión Final</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">

            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center size-12 rounded-lg bg-success-light">
                                <i class="ki-filled ki-home-2 text-2xl text-success"></i>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-2xl font-semibold text-gray-900">
                                    {{ $stats['active'] }}
                                </span>
                                <span class="text-sm text-gray-600">Propiedades Activas</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center size-12 rounded-lg bg-danger-light">
                                <i class="ki-filled ki-minus-circle text-2xl text-danger"></i>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-2xl font-semibold text-gray-900">
                                    {{ $stats['off_market'] }}
                                </span>
                                <span class="text-sm text-gray-600">Fuera de Mercado</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center size-12 rounded-lg bg-warning-light">
                                <i class="ki-filled ki-document text-2xl text-warning"></i>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-2xl font-semibold text-gray-900">
                                    {{ $stats['with_contracts'] }}
                                </span>
                                <span class="text-sm text-gray-600">Con Contratos Activos</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center size-12 rounded-lg bg-info-light">
                                <i class="ki-filled ki-notification-on text-2xl text-info"></i>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-2xl font-semibold text-gray-900">
                                    {{ $stats['expiring_soon'] }}
                                </span>
                                <span class="text-sm text-gray-600">Por Vencer (3 meses)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de propiedades -->
            <div class="card card-grid min-w-full">
                <div class="card-header flex-wrap py-5">
                    <h3 class="card-title">
                        Propiedades para Gestión Final
                    </h3>
                    <div class="flex gap-6 items-center">
                        <div class="relative flex items-center">
                            <i class="ki-filled ki-magnifier text-md text-gray-500 absolute left-3"></i>
                            <input
                                class="input input-sm pl-8"
                                data-datatable-search="#properties_management_table"
                                placeholder="Buscar propiedad..."
                                type="text"
                            />
                        </div>
                        <div class="relative">
                            <select class="select select-sm w-48" id="statusFilter">
                                <option value="">Todos los estados</option>
                                <option value="active">Activas</option>
                                <option value="off_market">Fuera de Mercado</option>
                                <option value="with_contract">Con Contrato</option>
                                <option value="expiring">Por Vencer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div data-datatable="true" data-datatable-page-size="10" id="properties_management_table">
                        <div class="scrollable-x-auto">
                            <table class="table table-auto table-border" data-datatable-table="true">
                                <thead>
                                <tr>
                                    <th class="min-w-[300px]">
                                            <span class="sort">
                                                <span class="sort-label">Propiedad</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                    </th>
                                    <th class="min-w-[140px]">
                                            <span class="sort">
                                                <span class="sort-label">Estado</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                    </th>
                                    <th class="min-w-[140px]">
                                            <span class="sort">
                                                <span class="sort-label">Motivo</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                    </th>
                                    <th class="min-w-[160px]">
                                            <span class="sort">
                                                <span class="sort-label">Contrato Activo</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                    </th>
                                    <th class="min-w-[140px]">
                                            <span class="sort">
                                                <span class="sort-label">Vencimiento</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                    </th>
                                    <th class="min-w-[140px] text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($properties as $property)
                                    @php
                                        $activeContract = $property->activeContract;
                                        $hasContract = $activeContract !== null;
                                        $isExpiring = $hasContract && $activeContract->isExpiringInMonths(3);
                                    @endphp
                                    <tr data-status="{{ $property->market_status }}"
                                        data-has-contract="{{ $hasContract ? 'yes' : 'no' }}"
                                        data-expiring="{{ $isExpiring ? 'yes' : 'no' }}">
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="flex flex-col gap-0.5">
                                                        <span class="text-sm font-semibold text-gray-900">
                                                            {{ $property->name }}
                                                        </span>
                                                    <span class="text-xs text-gray-600">
                                                            {{ $property->code }} - {{ $property->address }}
                                                        </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($property->market_status === 'active')
                                                <span class="badge badge-success badge-outline">
                                                        <i class="ki-filled ki-check-circle text-xs"></i>
                                                        Activa
                                                    </span>
                                            @else
                                                <span class="badge badge-danger badge-outline">
                                                        <i class="ki-filled ki-cross-circle text-xs"></i>
                                                        Fuera de Mercado
                                                    </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($property->off_market_reason)
                                                <span class="text-sm text-gray-700">
                                                        {{ $property->getOffMarketReasonLabel() }}
                                                    </span>
                                            @else
                                                <span class="text-sm text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($hasContract)
                                                <div class="flex flex-col gap-0.5">
                                                        <span class="text-sm text-gray-900 font-medium">
                                                            {{ $activeContract->getContractTypeLabel() }} - {{ $activeContract->duration_months }} meses
                                                        </span>
                                                    <span class="text-xs text-gray-600">
                                                            {{ $activeContract->tenant_name ?? 'Sin inquilino' }}
                                                        </span>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500">Sin contrato</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($hasContract)
                                                <div class="flex flex-col gap-0.5">
                                                        <span class="text-sm text-gray-900">
                                                            {{ $activeContract->end_date->format('d/m/Y') }}
                                                        </span>
                                                    @if($isExpiring)
                                                        <span class="badge badge-sm badge-warning badge-outline">
                                                                <i class="ki-filled ki-information-2 text-xs"></i>
                                                                {{ $activeContract->getDaysRemaining() }} días
                                                            </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="flex justify-center gap-2">
                                                @if($property->market_status === 'active')
                                                    <button
                                                        class="btn btn-sm btn-light btn-icon"
                                                        data-modal-toggle="#off_market_modal"
                                                        data-property-id="{{ $property->id }}"
                                                        data-property-name="{{ $property->name }}"
                                                        title="Sacar del mercado"
                                                    >
                                                        <i class="ki-filled ki-minus-circle"></i>
                                                    </button>
                                                @else
                                                    <button
                                                        class="btn btn-sm btn-success btn-icon"
                                                        onclick="if(confirm('¿Reactivar esta propiedad?')) { document.getElementById('reactivate-form-{{ $property->id }}').submit(); }"
                                                        title="Reactivar propiedad"
                                                    >
                                                        <i class="ki-filled ki-check-circle"></i>
                                                    </button>
                                                    <form id="reactivate-form-{{ $property->id }}"
                                                          action="{{ route('backend.properties.reactivate', $property) }}"
                                                          method="POST"
                                                          style="display: none;">
                                                        @csrf
                                                        @method('PATCH')
                                                    </form>
                                                @endif

                                                <button
                                                    class="btn btn-sm btn-light btn-icon"
                                                    data-modal-toggle="#contract_modal"
                                                    data-property-id="{{ $property->id }}"
                                                    data-property-name="{{ $property->name }}"
                                                    data-contract="{{ $hasContract ? json_encode([
                                                            'id' => $activeContract->id,
                                                            'contract_type' => $activeContract->contract_type,
                                                            'start_date' => $activeContract->start_date->format('Y-m-d'),
                                                            'end_date' => $activeContract->end_date->format('Y-m-d'),
                                                            'duration_months' => $activeContract->duration_months,
                                                            'amount' => $activeContract->amount,
                                                            'currency' => $activeContract->currency,
                                                            'tenant_name' => $activeContract->tenant_name,
                                                            'tenant_phone' => $activeContract->tenant_phone,
                                                            'tenant_email' => $activeContract->tenant_email,
                                                            'tenant_ci' => $activeContract->tenant_ci,
                                                            'tenant_address' => $activeContract->tenant_address,
                                                            'notes' => $activeContract->notes,
                                                        ]) : '{}' }}"
                                                    title="Gestionar contrato"
                                                >
                                                    <i class="ki-filled ki-document"></i>
                                                </button>
                                                <a
                                                    href="{{ route('backend.properties.edit', $property->slug) }}"
                                                    class="btn btn-sm btn-light btn-icon"
                                                    title="Editar propiedad"
                                                >
                                                    <i class="ki-filled ki-notepad-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-10">
                                            <div class="flex flex-col items-center gap-3">
                                                <img src="{{ asset('assets/media/illustrations/22.svg') }}"
                                                     alt="No data"
                                                     class="max-h-[200px]">
                                                <p class="text-gray-600">No hay propiedades para gestionar</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Sacar del Mercado -->
    <div class="modal" data-modal="true" id="off_market_modal">
        <div class="modal-content max-w-[600px]">
            <div class="modal-header">
                <h3 class="modal-title">Sacar Propiedad del Mercado</h3>
                <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>

            <form id="off_market_form" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <div class="flex flex-col gap-5">
                        <div class="alert alert-warning">
                            <div class="flex items-start gap-3">
                                <i class="ki-filled ki-information-2 text-xl"></i>
                                <div class="flex flex-col gap-1">
                                    <span class="font-semibold text-sm">Importante</span>
                                    <span class="text-xs">
                                        Esta acción sacará la propiedad del mercado y dejará de mostrarse en el sitio web.
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Propiedad</label>
                            <input
                                type="text"
                                class="input"
                                id="off_market_property_name"
                                readonly
                            >
                        </div>

                        <div>
                            <label class="form-label required">Motivo</label>
                            <select
                                name="off_market_reason"
                                class="select"
                                required
                            >
                                <option value="">Seleccionar motivo</option>
                                <option value="sold">Vendida</option>
                                <option value="rented">Alquilada</option>
                                <option value="anticretico">Anticrético</option>
                                <option value="owner_decision">Decisión del propietario</option>
                                <option value="other">Otro</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Notas adicionales</label>
                            <textarea
                                name="off_market_notes"
                                class="textarea"
                                rows="3"
                                placeholder="Detalles adicionales sobre el motivo..."
                            ></textarea>
                        </div>

                        <div>
                            <label class="form-label">Fecha</label>
                            <input
                                type="date"
                                name="off_market_date"
                                class="input"
                                value="{{ date('Y-m-d') }}"
                            >
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-modal-dismiss="true">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="ki-filled ki-minus-circle"></i>
                        Sacar del Mercado
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Gestión de Contrato -->
    <div class="modal" data-modal="true" id="contract_modal">
        <div class="modal-content max-w-[700px]">
            <div class="modal-header">
                <h3 class="modal-title" id="contract_modal_title">Nuevo Contrato</h3>
                <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>

            <form id="contract_form" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="contract_id" id="contract_id">

                <div class="modal-body">
                    <div class="flex flex-col gap-5">
                        <div>
                            <label class="form-label">Propiedad</label>
                            <input
                                type="text"
                                class="input"
                                id="contract_property_name"
                                readonly
                            >
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label required">Tipo de Contrato</label>
                                <select
                                    name="contract_type"
                                    class="select"
                                    id="contract_type"
                                    required
                                >
                                    <option value="">Seleccionar...</option>
                                    <option value="rent">Alquiler</option>
                                    <option value="anticretico">Anticrético</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label required">Moneda</label>
                                <select
                                    name="currency"
                                    class="select"
                                    id="currency"
                                    required
                                >
                                    <option value="Bs">Bolivianos (Bs)</option>
                                    <option value="$us">Dólares ($us)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label required">Fecha de Inicio</label>
                                <input
                                    type="date"
                                    name="start_date"
                                    class="input"
                                    id="contract_start_date"
                                    required
                                >
                            </div>
                            <div>
                                <label class="form-label required">Duración (meses)</label>
                                <input
                                    type="number"
                                    name="duration_months"
                                    class="input"
                                    id="contract_duration_months"
                                    min="1"
                                    placeholder="Ej: 12"
                                    required
                                >
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Fecha de Finalización</label>
                            <input
                                type="date"
                                name="end_date"
                                class="input"
                                id="contract_end_date"
                                readonly
                            >
                            <p class="text-xs text-gray-600 mt-1">
                                Se calcula automáticamente según la duración
                            </p>
                        </div>

                        <div>
                            <label class="form-label">Monto del Contrato</label>
                            <input
                                type="number"
                                name="amount"
                                class="input"
                                id="contract_amount"
                                step="0.01"
                                placeholder="0.00"
                            >
                            <p class="text-xs text-gray-600 mt-1">
                                Monto mensual para alquiler, monto total para anticrético
                            </p>
                        </div>

                        <div class="separator my-2"></div>

                        <h4 class="text-sm font-semibold text-gray-900">Datos del Inquilino/Arrendatario</h4>

                        <div>
                            <label class="form-label">Nombre Completo</label>
                            <input
                                type="text"
                                name="tenant_name"
                                class="input"
                                id="tenant_name"
                                placeholder="Nombre del inquilino"
                            >
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">CI/Documento</label>
                                <input
                                    type="text"
                                    name="tenant_ci"
                                    class="input"
                                    id="tenant_ci"
                                    placeholder="Carnet de identidad"
                                >
                            </div>
                            <div>
                                <label class="form-label">Teléfono</label>
                                <input
                                    type="text"
                                    name="tenant_phone"
                                    class="input"
                                    id="tenant_phone"
                                    placeholder="+591 00000000"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="tenant_email"
                                class="input"
                                id="tenant_email"
                                placeholder="email@ejemplo.com"
                            >
                        </div>

                        <div>
                            <label class="form-label">Dirección del Inquilino</label>
                            <input
                                type="text"
                                name="tenant_address"
                                class="input"
                                id="tenant_address"
                                placeholder="Dirección completa"
                            >
                        </div>

                        <div>
                            <label class="form-label">Notas del Contrato</label>
                            <textarea
                                name="notes"
                                class="textarea"
                                id="contract_notes"
                                rows="3"
                                placeholder="Detalles adicionales del contrato..."
                            ></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-between">
                    <div class="flex gap-2">
                        <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            id="delete_contract_btn"
                            style="display: none;"
                        >
                            <i class="ki-filled ki-trash"></i>
                            Eliminar
                        </button>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="btn btn-light" data-modal-dismiss="true">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ki-filled ki-check"></i>
                            Guardar Contrato
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Filtros
                const statusFilter = document.getElementById('statusFilter');
                if (statusFilter) {
                    statusFilter.addEventListener('change', function() {
                        const value = this.value;
                        const rows = document.querySelectorAll('#properties_management_table tbody tr');

                        rows.forEach(row => {
                            if (value === '') {
                                row.style.display = '';
                            } else if (value === 'active') {
                                row.style.display = row.dataset.status === 'active' ? '' : 'none';
                            } else if (value === 'off_market') {
                                row.style.display = row.dataset.status === 'off_market' ? '' : 'none';
                            } else if (value === 'with_contract') {
                                row.style.display = row.dataset.hasContract === 'yes' ? '' : 'none';
                            } else if (value === 'expiring') {
                                row.style.display = row.dataset.expiring === 'yes' ? '' : 'none';
                            }
                        });
                    });
                }

                // Modal Sacar del Mercado
                document.querySelectorAll('[data-modal-toggle="#off_market_modal"]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const propertyId = this.dataset.propertyId;
                        const propertyName = this.dataset.propertyName;

                        document.getElementById('off_market_property_name').value = propertyName;
                        document.getElementById('off_market_form').action = `/properties/${propertyId}/off-market`;
                    });
                });

                // Modal Gestión de Contrato
                document.querySelectorAll('[data-modal-toggle="#contract_modal"]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const propertyId = this.dataset.propertyId;
                        const propertyName = this.dataset.propertyName;
                        const contract = JSON.parse(this.dataset.contract || '{}');

                        document.getElementById('contract_property_name').value = propertyName;
                        document.getElementById('contract_form').action = `/properties/${propertyId}/contract`;

                        // Determinar si es nuevo o edición
                        const isEdit = contract.id !== undefined;
                        document.getElementById('contract_modal_title').textContent = isEdit ? 'Editar Contrato' : 'Nuevo Contrato';

                        // Llenar datos del contrato si existe
                        if (isEdit) {
                            document.getElementById('contract_id').value = contract.id;
                            document.getElementById('contract_type').value = contract.contract_type || '';
                            document.getElementById('currency').value = contract.currency || 'Bs';
                            document.getElementById('contract_start_date').value = contract.start_date || '';
                            document.getElementById('contract_duration_months').value = contract.duration_months || '';
                            document.getElementById('contract_end_date').value = contract.end_date || '';
                            document.getElementById('contract_amount').value = contract.amount || '';
                            document.getElementById('tenant_name').value = contract.tenant_name || '';
                            document.getElementById('tenant_ci').value = contract.tenant_ci || '';
                            document.getElementById('tenant_phone').value = contract.tenant_phone || '';
                            document.getElementById('tenant_email').value = contract.tenant_email || '';
                            document.getElementById('tenant_address').value = contract.tenant_address || '';
                            document.getElementById('contract_notes').value = contract.notes || '';
                            document.getElementById('delete_contract_btn').style.display = 'block';
                        } else {
                            // Limpiar formulario
                            document.getElementById('contract_form').reset();
                            document.getElementById('contract_id').value = '';
                            document.getElementById('contract_property_name').value = propertyName;
                            document.getElementById('currency').value = 'Bs';
                            document.getElementById('delete_contract_btn').style.display = 'none';
                        }
                    });
                });

                // Calcular fecha de fin automáticamente
                const startDateInput = document.getElementById('contract_start_date');
                const durationInput = document.getElementById('contract_duration_months');
                const endDateInput = document.getElementById('contract_end_date');

                function calculateEndDate() {
                    if (startDateInput.value && durationInput.value) {
                        const startDate = new Date(startDateInput.value);
                        const months = parseInt(durationInput.value);
                        const endDate = new Date(startDate);
                        endDate.setMonth(endDate.getMonth() + months);
                        endDateInput.value = endDate.toISOString().split('T')[0];
                    }
                }

                if (startDateInput && durationInput) {
                    startDateInput.addEventListener('change', calculateEndDate);
                    durationInput.addEventListener('input', calculateEndDate);
                }

                // Eliminar contrato
                document.getElementById('delete_contract_btn')?.addEventListener('click', function() {
                    if (confirm('¿Está seguro de eliminar este contrato? Esta acción no se puede deshacer.')) {
                        const contractId = document.getElementById('contract_id').value;
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/properties/contract/${contractId}`;

                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        form.innerHTML = `
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
