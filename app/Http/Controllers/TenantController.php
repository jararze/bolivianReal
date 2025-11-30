<?php

namespace App\Http\Controllers;

use App\Models\PropertyContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    /**
     * Display a listing of tenants (from property_contracts)
     */
    public function index(Request $request)
    {
        $query = PropertyContract::with(['property.propertyType', 'property.citys'])
            ->whereNotNull('tenant_name');

        // Filtro de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tenant_name', 'like', "%{$search}%")
                    ->orWhere('tenant_phone', 'like', "%{$search}%")
                    ->orWhere('tenant_email', 'like', "%{$search}%")
                    ->orWhere('tenant_ci', 'like', "%{$search}%");
            });
        }

        // Filtro por estado del contrato
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por tipo de contrato
        if ($request->filled('contract_type')) {
            $query->where('contract_type', $request->contract_type);
        }

        $contracts = $query->latest()->paginate(20);

        // Estadísticas
        $stats = [
            'total' => PropertyContract::whereNotNull('tenant_name')->count(),
            'active' => PropertyContract::whereNotNull('tenant_name')->where('status', 'active')->count(),
            'expired' => PropertyContract::whereNotNull('tenant_name')->where('status', 'expired')->count(),
            'terminated' => PropertyContract::whereNotNull('tenant_name')->where('status', 'terminated')->count(),
        ];

        return view('backend.tenants.index', compact('contracts', 'stats'));
    }

    /**
     * Display the specified tenant (contract details)
     */
    public function show(PropertyContract $contract)
    {
        $contract->load([
            'property.propertyType',
            'property.citys',
            'property.client',
            'property.agent'
        ]);

        return view('backend.tenants.show', compact('contract'));
    }

    /**
     * Get tenants grouped by unique identity
     */
    public function tenantsList(Request $request)
    {
        // Agrupar por CI o nombre+email para encontrar inquilinos únicos
        $tenants = PropertyContract::select(
            'tenant_name',
            'tenant_phone',
            'tenant_email',
            'tenant_ci',
            'tenant_address',
            DB::raw('COUNT(*) as contracts_count'),
            DB::raw('MAX(id) as latest_contract_id')
        )
            ->whereNotNull('tenant_name')
            ->groupBy('tenant_ci', 'tenant_name', 'tenant_phone', 'tenant_email', 'tenant_address')
            ->orderBy('tenant_name')
            ->paginate(20);

        $stats = [
            'unique_tenants' => PropertyContract::whereNotNull('tenant_name')
                ->distinct('tenant_ci')
                ->count('tenant_ci'),
            'total_contracts' => PropertyContract::whereNotNull('tenant_name')->count(),
        ];

        return view('backend.tenants.list', compact('tenants', 'stats'));
    }

    /**
     * Show tenant history (all contracts of a specific tenant)
     */
    public function history(Request $request)
    {
        $tenantCi = $request->get('ci');
        $tenantName = $request->get('name');

        if (!$tenantCi && !$tenantName) {
            return redirect()->route('backend.tenants.list')
                ->with('error', 'Debe proporcionar CI o nombre del inquilino');
        }

        $query = PropertyContract::with(['property.propertyType', 'property.citys']);

        if ($tenantCi) {
            $query->where('tenant_ci', $tenantCi);
        } elseif ($tenantName) {
            $query->where('tenant_name', $tenantName);
        }

        $contracts = $query->latest()->get();

        // Información del inquilino (del contrato más reciente)
        $tenant = $contracts->first();

        return view('backend.tenants.history', compact('contracts', 'tenant'));
    }

    /**
     * Export tenants to Excel/CSV
     */
    public function export(Request $request, $format = 'csv')
    {
        $tenants = PropertyContract::select(
            'tenant_name',
            'tenant_phone',
            'tenant_email',
            'tenant_ci',
            'tenant_address',
            'contract_type',
            'start_date',
            'end_date',
            'monthly_rent',
            'status'
        )
            ->whereNotNull('tenant_name')
            ->latest()
            ->get();

        if ($format === 'csv') {
            $filename = 'inquilinos_' . date('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($tenants) {
                $file = fopen('php://output', 'w');

                // Headers
                fputcsv($file, [
                    'Nombre',
                    'Teléfono',
                    'Email',
                    'CI',
                    'Dirección',
                    'Tipo Contrato',
                    'Fecha Inicio',
                    'Fecha Fin',
                    'Renta Mensual',
                    'Estado'
                ]);

                // Data
                foreach ($tenants as $tenant) {
                    fputcsv($file, [
                        $tenant->tenant_name,
                        $tenant->tenant_phone,
                        $tenant->tenant_email,
                        $tenant->tenant_ci,
                        $tenant->tenant_address,
                        $tenant->contract_type,
                        $tenant->start_date,
                        $tenant->end_date,
                        $tenant->monthly_rent,
                        $tenant->status,
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return back()->with('error', 'Formato no soportado');
    }
}
