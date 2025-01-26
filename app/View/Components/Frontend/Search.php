<?php

namespace App\View\Components\Frontend;

use App\Models\City;
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


        return view('components.frontend.search', [
            'cities' => $cities,
            'propertyTypes' => $propertyTypes,
            'serviceTypes' => $serviceTypes,
        ]);

    }
}
