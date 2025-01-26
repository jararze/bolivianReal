<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Configuration;
use Illuminate\View\View;
use Log;

class HomeController extends Controller
{
    public function index(): View
    {

        $randomProperties = Property::with(['images', 'propertyType'])
            ->where('status', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

//        // Obtener propiedades para el slider desde la configuración
//        $sliderSettings = Configuration::where('key', 'home_slider_settings')
//            ->where('status', true)
//            ->first();
//
//        $sliderProperties = collect();
//        if ($sliderSettings && !empty($sliderSettings->value['slider_ids'])) {
//            $sliderProperties = Property::with(['images', 'propertyType'])
//                ->whereIn('id', $sliderSettings->value['slider_ids'])
//                ->where('status', true)
//                ->get();
//        }

        $hotProperties = Property::where('hot', true)
            ->where('status', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $featuredProperties = Property::where('featured', true)
            ->where('status', true)
            ->with(['propertytype', 'images']) // Carga eager el tipo de propiedad
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Obtener tipos de propiedades para el buscador
        $propertyTypes = PropertyType::select(['id', 'type_name'])
            ->where('status', true)
            ->get();

        return view('frontend.home', compact(
            'featuredProperties',
//            'sliderProperties',
            'propertyTypes',
            'randomProperties',
            'hotProperties'
        ));
    }

    public function refreshRandomProperties()
    {
        $randomProperties = Property::with(['images', 'propertyType'])
            ->where('status', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        foreach($randomProperties as $property) {
            Log::info('Thumbnail: ' . storage_path('app/public/properties/thumbnail/' . $property->thumbnail));
            foreach($property->images as $image) {
                Log::info('Image path: ' . storage_path('app/public/properties/images/' . $image->image_path));
                Log::info('Image exists: ' . file_exists(storage_path('app/public/properties/images/' . $image->image_path)));
            }
        }

        return view('frontend.partials.random-properties', compact('randomProperties'))->render();
    }

    public function show(string $slug): View
    {
        $property = Property::with([
            'images',
            'propertyType',
            'agent',
            'amenities',
            'facilities'
        ])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Propiedades similares basadas en tipo y precio
        $similarProperties = Property::with(['images', 'propertyType'])
            ->where('propertytype_id', $property->propertytype_id)
            ->whereBetween('lowest_price', [
                $property->lowest_price * 0.8,
                $property->lowest_price * 1.2
            ])
            ->where('id', '!=', $property->id)
            ->where('status', true)
            ->take(3)
            ->get();

        return view('frontend.properties.show', compact('property', 'similarProperties'));
    }
}
