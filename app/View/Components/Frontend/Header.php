<?php

namespace App\View\Components\Frontend;

use App\Models\City;
use App\Models\Configuration;
use App\Models\PropertyType;
use App\Models\ServiceType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
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


        return view('components.frontend.header', [
            'cities' => $cities,
            'propertyTypes' => $propertyTypes,
            'serviceTypes' => $serviceTypes,
        ]);
    }
}
