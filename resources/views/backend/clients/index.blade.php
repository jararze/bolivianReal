<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Gestión de Clientes</h1>
    </x-slot>

    <div class="container-fixed">
        <!-- Estadísticas -->
        <div class="grid lg:grid-cols-4 gap-5 mb-5">
            <div class="card border-l-4 border-l-primary">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Clientes</p>
                            <p class="text-3xl font-bold text-primary">{{ $stats['total'] }}</p>
                        </div>
                        <i class="ki-filled ki-profile-user text-5xl text-primary opacity-20"></i>
                    </div>
                </div>
            </div>

            <div class="card border-l-4 border-l-success">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Activos</p>
                            <p class="text-3xl font-bold text-success">{{ $stats['active'] }}</p>
                        </div>
                        <i class="ki-filled ki-check-circle text-5xl text-success opacity-20"></i>
                    </div>
                </div>
            </div>

            <div class="card border-l-4 border-l-danger">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Inactivos</p>
                            <p class="text-3xl font-bold text-danger">{{ $stats['inactive'] }}</p>
                        </div>
                        <i class="ki-filled ki-cross-circle text-5xl text-danger opacity-20"></i>
                    </div>
                </div>
            </div>

            <div class="card border-l-4 border-l-warning">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Con Propiedades</p>
                            <p class="text-3xl font-bold text-warning">{{ $stats['with_properties'] }}</p>
                        </div>
                        <i class="ki-filled ki-home text-5xl text-warning opacity-20"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros y Acciones -->
        <div class="card mb-5">
            <div class="card-header">
                <h3 class="card-title">Clientes</h3>
                <a href="{{ route('backend.clients.create') }}" class="btn btn-primary">
                    <i class="ki-filled ki-plus"></i>
                    Nuevo Cliente
                </a>
            </div>
            <div class="card-body">
                <!-- Formulario de filtros -->
                <form method="GET" class="grid lg:grid-cols-4 gap-4 mb-5">
                    <div>
                        <input
                            type="text"
                            name="search"
                            class="input"
                            placeholder="Buscar por nombre, CI, teléfono..."
                            value="{{ request('search') }}"
                        >
                    </div>
                    <div>
                        <select name="status" class="select">
                            <option value="">Todos los estados</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activos</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>
                    <div>
                        <select name="client_type" class="select">
                            <option value="">Todos los tipos</option>
                            <option value="owner" {{ request('client_type') === 'owner' ? 'selected' : '' }}>Propietario</option>
                            <option value="buyer" {{ request('client_type') === 'buyer' ? 'selected' : '' }}>Comprador</option>
                            <option value="tenant" {{ request('client_type') === 'tenant' ? 'selected' : '' }}>Inquilino</option>
                            <option value="both" {{ request('client_type') === 'both' ? 'selected' : '' }}>Ambos</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="{{ route('backend.clients.index') }}" class="btn btn-light">Limpiar</a>
                    </div>
                </form>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="table table-border">
                        <thead>
                        <tr>
                            <th class="min-w-[200px]">Cliente</th>
                            <th class="min-w-[150px]">Contacto</th>
                            <th class="min-w-[100px]">CI</th>
                            <th class="min-w-[120px]">Tipo</th>
                            <th class="min-w-[100px]">Propiedades</th>
                            <th class="min-w-[100px]">Estado</th>
                            <th class="min-w-[150px] text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td>
                                    <div>
                                        <p class="font-semibold text-sm">{{ $client->full_name }}</p>
                                        <p class="text-xs text-gray-600">{{ $client->city ?? 'Sin ciudad' }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($client->phone)
                                            <p class="text-sm"><i class="ki-filled ki-phone text-xs"></i> {{ $client->phone }}</p>
                                        @endif
                                        @if($client->email)
                                            <p class="text-xs text-gray-600"><i class="ki-filled ki-sms text-xs"></i> {{ $client->email }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $client->ci ?? '-' }}</td>
                                <td>
                                    @php
                                        $typeColors = [
                                            'owner' => 'primary',
                                            'buyer' => 'success',
                                            'tenant' => 'warning',
                                            'both' => 'info'
                                        ];
                                        $typeLabels = [
                                            'owner' => 'Propietario',
                                            'buyer' => 'Comprador',
                                            'tenant' => 'Inquilino',
                                            'both' => 'Ambos'
                                        ];
                                    @endphp
                                    <span class="badge badge-{{ $typeColors[$client->client_type] ?? 'light' }}">
                                            {{ $typeLabels[$client->client_type] ?? 'N/A' }}
                                        </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary">{{ $client->properties_count }}</span>
                                </td>
                                <td>
                                    <form action="{{ route('backend.clients.toggle-status', $client) }}" method="POST" class="inline">
                                        @csrf
                                        <label class="switch">
                                            <input
                                                type="checkbox"
                                                {{ $client->status ? 'checked' : '' }}
                                                onchange="this.form.submit()"
                                            >
                                        </label>
                                    </form>
                                </td>
                                <td>
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('backend.clients.show', $client) }}" class="btn btn-sm btn-light" title="Ver">
                                            <i class="ki-filled ki-eye"></i>
                                        </a>
                                        <a href="{{ route('backend.clients.edit', $client) }}" class="btn btn-sm btn-primary" title="Editar">
                                            <i class="ki-filled ki-notepad-edit"></i>
                                        </a>
                                        <form action="{{ route('backend.clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este cliente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="ki-filled ki-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">
                                    No se encontraron clientes
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-5">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
