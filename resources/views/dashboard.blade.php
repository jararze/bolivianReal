<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Dashboard</h1>
    </x-slot>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">

            <!-- KPIs Principales -->
            <div class="grid lg:grid-cols-4 gap-5">
                <div class="card border-l-4 border-l-primary">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Propiedades Activas</p>
                                <p class="text-3xl font-bold text-primary">{{ $kpis['active_properties'] }}</p>
                            </div>
                            <i class="ki-filled ki-home text-5xl text-primary opacity-20"></i>
                        </div>
                    </div>
                </div>

                <div class="card border-l-4 border-l-success">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Contratos Activos</p>
                                <p class="text-3xl font-bold text-success">{{ $kpis['active_contracts'] }}</p>
                            </div>
                            <i class="ki-filled ki-document text-5xl text-success opacity-20"></i>
                        </div>
                    </div>
                </div>

                <div class="card border-l-4 border-l-warning">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Por Vencer (3m)</p>
                                <p class="text-3xl font-bold text-warning">{{ $kpis['expiring_soon_contracts'] }}</p>
                            </div>
                            <i class="ki-filled ki-notification-on text-5xl text-warning opacity-20"></i>
                        </div>
                    </div>
                </div>

                <div class="card border-l-4 border-l-info">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Usuarios Totales</p>
                                <p class="text-3xl font-bold text-info">{{ $kpis['total_users'] }}</p>
                            </div>
                            <i class="ki-filled ki-profile-user text-5xl text-info opacity-20"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fila Principal -->
            <div class="grid lg:grid-cols-3 gap-5">

                <!-- Contratos por Vencer -->
                <div class="lg:col-span-2">
                    <div class="card h-full">
                        <div class="card-header">
                            <h3 class="card-title">Contratos por Vencer</h3>
                            <a href="{{ route('backend.contracts.alerts') }}" class="btn btn-sm btn-light">Ver Todos</a>
                        </div>
                        <div class="card-body">
                            @forelse($expiring_contracts as $contract)
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <div class="flex-1">
                                        <p class="font-semibold text-sm text-gray-900">{{ $contract->property->name }}</p>
                                        <p class="text-xs text-gray-600">{{ $contract->tenant_name ?? 'Sin inquilino' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium">{{ $contract->end_date->format('d/m/Y') }}</p>
                                        <span class="badge badge-sm {{ $contract->getDaysRemaining() <= 7 ? 'badge-danger' : 'badge-warning' }}">
                                            {{ $contract->getDaysRemaining() }}d
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 py-4">No hay contratos por vencer</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Resumen</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Fuera de Mercado</span>
                            <span class="font-bold text-danger">{{ $kpis['off_market_properties'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Destacadas</span>
                            <span class="font-bold text-warning">{{ $kpis['featured_properties'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Agentes Activos</span>
                            <span class="font-bold text-info">{{ $kpis['active_agents'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Mensajes (7d)</span>
                            <span class="font-bold text-primary">{{ $kpis['unread_messages'] }}</span>
                        </div>
                        <div class="separator"></div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Alquileres</span>
                            <span class="font-bold">{{ $contracts_by_type['rent'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Anticréticos</span>
                            <span class="font-bold">{{ $contracts_by_type['anticretico'] }}</span>
                        </div>
                        <div class="separator"></div>
                        <div class="bg-primary-light rounded-lg p-3">
                            <p class="text-xs text-gray-600 mb-1">Ingresos Mensuales</p>
                            <p class="text-2xl font-bold text-primary">Bs. {{ number_format($projected_income, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Propiedades Recientes y Por Tipo -->
            <div class="grid lg:grid-cols-2 gap-5">

                <!-- Propiedades Recientes -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Propiedades Recientes</h3>
                        <a href="{{ route('backend.properties.index') }}" class="btn btn-sm btn-light">Ver Todas</a>
                    </div>
                    <div class="card-body">
                        @foreach($recent_properties as $property)
                            <div class="flex items-center gap-3 py-3 border-b border-gray-200">
                                @if($property->thumbnail)
                                    <img src="{{ asset('storage/' . $property->thumbnail) }}" class="size-12 rounded object-cover">
                                @endif
                                <div class="flex-1">
                                    <p class="font-semibold text-sm">{{ Str::limit($property->name, 30) }}</p>
                                    <p class="text-xs text-gray-600">{{ $property->propertyType->type_name ?? '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-sm">{{ $property->currency }} {{ number_format($property->lowest_price, 0) }}</p>
                                    <span class="badge badge-sm badge-success">{{ $property->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Por Tipo y Ciudad -->
                <div class="grid gap-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Por Tipo de Propiedad</h3>
                        </div>
                        <div class="card-body">
                            @foreach($properties_by_type as $item)
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm">{{ $item['type'] }}</span>
                                    <span class="badge badge-primary">{{ $item['total'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top Ciudades</h3>
                        </div>
                        <div class="card-body">
                            @foreach($properties_by_city as $city)
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm">{{ $city->city }}</span>
                                    <span class="badge badge-info">{{ $city->total }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="grid lg:grid-cols-2 gap-5">
                <!-- Ventas por Mes -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Propiedades Registradas (6 meses)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Distribución de Contratos -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estado de Contratos</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="contractsChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Rangos de Precio -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribución por Rango de Precio</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-gray-600 mb-1">Menos de 100K</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $price_ranges['under_100k'] }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-gray-600 mb-1">100K - 500K</p>
                            <p class="text-3xl font-bold text-green-600">{{ $price_ranges['100k_500k'] }}</p>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-gray-600 mb-1">500K - 1M</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $price_ranges['500k_1m'] }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-gray-600 mb-1">Más de 1M</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $price_ranges['over_1m'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Propiedades Hot y Más Vistas -->
            <div class="grid lg:grid-cols-2 gap-5">
                <!-- Hot Properties -->
                @if($hot_properties->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">🔥 Propiedades HOT</h3>
                        </div>
                        <div class="card-body space-y-4">
                            @foreach($hot_properties as $property)
                                <div class="flex items-center gap-3 p-3 bg-danger-light rounded-lg">
                                    @if($property->thumbnail)
                                        <img src="{{ asset('storage/' . $property->thumbnail) }}" class="size-16 rounded-lg object-cover">
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-bold text-sm">{{ Str::limit($property->name, 35) }}</p>
                                        <p class="text-xs text-gray-600">{{ $property->propertyType->type_name ?? '-' }}</p>
                                        <p class="font-bold text-danger mt-1">{{ $property->currency }} {{ number_format($property->lowest_price, 0) }}</p>
                                    </div>
                                    <a href="{{ route('backend.properties.edit', $property) }}" class="btn btn-sm btn-danger">Ver</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Más Guardadas -->
                @if($most_wishlisted->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">⭐ Más Guardadas en Favoritos</h3>
                        </div>
                        <div class="card-body space-y-3">
                            @foreach($most_wishlisted as $property)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        @if($property->thumbnail)
                                            <img src="{{ asset('storage/' . $property->thumbnail) }}" class="size-10 rounded object-cover">
                                        @endif
                                        <div>
                                            <p class="font-semibold text-sm">{{ Str::limit($property->name, 25) }}</p>
                                            <p class="text-xs text-gray-600">{{ $property->propertyType->type_name ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                    <span class="badge badge-warning">
                                        <i class="ki-filled ki-heart text-xs"></i>
                                        {{ $property->wishlist_count }}
                                    </span>
                                        <a href="{{ route('backend.properties.edit', $property) }}" class="btn btn-xs btn-light">Ver</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Mensajes Recientes -->
            @if($recent_messages->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Mensajes Recientes</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($recent_messages as $message)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="size-8 rounded-full bg-primary-light flex items-center justify-center">
                                                <i class="ki-filled ki-message-text text-primary"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-sm">{{ $message->name }}</p>
                                                <p class="text-xs text-gray-600">{{ $message->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-700 mb-2">{{ Str::limit($message->message, 80) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                        @if($message->property)
                                            <span class="text-xs text-primary">{{ Str::limit($message->property->name, 20) }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Usuarios Recientes -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Usuarios Recientes</h3>
                </div>
                <div class="card-body">
                    <div class="flex flex-wrap gap-4">
                        @foreach($recent_users as $user)
                            <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" class="size-12 rounded-full">
                                @else
                                    <div class="size-12 rounded-full bg-primary-light flex items-center justify-center">
                                        <span class="font-bold text-primary">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-sm">{{ $user->name }} {{ $user->lastname }}</p>
                                    <div class="flex items-center gap-2">
                                        <span class="badge badge-sm badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'agent' ? 'primary' : 'info') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Gráfico de Ventas por Mes
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($sales_by_month->pluck('month')) !!},
                    datasets: [{
                        label: 'Propiedades Registradas',
                        data: {!! json_encode($sales_by_month->pluck('total')) !!},
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Gráfico de Contratos
            const contractsCtx = document.getElementById('contractsChart').getContext('2d');
            new Chart(contractsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Activos', 'Por Vencer', 'Vencidos'],
                    datasets: [{
                        data: [
                            {{ $kpis['active_contracts'] }},
                            {{ $kpis['expiring_soon_contracts'] }},
                            {{ $kpis['expired_contracts'] }}
                        ],
                        backgroundColor: [
                            'rgb(34, 197, 94)',
                            'rgb(251, 191, 36)',
                            'rgb(239, 68, 68)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    @endpush
</x-app-layout>
