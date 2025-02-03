<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Configuration;
use App\Models\ServiceType;
use Illuminate\Http\Request;
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

//        foreach($randomProperties as $property) {
//            Log::info('Thumbnail: ' . storage_path('app/public/properties/thumbnail/' . $property->thumbnail));
//            foreach($property->images as $image) {
//                Log::info('Image path: ' . storage_path('app/public/properties/images/' . $image->image_path));
//                Log::info('Image exists: ' . file_exists(storage_path('app/public/properties/images/' . $image->image_path)));
//            }
//        }

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


    public function search(Request $request)
    {
        $query = Property::query()->with(['propertyType', 'images', 'amenities', 'serviceType'])
            ->where('status', true);


//        Log::info('Search Parameters:', [
//            'location' => $request->location,
//            'type' => $request->type,
//            'status' => $request->status,
//            'keyword' => $request->keyword
//        ]);

        if ($request->filled('location') && $request->location !== 'any') {
            $query->where('city', $request->location);
        }

        if ($request->filled('type') && $request->type !== 'any') {
            $query->where('propertytype_id', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'any') {
            $query->where('service_type_id', $request->status);
        }

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('neighborhood', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('address', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('code', 'LIKE', "%{$request->keyword}%");
            });
        }

        // Filtro por código de propiedad
        if ($request->filled('property_id')) {
            $query->where('code', $request->property_id);
        }

        // Filtro por dormitorios
        if ($request->filled('bedrooms') && $request->bedrooms != '') {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Filtro por baños
        if ($request->filled('bathrooms') && $request->bathrooms != '') {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        // Filtro por precio mínimo
        if ($request->filled('min_price') && $request->min_price != '') {
            $query->where('lowest_price', '>=', $request->min_price);
        }

        // Filtro por precio máximo
        if ($request->filled('max_price') && $request->max_price != '') {
            $query->where(function($q) use ($request) {
                $q->where('lowest_price', '<=', $request->max_price)
                    ->orWhere('max_price', '<=', $request->max_price);
            });
        }

        // Filtro por área mínima
        if ($request->filled('min_area') && $request->min_area != '') {
            $query->where('size', '>=', $request->min_area);
        }

        // Filtro por área máxima
        if ($request->filled('max_area') && $request->max_area != '') {
            $query->where(function($q) use ($request) {
                $q->where('size', '<=', $request->max_area)
                    ->orWhere('size_max', '<=', $request->max_area);
            });
        }

        // Filtro por amenidades
        if ($request->filled('amenities')) {
            $amenitiesString = implode(',', $request->amenities);
            $query->where('amenities_id', 'LIKE', "%$amenitiesString%");
        }

        // Ordenamiento
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price-asc':
                    $query->orderBy('lowest_price', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('lowest_price', 'desc');
                    break;
                case 'date-asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }


        $featuredProperties = Property::with(['images', 'propertyType', 'serviceType'])
            ->where('status', true)
            ->where('featured', true) // Asumiendo que tienes un campo featured
            ->inRandomOrder()
            ->take(2)
            ->get();

        Log::info('Total properties found:', ['count' => $query->count()]);

        $properties = $query->paginate(12);

        // Obtener datos para el sidebar
        $cities = City::select(['id', 'name'])->get();
        $propertyTypes = PropertyType::select(['id', 'type_name'])
            ->where('status', true)
            ->orderBy('type_name')
            ->get();
        $serviceTypes = ServiceType::select(['id', 'name'])
            ->where('status', true)
            ->orderBy('name')
            ->get();
        $amenities = Amenity::select(['id', 'name'])
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return view('frontend.properties.search', compact(
            'properties',
            'cities',
            'propertyTypes',
            'serviceTypes',
            'amenities',
            'featuredProperties'
        ));
    }
}
