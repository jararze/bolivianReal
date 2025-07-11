<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Configuration;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Log;
use Illuminate\Database\Eloquent\Collection;

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
            'serviceType',
            'agent',
            'amenities',
            'facilities',
            'whatcity',
            'neighborhoodRelation'
        ])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Propiedades similares con múltiples criterios
        $similarProperties = $this->getSimilarProperties($property);

        return view('frontend.properties.show', compact('property', 'similarProperties'));
    }

    /**
     * Obtiene propiedades similares basadas en múltiples criterios
     */
    private function getSimilarProperties(Property $property, int $limit = 6): Collection
    {
        // Criterio 1: Mismo tipo de propiedad y rango de precio similar
        $query1 = Property::with(['images', 'propertyType', 'serviceType', 'whatcity', 'neighborhoodRelation'])
            ->where('propertytype_id', $property->propertytype_id)
            ->whereBetween('lowest_price', [
                $property->lowest_price * 0.7,
                $property->lowest_price * 1.3
            ])
            ->where('id', '!=', $property->id)
            ->where('status', true);

        // Criterio 2: Misma ciudad
        if ($property->city) {
            $query1->where('city', $property->city);
        }

        $similarByTypeAndPrice = $query1->take($limit)->get();

        // Si no tenemos suficientes, buscar por ubicación
        if ($similarByTypeAndPrice->count() < $limit) {
            $remaining = $limit - $similarByTypeAndPrice->count();

            $similarByLocation = Property::with(['images', 'propertyType', 'serviceType', 'whatcity', 'neighborhoodRelation'])
                ->where('city', $property->city)
                ->where('id', '!=', $property->id)
                ->whereNotIn('id', $similarByTypeAndPrice->pluck('id'))
                ->where('status', true)
                ->take($remaining)
                ->get();

            $similarByTypeAndPrice = $similarByTypeAndPrice->merge($similarByLocation);
        }

        // Si aún no tenemos suficientes, buscar por tipo de servicio
        if ($similarByTypeAndPrice->count() < $limit) {
            $remaining = $limit - $similarByTypeAndPrice->count();

            $similarByService = Property::with(['images', 'propertyType', 'serviceType', 'whatcity', 'neighborhoodRelation'])
                ->where('servicetype_id', $property->servicetype_id)
                ->where('propertytype_id', $property->propertytype_id)
                ->where('id', '!=', $property->id)
                ->whereNotIn('id', $similarByTypeAndPrice->pluck('id'))
                ->where('status', true)
                ->take($remaining)
                ->get();

            $similarByTypeAndPrice = $similarByTypeAndPrice->merge($similarByService);
        }

        // Si aún no hay suficientes, buscar solo por tipo de propiedad
        if ($similarByTypeAndPrice->count() < $limit) {
            $remaining = $limit - $similarByTypeAndPrice->count();

            $similarByType = Property::with(['images', 'propertyType', 'serviceType', 'whatcity', 'neighborhoodRelation'])
                ->where('propertytype_id', $property->propertytype_id)
                ->where('id', '!=', $property->id)
                ->whereNotIn('id', $similarByTypeAndPrice->pluck('id'))
                ->where('status', true)
                ->inRandomOrder()
                ->take($remaining)
                ->get();

            $similarByTypeAndPrice = $similarByTypeAndPrice->merge($similarByType);
        }

        // Ordenar por relevancia y convertir a Collection de Eloquent
        $sorted = $similarByTypeAndPrice->sortByDesc(function ($item) use ($property) {
            $score = 0;

            // Propiedades destacadas tienen mayor peso
            if ($item->is_featured ?? false) {
                $score += 50;
            }

            // Proximidad de precio
            $priceDiff = abs($item->lowest_price - $property->lowest_price);
            $maxPrice = max($item->lowest_price, $property->lowest_price);
            if ($maxPrice > 0) {
                $priceScore = 50 * (1 - ($priceDiff / $maxPrice));
                $score += $priceScore;
            }

            // Mismo barrio/zona
            if ($item->neighborhood_id === $property->neighborhood_id) {
                $score += 30;
            }

            // Similar número de habitaciones
            if ($item->bedrooms === $property->bedrooms) {
                $score += 20;
            }

            return $score;
        })->take($limit);

        // Retornar como Collection de Eloquent
        return new Collection($sorted->values()->all());
    }

    /**
     * Método alternativo más simple si prefieres algo básico
     */
    private function getSimilarPropertiesSimple(Property $property, int $limit = 3): Collection
    {
        $properties = Property::with(['images', 'propertyType', 'serviceType', 'whatcity', 'neighborhoodRelation'])
            ->where('status', true)
            ->where('id', '!=', $property->id)
            ->where(function ($query) use ($property) {
                $query->where('propertytype_id', $property->propertytype_id)
                    ->orWhere('city_id', $property->city_id)
                    ->orWhereBetween('lowest_price', [
                        $property->lowest_price * 0.8,
                        $property->lowest_price * 1.2
                    ]);
            })
            ->inRandomOrder()
            ->take($limit)
            ->get();

        return $properties;
    }


    public function search(Request $request)
    {
        $query = Property::query()->with(['propertyType', 'images', 'amenities', 'serviceType', 'neighborhood', 'whatcity'])
            ->where('status', true);

        // Filtro por ciudad
        if ($request->filled('location') && $request->location !== 'any') {
            $query->where('city', $request->location);
        }

        // Filtro por vecindario (nuevo)
        if ($request->filled('neighborhood_id') && $request->neighborhood_id !== 'any') {
            $query->where('neighborhood_id', $request->neighborhood_id);
        }

        // Filtro por tipo de propiedad - CORREGIDO
        if ($request->filled('propertytype_id') && $request->propertytype_id !== 'any') {
            $query->where('propertytype_id', $request->propertytype_id);
        }
        // Mantener compatibilidad con el nombre anterior
        if ($request->filled('type') && $request->type !== 'any') {
            $query->where('propertytype_id', $request->type);
        }

        // Filtro por estado (servicio) - CORREGIDO
        if ($request->filled('service_type_id') && $request->service_type_id !== 'any') {
            $query->where('service_type_id', $request->service_type_id); // Usar el nombre correcto de la columna
        }
        // Mantener compatibilidad con el nombre anterior
        if ($request->filled('status') && $request->status !== 'any') {
            $query->where('service_type_id', $request->status);
        }

        // Filtro por palabra clave
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('neighborhood', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('address', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('code', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('short_description', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('long_description', 'LIKE', "%{$request->keyword}%");
            });
        }

        // Filtro por código de propiedad
        if ($request->filled('property_id') || $request->filled('code')) {
            $propertyCode = $request->filled('property_id') ? $request->property_id : $request->code;
            $query->where('code', 'LIKE', "%{$propertyCode}%");
        }

        // Filtro por dormitorios
        if ($request->filled('bedrooms') && $request->bedrooms != 'any') {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Filtro por baños
        if ($request->filled('bathrooms') && $request->bathrooms != 'any') {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        // Filtro por garajes (nuevo)
        if ($request->filled('garage') && $request->garage != 'any') {
            $query->where('garage', '>=', $request->garage);
        }

        // Filtro por rango de precio (nuevo formato)
        if ($request->filled('price_range') && $request->price_range != 'any') {
            $priceRange = explode('-', $request->price_range);
            $minPrice = $priceRange[0];
            $maxPrice = $priceRange[1];

            if ($minPrice > 0) {
                $query->where('lowest_price', '>=', $minPrice);
            }

            if ($maxPrice > 0) {
                $query->where(function($q) use ($maxPrice) {
                    $q->where('lowest_price', '<=', $maxPrice)
                        ->orWhere('max_price', '<=', $maxPrice);
                });
            }
        } else {
            // Compatibilidad con el filtro anterior de precio min/max
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
        }

        // Filtro por rango de tamaño (nuevo formato)
        if ($request->filled('size_range') && $request->size_range != 'any') {
            $sizeRange = explode('-', $request->size_range);
            $minSize = $sizeRange[0];
            $maxSize = $sizeRange[1];

            if ($minSize > 0) {
                $query->where('size', '>=', $minSize);
            }

            if ($maxSize > 0) {
                $query->where(function($q) use ($maxSize) {
                    $q->where('size', '<=', $maxSize)
                        ->orWhere('size_max', '<=', $maxSize);
                });
            }
        } else {
            // Compatibilidad con el filtro anterior de área min/max
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
        }

        // Filtro por tipo de proyecto o propiedad terminada (nuevo)
        if ($request->filled('is_project') && $request->is_project != 'any') {
            $query->where('is_project', $request->is_project);
        }

        // Filtro por antigüedad de la propiedad (nuevo)
        if ($request->filled('property_age') && $request->property_age != 'any') {
            $currentYear = date('Y');

            switch ($request->property_age) {
                case 'new':
                    // Propiedades a estrenar (proyectos o propiedades entregadas este año)
                    $query->where(function($q) use ($currentYear) {
                        $q->where('is_project', true)
                            ->orWhereYear('delivery', $currentYear);
                    });
                    break;

                case 'less-than-5':
                    // Propiedades con menos de 5 años
                    $yearCutoff = $currentYear - 5;
                    $query->whereYear('delivery', '>', $yearCutoff);
                    break;

                case '5-to-10':
                    // Propiedades entre 5 y 10 años
                    $yearLower = $currentYear - 10;
                    $yearUpper = $currentYear - 5;
                    $query->whereYear('delivery', '<=', $yearUpper)
                        ->whereYear('delivery', '>=', $yearLower);
                    break;

                case '10-to-20':
                    // Propiedades entre 10 y 20 años
                    $yearLower = $currentYear - 20;
                    $yearUpper = $currentYear - 10;
                    $query->whereYear('delivery', '<=', $yearUpper)
                        ->whereYear('delivery', '>=', $yearLower);
                    break;

                case 'more-than-20':
                    // Propiedades con más de 20 años
                    $yearCutoff = $currentYear - 20;
                    $query->whereYear('delivery', '<', $yearCutoff);
                    break;
            }
        }

        // Filtro por featured o hot (nuevo)
        if ($request->filled('featured') && $request->featured != 'any') {
            if ($request->featured == 'hot') {
                $query->where('hot', true);
            } else {
                $query->where('featured', true);
            }
        }

        // Filtro por amenidades
        if ($request->filled('amenities')) {
            $amenities = is_array($request->amenities) ? $request->amenities : [$request->amenities];
            foreach ($amenities as $amenity) {
                $query->whereHas('amenities', function($q) use ($amenity) {
                    $q->where('amenities.id', $amenity);
                });
            }
        }

        // Ordenamiento
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price-asc':
                case 'price_low':
                    $query->orderBy('lowest_price', 'asc');
                    break;
                case 'price-desc':
                case 'price_high':
                    $query->orderBy('lowest_price', 'desc');
                    break;
                case 'date-asc':
                case 'date_old':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'size_low':
                    $query->orderBy('size', 'asc');
                    break;
                case 'size_high':
                    $query->orderBy('size', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Debug: agregar temporalmente para ver la consulta SQL
        // \Log::info('Search Query SQL: ' . $query->toSql());
        // \Log::info('Search Query Bindings: ', $query->getBindings());

        // Obtener propiedades destacadas para el sidebar
        $featuredProperties = Property::with(['images', 'propertyType', 'serviceType'])
            ->where('status', true)
            ->where('featured', true)
            ->inRandomOrder()
            ->take(2)
            ->get();

        // Paginar resultados
        $properties = $query->paginate(12)->withQueryString();;

        // Obtener datos para el sidebar y filtros
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
        $neighborhoods = Neighborhood::select(['id', 'name', 'city_id'])
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return view('frontend.properties.search', compact(
            'properties',
            'cities',
            'propertyTypes',
            'serviceTypes',
            'amenities',
            'neighborhoods',
            'featuredProperties',
            'request'  // Pasar el request para mantener valores en formularios
        ));
    }

    public function about(): View
    {
        return view('frontend.about');
    }

    public function services(): View
    {
        return view('frontend.services');
    }

    public function promotions(): View
    {
        return view('frontend.promotions');
    }

    public function contact(): View
    {
        return view('frontend.contact');
    }
}
