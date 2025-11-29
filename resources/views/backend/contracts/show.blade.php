<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Detalles del Contrato') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.contracts.index') }}">
                {{ __('Contratos') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Contrato #{{ $contract->id }}</span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">

            <!-- Acciones rápidas -->
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <a href="{{ route('backend.contracts.index') }}" class="btn btn-sm btn-light">
                        <i class="ki-filled ki-left"></i>
                        Volver
                    </a>
                    <a href="{{ route('backend.properties.lastPhase.index') }}" class="btn btn-sm btn-light">
                        <i class="ki-filled ki-home"></i>
                        Ver Propiedad
                    </a>
                </div>

                <div class="flex gap-2">
                    @if($contract->status === 'active')
                        <button
                            class="btn btn-sm btn-warning"
                            data-modal-toggle="#renew_contract_modal"
                        >
                            <i class="ki-filled ki-arrows-circle"></i>
                            Renovar Contrato
                        </button>
                        <button
                            class="btn btn-sm btn-danger"
                            data-modal-toggle="#terminate_contract_modal"
                        >
                            <i class="ki-filled ki-cross-circle"></i>
                            Terminar Contrato
                        </button>
                    @endif
                </div>
            </div>

            <!-- Grid de información -->
            <div class="grid lg:grid-cols-3 gap-5">

                <!-- Columna principal (2/3) -->
                <div class="lg:col-span-2 grid gap-5">

                    <!-- Información de la Propiedad -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ki-filled ki-home text-primary"></i>
                                Propiedad
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="flex gap-5">
                                @if($contract->property->thumbnail)
                                    <img
                                        src="{{ asset('storage/' . $contract->property->thumbnail) }}"
                                        class="rounded-lg w-32 h-32 object-cover shrink-0"
                                        alt="{{ $contract->property->name }}"
                                    >
                                @endif

                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                        {{ $contract->property->name }}
                                    </h4>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Código:</span>
                                            <p class="font-medium">{{ $contract->property->code }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Tipo:</span>
                                            <p class="font-medium">{{ $contract->property->propertyType->type_name }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Dirección:</span>
                                            <p class="font-medium">{{ $contract->property->address }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Ciudad:</span>
                                            <p class="font-medium">{{ $contract->property->citys->name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Inquilino -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ki-filled ki-profile-user text-info"></i>
                                Datos del Inquilino/Arrendatario
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="text-sm text-gray-600">Nombre Completo</label>
                                    <p class="text-base font-semibold text-gray-900">{{ $contract->tenant_name ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">CI/Documento</label>
                                    <p class="text-base font-semibold text-gray-900">{{ $contract->tenant_ci ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Teléfono</label>
                                    <p class="text-base font-semibold text-gray-900">
                                        @if($contract->tenant_phone)
                                            <a href="tel:{{ $contract->tenant_phone }}" class="text-primary hover:underline">
                                                {{ $contract->tenant_phone }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Email</label>
                                    <p class="text-base font-semibold text-gray-900">
                                        @if($contract->tenant_email)
                                            <a href="mailto:{{ $contract->tenant_email }}" class="text-primary hover:underline">
                                                {{ $contract->tenant_email }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                                @if($contract->tenant_address)
                                    <div class="md:col-span-2">
                                        <label class="text-sm text-gray-600">Dirección</label>
                                        <p class="text-base font-semibold text-gray-900">{{ $contract->tenant_address }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Notas del Contrato -->
                    @if($contract->notes)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ki-filled ki-note-2"></i>
                                    Notas del Contrato
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-gray-700">{{ $contract->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Historial de Renovaciones -->
                    @if($contract->renewedFrom || $contract->renewedTo)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ki-filled ki-arrows-circle"></i>
                                    Historial de Renovaciones
                                </h3>
                            </div>
                            <div class="card-body">
                                @if($contract->renewedFrom)
                                    <div class="alert alert-info mb-3">
                                        <i class="ki-filled ki-information-2"></i>
                                        Este contrato es una renovación del contrato
                                        <a href="{{ route('backend.contracts.show', $contract->renewedFrom) }}" class="font-semibold underline">
                                            #{{ $contract->renewedFrom->id }}
                                        </a>
                                    </div>
                                @endif

                                @if($contract->renewedTo)
                                    <div class="alert alert-success">
                                        <i class="ki-filled ki-check-circle"></i>
                                        Este contrato fue renovado como contrato
                                        <a href="{{ route('backend.contracts.show', $contract->renewedTo) }}" class="font-semibold underline">
                                            #{{ $contract->renewedTo->id }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Columna lateral (1/3) -->
                <div class="grid gap-5 h-fit">

                    <!-- Estado y Fechas -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Estado del Contrato</h3>
                        </div>
                        <div class="card-body space-y-4">
                            <div class="flex justify-center">
                                <span class="badge badge-lg {{ $contract->getStatusBadgeClass() }}">
                                    {{ $contract->getStatusLabel() }}
                                </span>
                            </div>

                            <div class="separator"></div>

                            <div>
                                <label class="text-xs text-gray-600">Tipo de Contrato</label>
                                <p class="text-base font-bold text-gray-900">{{ $contract->getContractTypeLabel() }}</p>
                            </div>

                            <div>
                                <label class="text-xs text-gray-600">Fecha de Inicio</label>
                                <p class="text-base font-bold text-gray-900">{{ $contract->start_date->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <label class="text-xs text-gray-600">Fecha de Vencimiento</label>
                                <p class="text-base font-bold text-gray-900">{{ $contract->end_date->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <label class="text-xs text-gray-600">Duración</label>
                                <p class="text-base font-bold text-gray-900">{{ $contract->duration_months }} meses</p>
                            </div>

                            @if($contract->status === 'active')
                                <div class="separator"></div>

                                @php
                                    $daysRemaining = $contract->getDaysRemaining();
                                    $isExpiring = $contract->isExpiringInMonths(3);
                                @endphp

                                @if($daysRemaining > 0)
                                    <div class="text-center">
                                        <label class="text-xs text-gray-600 block mb-1">Tiempo Restante</label>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-3xl font-bold {{ $isExpiring ? 'text-warning' : 'text-success' }}">
                                                {{ $daysRemaining }}
                                            </p>
                                            <p class="text-sm text-gray-600">días</p>
                                        </div>

                                        @if($isExpiring)
                                            <div class="mt-3">
                                                <span class="badge badge-warning">
                                                    <i class="ki-filled ki-information-2"></i>
                                                    Por vencer pronto
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="alert alert-danger text-center">
                                        <i class="ki-filled ki-information-2 text-xl"></i>
                                        <p class="font-bold">Contrato Vencido</p>
                                        <p class="text-sm">Hace {{ abs($daysRemaining) }} días</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Información Financiera -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Información Financiera</h3>
                        </div>
                        <div class="card-body space-y-4">
                            <div>
                                <label class="text-xs text-gray-600">Monto del Contrato</label>
                                <p class="text-2xl font-bold text-primary">{{ $contract->getFormattedAmount() }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $contract->contract_type === 'rent' ? 'Pago mensual' : 'Monto total' }}
                                </p>
                            </div>

                            @if($contract->amount)
                                <div class="separator"></div>

                                <div>
                                    <label class="text-xs text-gray-600">Total del Contrato</label>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $contract->currency }} {{ number_format($contract->amount * ($contract->contract_type === 'rent' ? $contract->duration_months : 1), 2) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Alertas -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Alertas Enviadas</h3>
                        </div>
                        <div class="card-body space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">3 meses antes</span>
                                @if($contract->alert_3months_sent)
                                    <span class="badge badge-sm badge-success">
                                        <i class="ki-filled ki-check"></i>
                                        {{ $contract->alert_3months_sent_at->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="badge badge-sm badge-gray">Pendiente</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">1 mes antes</span>
                                @if($contract->alert_1month_sent)
                                    <span class="badge badge-sm badge-success">
                                        <i class="ki-filled ki-check"></i>
                                        {{ $contract->alert_1month_sent_at->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="badge badge-sm badge-gray">Pendiente</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">1 semana antes</span>
                                @if($contract->alert_1week_sent)
                                    <span class="badge badge-sm badge-success">
                                        <i class="ki-filled ki-check"></i>
                                        {{ $contract->alert_1week_sent_at->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="badge badge-sm badge-gray">Pendiente</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Auditoría -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Información de Auditoría</h3>
                        </div>
                        <div class="card-body space-y-3 text-sm">
                            <div>
                                <span class="text-gray-600">Creado por:</span>
                                <p class="font-medium">{{ $contract->createdBy->name ?? 'Sistema' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Fecha de creación:</span>
                                <p class="font-medium">{{ $contract->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            @if($contract->updatedBy)
                                <div>
                                    <span class="text-gray-600">Última actualización:</span>
                                    <p class="font-medium">{{ $contract->updatedBy->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $contract->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" data-modal="true" id="renew_contract_modal">
        <div class="modal-content max-w-[600px]">
            <div class="modal-header">
                <h3 class="modal-title">Renovar Contrato</h3>
                <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>

            <form action="{{ route('backend.properties.renewContract', $contract) }}" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="flex flex-col gap-5">
                        <div class="alert alert-info">
                            <div class="flex items-start gap-3">
                                <i class="ki-filled ki-information-2 text-xl"></i>
                                <div class="flex flex-col gap-1">
                                    <span class="font-semibold text-sm">Renovación de Contrato</span>
                                    <span class="text-xs">
                                        Se creará un nuevo contrato manteniendo los datos del inquilino.
                                        El contrato actual se marcará como "Renovado".
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-sm text-gray-900 mb-3">Contrato Actual</h4>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-gray-600">Fecha de Vencimiento:</span>
                                    <p class="font-medium">{{ $contract->end_date->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Duración:</span>
                                    <p class="font-medium">{{ $contract->duration_months }} meses</p>
                                </div>
                            </div>
                        </div>

                        <div class="separator"></div>

                        <h4 class="font-semibold text-sm text-gray-900">Datos del Nuevo Contrato</h4>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label required">Fecha de Inicio</label>
                                <input
                                    type="date"
                                    name="start_date"
                                    class="input"
                                    value="{{ $contract->end_date->copy()->addDay()->format('Y-m-d') }}"
                                    required
                                >
                                <p class="text-xs text-gray-600 mt-1">
                                    Se sugiere: {{ $contract->end_date->copy()->addDay()->format('d/m/Y') }}
                                </p>
                            </div>

                            <div>
                                <label class="form-label required">Duración (meses)</label>
                                <input
                                    type="number"
                                    name="duration_months"
                                    class="input"
                                    value="{{ $contract->duration_months }}"
                                    min="1"
                                    max="120"
                                    required
                                >
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Monto del Contrato</label>
                            <div class="relative">
                                <span class="absolute top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium" style="left: 100px">
                                    {{ $contract->currency }}
                                </span>
                                <input
                                    type="number"
                                    name="amount"
                                    class="input pl-14"
                                    value="{{ $contract->amount }}"
                                    step="0.01"
                                    placeholder="0.00"
                                >
                            </div>
                            <p class="text-xs text-gray-600 mt-1">
                                Monto actual: {{ $contract->getFormattedAmount() }}
                            </p>
                        </div>

                        <div>
                            <label class="form-label">Notas de Renovación</label>
                            <textarea
                                name="notes"
                                class="textarea"
                                rows="3"
                                placeholder="Cambios o condiciones del nuevo contrato..."
                            ></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-modal-dismiss="true">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ki-filled ki-arrows-circle"></i>
                        Renovar Contrato
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Terminar Contrato -->
    <div class="modal" data-modal="true" id="terminate_contract_modal">
        <div class="modal-content max-w-[600px]">
            <div class="modal-header">
                <h3 class="modal-title">Terminar Contrato Anticipadamente</h3>
                <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>

            <form action="{{ route('backend.properties.terminateContract', $contract) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <div class="flex flex-col gap-5">
                        <div class="alert alert-danger">
                            <div class="flex items-start gap-3">
                                <i class="ki-filled ki-shield-cross text-xl"></i>
                                <div class="flex flex-col gap-1">
                                    <span class="font-semibold text-sm">¡Atención!</span>
                                    <span class="text-xs">
                                        Esta acción marcará el contrato como terminado antes de su fecha de vencimiento.
                                        Esta acción no se puede deshacer.
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-sm text-gray-900 mb-3">Información del Contrato</h4>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-gray-600">Propiedad:</span>
                                    <p class="font-medium">{{ $contract->property->name }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Inquilino:</span>
                                    <p class="font-medium">{{ $contract->tenant_name ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Vence:</span>
                                    <p class="font-medium">{{ $contract->end_date->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Días restantes:</span>
                                    <p class="font-medium text-warning">{{ $contract->getDaysRemaining() }} días</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label required">Motivo de Terminación</label>
                            <select name="termination_reason_select" id="termination_reason_select" class="select" required>
                                <option value="">Seleccionar motivo...</option>
                                <option value="Incumplimiento de contrato">Incumplimiento de contrato</option>
                                <option value="Falta de pago">Falta de pago</option>
                                <option value="Solicitud del inquilino">Solicitud del inquilino</option>
                                <option value="Venta de la propiedad">Venta de la propiedad</option>
                                <option value="Necesidades del propietario">Necesidades del propietario</option>
                                <option value="other">Otro (especificar)</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label required">Detalles / Observaciones</label>
                            <textarea
                                name="termination_reason"
                                id="termination_reason_text"
                                class="textarea"
                                rows="4"
                                placeholder="Describa los motivos y detalles de la terminación anticipada..."
                                required
                            ></textarea>
                            <p class="text-xs text-gray-600 mt-1">
                                Esta información se agregará a las notas del contrato
                            </p>
                        </div>

                        <div>
                            <label class="form-label">Fecha de Terminación</label>
                            <input
                                type="date"
                                name="termination_date"
                                class="input"
                                value="{{ date('Y-m-d') }}"
                                max="{{ date('Y-m-d') }}"
                            >
                        </div>

                        <div class="form-check">
                            <input
                                type="checkbox"
                                class="checkbox"
                                id="confirm_termination"
                                required
                            >
                            <label for="confirm_termination" class="form-label">
                                Confirmo que deseo terminar este contrato anticipadamente
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-modal-dismiss="true">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="ki-filled ki-cross-circle"></i>
                        Terminar Contrato
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-completar el motivo de terminación
                const select = document.getElementById('termination_reason_select');
                const textarea = document.getElementById('termination_reason_text');

                if (select && textarea) {
                    select.addEventListener('change', function() {
                        if (this.value && this.value !== 'other') {
                            textarea.value = this.value + '\n\n';
                            textarea.focus();
                        } else if (this.value === 'other') {
                            textarea.value = '';
                            textarea.focus();
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
