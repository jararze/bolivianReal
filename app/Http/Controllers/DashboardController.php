<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyContract;
use App\Models\User;
use App\Models\PropertyMessage;
use App\Models\Wishlist;
use App\Models\Compare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ========================================
        // KPIs PRINCIPALES
        // ========================================
        
        $kpis = [
            // Propiedades
            'total_properties' => Property::count(),
            'active_properties' => Property::where('status', true)
                ->where('market_status', 'active')
                ->count(),
            'off_market_properties' => Property::where('market_status', 'off_market')->count(),
            'featured_properties' => Property::where('featured', true)
                ->where('status', true)
                ->count(),
            
            // Contratos
            'total_contracts' => PropertyContract::count(),
            'active_contracts' => PropertyContract::active()->count(),
            'expiring_soon_contracts' => PropertyContract::expiringIn(3)->count(),
            'expired_contracts' => PropertyContract::expired()->count(),
            
            // Usuarios
            'total_users' => User::count(),
            'active_agents' => User::where('role', 'agent')
                ->where('status', 'active')
                ->count(),
            
            // Mensajes
            'unread_messages' => PropertyMessage::whereDate('created_at', '>=', now()->subDays(7))
                ->count(),
            
            // Wishlist y Comparaciones
            'total_wishlists' => Wishlist::count(),
            'total_compares' => Compare::count(),
        ];

        // ========================================
        // PROPIEDADES RECIENTES
        // ========================================
        
        $recent_properties = Property::with(['propertyType', 'citys', 'images'])
            ->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();

        // ========================================
        // CONTRATOS POR VENCER (URGENTE)
        // ========================================
        
        $expiring_contracts = PropertyContract::with(['property'])
            ->where('status', 'active')
            ->whereDate('end_date', '<=', now()->addMonth())
            ->whereDate('end_date', '>=', now())
            ->orderBy('end_date', 'ASC')
            ->take(10)
            ->get();

        // ========================================
        // ESTADÍSTICAS POR TIPO DE PROPIEDAD
        // ========================================
        
        $properties_by_type = Property::select('propertytype_id', DB::raw('count(*) as total'))
            ->where('status', true)
            ->with('propertyType:id,type_name')
            ->groupBy('propertytype_id')
            ->get()
            ->map(function($item) {
                return [
                    'type' => $item->propertyType->type_name ?? 'Sin tipo',
                    'total' => $item->total
                ];
            });

        // ========================================
        // ESTADÍSTICAS POR CIUDAD
        // ========================================
        
        $properties_by_city = Property::select('city', DB::raw('count(*) as total'))
            ->where('status', true)
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderBy('total', 'DESC')
            ->take(5)
            ->get();

        // ========================================
        // VENTAS POR MES (Últimos 6 meses)
        // ========================================
        
        $sales_by_month = Property::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        // ========================================
        // PROPIEDADES MÁS VISTAS (Wishlist)
        // ========================================
        
        $most_wishlisted = Property::select('properties.*', DB::raw('count(wishlists.id) as wishlist_count'))
            ->join('wishlists', 'properties.id', '=', 'wishlists.property_id')
            ->groupBy('properties.id')
            ->orderBy('wishlist_count', 'DESC')
            ->take(5)
            ->get();

        // ========================================
        // ACTIVIDAD RECIENTE
        // ========================================
        
        $recent_messages = PropertyMessage::with(['property:id,name', 'user:id,name'])
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();

        // ========================================
        // CONTRATOS POR TIPO
        // ========================================
        
        $contracts_by_type = [
            'rent' => PropertyContract::where('contract_type', 'rent')->count(),
            'anticretico' => PropertyContract::where('contract_type', 'anticretico')->count(),
        ];

        // ========================================
        // INGRESOS PROYECTADOS (Contratos Activos)
        // ========================================
        
        $projected_income = PropertyContract::where('status', 'active')
            ->where('contract_type', 'rent')
            ->sum('amount');

        // ========================================
        // PROPIEDADES HOT (Destacadas)
        // ========================================
        
        $hot_properties = Property::with(['propertyType', 'images'])
            ->where('hot', true)
            ->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->get();

        // ========================================
        // RANGOS DE PRECIOS
        // ========================================
        
        $price_ranges = [
            'under_100k' => Property::where('status', true)
                ->where('lowest_price', '<', 100000)
                ->count(),
            '100k_500k' => Property::where('status', true)
                ->whereBetween('lowest_price', [100000, 500000])
                ->count(),
            '500k_1m' => Property::where('status', true)
                ->whereBetween('lowest_price', [500000, 1000000])
                ->count(),
            'over_1m' => Property::where('status', true)
                ->where('lowest_price', '>', 1000000)
                ->count(),
        ];

        // ========================================
        // USUARIOS RECIENTES
        // ========================================
        
        $recent_users = User::orderBy('created_at', 'DESC')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'kpis',
            'recent_properties',
            'expiring_contracts',
            'properties_by_type',
            'properties_by_city',
            'sales_by_month',
            'most_wishlisted',
            'recent_messages',
            'contracts_by_type',
            'projected_income',
            'hot_properties',
            'price_ranges',
            'recent_users'
        ));
    }
}
