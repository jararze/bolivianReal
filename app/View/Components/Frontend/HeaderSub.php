<?php

namespace App\View\Components\Frontend;

use App\Models\Amenity;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\PropertyType;
use App\Models\ServiceType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderSub extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $cities = City::select(['id', 'name'])
            ->get();

        $propertyTypes = PropertyType::select(['id', 'type_name'])
            ->where('status', true)
            ->get();

        $serviceTypes = ServiceType::select(['id', 'name'])
            ->where('status', true)
            ->get();

        $amenities = Amenity::select(['id', 'name'])
            ->where('status', true)
            ->get();

        $neighborhoods = Neighborhood::select(['neighborhoods.id', 'neighborhoods.name', 'neighborhoods.city_id'])
            ->join('properties', 'neighborhoods.id', '=', 'properties.neighborhood_id')
            ->where('neighborhoods.status', true)
            ->where('properties.status', true) // Solo propiedades activas
            ->whereNull('properties.deleted_at') // Excluir propiedades eliminadas (soft delete)
            ->distinct()
            ->orderBy('neighborhoods.name')
            ->get();

        return view('components.frontend.header-sub', compact(
            'cities',
            'propertyTypes',
            'serviceTypes',
            'amenities',
            'neighborhoods'
        ));
    }
}
