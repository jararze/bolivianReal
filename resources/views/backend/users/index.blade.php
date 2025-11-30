<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Gestión de Usuarios</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('backend.users.create') }}" class="btn btn-primary">
                <i class="ki-filled ki-plus"></i>
                Nuevo Usuario
            </a>
        </div>
    </x-slot>

    <div class="container-fixed">
        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-5 mb-7.5">
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-lg bg-primary-light flex items-center justify-center">
                            <i class="ki-filled ki-people text-2xl text-primary"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
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
                            <p class="text-sm text-gray-600">Inactivos</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['inactive'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-lg bg-info-light flex items-center justify-center">
                            <i class="ki-filled ki-user-tick text-2xl text-info"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Agentes</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['agents'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-lg bg-warning-light flex items-center justify-center">
                            <i class="ki-filled ki-shield-tick text-2xl text-warning"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Admins</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['admins'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card mb-5">
            <div class="card-body">
                <form method="GET" action="{{ route('backend.users.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="md:col-span-2">
                            <input type="text" name="search" class="input w-full"
                                   placeholder="Buscar por nombre, email o usuario..."
                                   value="{{ request('search') }}">
                        </div>
                        <div>
                            <select name="role" class="select w-full">
                                <option value="">Todos los Roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administradores</option>
                                <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agentes</option>
                                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Usuarios</option>
                            </select>
                        </div>
                        <div>
                            <select name="status" class="select w-full">
                                <option value="">Todos los Estados</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="btn btn-primary flex-1">
                                <i class="ki-filled ki-filter"></i>
                                Filtrar
                            </button>
                            <a href="{{ route('backend.users.index') }}" class="btn btn-light">
                                <i class="ki-filled ki-cross"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Usuarios del Sistema</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-rounded">
                        <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Contacto</th>
                            <th>Rol</th>
                            <th>Propiedades</th>
                            <th>Paquete</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" class="size-10 rounded-full object-cover">
                                        @else
                                            <div class="size-10 rounded-full bg-primary-light flex items-center justify-center">
                                                <span class="text-primary font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $user->full_name }}</p>
                                            @if($user->jobtitle)
                                                <p class="text-xs text-gray-600">{{ $user->jobtitle }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col gap-1">
                                        @if($user->email)
                                            <a href="mailto:{{ $user->email }}" class="text-sm text-gray-700 hover:text-primary flex items-center gap-1">
                                                <i class="ki-filled ki-sms text-xs"></i>
                                                {{ $user->email }}
                                            </a>
                                        @endif
                                        @if($user->phone)
                                            <a href="tel:{{ $user->phone }}" class="text-sm text-gray-700 hover:text-primary flex items-center gap-1">
                                                <i class="ki-filled ki-phone text-xs"></i>
                                                {{ $user->phone }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $roleColors = [
                                            'admin' => 'danger',
                                            'agent' => 'primary',
                                            'user' => 'info'
                                        ];
                                        $roleLabels = [
                                            'admin' => 'Administrador',
                                            'agent' => 'Agente',
                                            'user' => 'Usuario'
                                        ];
                                    @endphp
                                    <span class="badge badge-{{ $roleColors[$user->role] ?? 'light' }}">
                                            {{ $roleLabels[$user->role] ?? $user->role }}
                                        </span>
                                </td>
                                <td>
                                        <span class="badge badge-info">
                                            {{ $user->properties_count ?? 0 }}
                                        </span>
                                </td>
                                <td>
                                    @if($user->package)
                                        <span class="text-sm text-gray-700">{{ $user->package->name }}</span>
                                    @else
                                        <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('backend.users.toggle-status', $user) }}" method="POST">
                                        @csrf
                                        <label class="switch">
                                            <input type="checkbox" {{ $user->status === 'active' ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        </label>
                                    </form>
                                </td>
                                <td>
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('backend.users.show', $user) }}"
                                           class="btn btn-sm btn-light" title="Ver">
                                            <i class="ki-filled ki-eye"></i>
                                        </a>
                                        <a href="{{ route('backend.users.edit', $user) }}"
                                           class="btn btn-sm btn-primary" title="Editar">
                                            <i class="ki-filled ki-notepad-edit"></i>
                                        </a>
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('backend.users.destroy', $user) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Eliminar este usuario?')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                    <i class="ki-filled ki-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <i class="ki-filled ki-people text-6xl text-gray-300"></i>
                                    <p class="text-gray-500 mt-2">No se encontraron usuarios</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
