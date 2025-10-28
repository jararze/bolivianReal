<?php

namespace App\View\Components\Frontend;

use App\Models\Amenity;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\PropertyType;
use App\Models\ServiceType;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    public function render(): View
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

        $neighborhoods = Neighborhood::select(['id', 'name', 'city_id'])
            ->where('status', true)
            ->orderBy('name')
            ->get();


        return view('components.frontend.search', compact(
            'cities',
            'propertyTypes',
            'serviceTypes',
            'amenities',
            'neighborhoods'
        ));

    }
}
