<?php

namespace App\Http\Controllers;

use App\Http\Requests\Property\StoreRequest;
use App\Http\Requests\Property\UpdateRequest;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Facility;
use App\Models\Neighborhood;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Log;
use Intervention\Image\Laravel\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PropertyController extends Controller
{
    private const IMAGE_CONFIG = [
        'thumbnail' => [
            'width' => 800,
            'height' => 600,
            'quality' => 85,
            'create_small' => true,
            'small_width' => 400,
            'small_height' => 300,
            'small_quality' => 75
        ],
        'gallery' => [
            'width' => 1200,
            'height' => 800,
            'quality' => 85,
            'create_small' => true,
            'small_width' => 600,
            'small_height' => 400,
            'small_quality' => 75
        ]
    ];
    public function index(): View
    {
        $properties = Property::with('images')->orderBy('created_at', 'DESC')->get();
        return view('backend.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $cities = City::select(['id', 'name'])->get();
        $neighborhoods = collect();
        $propertyTypes = PropertyType::select(['id', 'type_name'])->get();
        $serviceTypes = ServiceType::select(['id', 'name'])->get();
        $agents = User::select(['id', 'name'])->where('role', 'agent')->get();
        $projects = Property::select(['id', 'name'])->where('is_project', true)->get();
        $features = Facility::select(['id', 'name'])->get();
        $amenities = Amenity::select(['id', 'name'])->get();


        return view('backend.properties.create', [
            'cities' => $cities,
            'neighborhoods' => $neighborhoods,
            'propertyTypes' => $propertyTypes,
            'serviceTypes' => $serviceTypes,
            'agents' => $agents,
            'projects' => $projects,
            'features' => $features,
            'amenities' => $amenities,
        ]);
    }

    /**
     * Obtener barrios por ciudad para AJAX.
     */
    public function getNeighborhoodsByCity($cityId)
    {
        try {
            $neighborhoods = Neighborhood::where('city_id', $cityId)
                ->where('status', 1)
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get();

            return response()->json($neighborhoods);
        } catch (\Exception $e) {
            // Log del error
            Log::error('Error obteniendo barrios:', [
                'error' => $e->getMessage(),
                'city_id' => $cityId
            ]);

            // Devolver respuesta de error
            return response()->json(['error' => 'Error al cargar los barrios'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            Log::info('Iniciando store en PropertyController');

            $validated = $request->validated();
            Log::info('Datos validados:', ['validated' => $validated]);

            // Preparar los datos para la base de datos
            $propertyData = $this->preparePropertyData($validated);
            Log::info('Datos preparados para DB:', ['propertyData' => $propertyData]);

            return DB::transaction(function () use ($request, $propertyData) {
                try {
                    // Create property
                    $property = Property::create($propertyData);
                    Log::info('Propiedad creada:', ['property' => $property->toArray()]);

                    // Procesar relaciones
                    $this->processRelations($property, $request->validated());
                    Log::info('Relaciones procesadas');

                    // Procesar imágenes
                    try {
                        $this->processImages($property, $request);
                        Log::info('Imágenes procesadas');
                    } catch (ValidationException $e) {
                        Log::error('Error de validación en imágenes:', ['errors' => $e->errors()]);
                        throw $e;
                    } catch (\Exception $e) {
                        Log::error('Error procesando imágenes:', ['message' => $e->getMessage()]);
                        // Eliminar la propiedad si hubo un error con las imágenes
                        $property->delete();
                        throw new \Exception('Error procesando imágenes: ' . $e->getMessage());
                    }

                    flash()->success('Propiedad creada satisfactoriamente.');
                    Log::info('Proceso completado con éxito');

                    return redirect()->route(
                        $request->action === 'save' ? 'backend.properties.index' : 'backend.properties.create'
                    );
                } catch (ValidationException $e) {
                    DB::rollBack();
                    Log::error('Excepción de validación en transacción:', ['errors' => $e->errors()]);
                    return back()
                        ->withErrors($e->errors())
                        ->withInput();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Excepción en transacción:', ['message' => $e->getMessage()]);
                    return back()
                        ->withError($e->getMessage())
                        ->withInput();
                }
            });

        } catch (ValidationException $e) {
            Log::error('Excepción de validación:', ['errors' => $e->errors()]);
            flash()->error('Por favor corrige los errores en el formulario.');
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            Log::error('Error de base de datos creando propiedad:', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'user_id' => auth()->id()
            ]);

            flash()->warning('Error al guardar en la base de datos. Por favor, intente nuevamente.');
            return back()->withInput();

        } catch (\Exception $e) {
            Log::error('Error creando propiedad:', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            flash()->warning('Ocurrió un error al crear la propiedad: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function show(Property $property): View
    {
        return view('frontend.properties.show', compact('property'));
    }



    private function preparePropertyData(array $validated): array
    {
        try {
            // Generar código único
            $code = IdGenerator::generate([
                'table' => 'properties',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'P' . date('ym')
            ]);

            // Filtrar solo los campos que van directamente a la tabla properties
            $propertyFields = [
                'name', 'address', 'neighborhood_id', 'size', 'size_max',
                'city', 'country', 'propertytype_id', 'property_status',
                'chosen_currency', 'lowest_price', 'max_price',
                'bedrooms', 'bathrooms', 'garage', 'garage_size',
                'short_description', 'long_description', 'latitude', 'longitude',
                'video', 'featured', 'hot', 'agent_id', 'status', 'is_project',
                'units', 'project_id', 'service_type_id'
            ];

            $propertyData = array_intersect_key($validated, array_flip($propertyFields));

            // Agregar campos adicionales
            $propertyData['currency'] = $propertyData['currency'] ?? 'Bs';
            $propertyData['slug'] = Str::slug($validated['name']);
            $propertyData['created_by'] = auth()->id();
            $propertyData['code'] = $code; // Agregar el código generado

            return $propertyData;

        } catch (\Exception $e) {
            Log::error('Error generando código de propiedad:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('Error generando código de propiedad: ' . $e->getMessage());
        }
    }

    private function processRelations(Property $property, array $validated): void
    {
        // Sincronizar facilities si existen
        if (!empty($validated['features'])) {
            $facilityData = collect($validated['features'])->mapWithKeys(function($featureId, $index) use ($validated) {
                return [
                    $featureId => [
                        'name' => $validated['place_names'][$index] ?? '',
                        'distance' => $validated['distances'][$index] ?? ''
                    ]
                ];
            })->all();

            $property->facilities()->sync($facilityData);
        }

        // Sincronizar amenities si existen
        if (!empty($validated['amenities'])) {
            $property->amenities()->sync($validated['amenities']);
        }
    }

    private function processImages(Property $property, StoreRequest $request): void
    {
        // Procesar thumbnail
        if ($request->hasFile('thumbnail')) {
            try {
                $thumbnailPaths = $this->handleImage(
                    $request->file('thumbnail'),
                    'thumbnails',
                    800,
                    600,
                    80,
                    $property->code,
                    true
                );
                $property->update([
                    'thumbnail' => $thumbnailPaths['original'],
                ]);
            } catch (\Exception $e) {
                Log::error('Error procesando thumbnail:', [
                    'error' => $e->getMessage(),
                    'property_id' => $property->id
                ]);
                throw new \Exception('Error procesando la imagen principal: ' . $e->getMessage());
            }
        }

        // Procesar imágenes adicionales
        if ($request->hasFile('images')) {
            try {
                $this->processPropertyImages($request->file('images'), $property);
            } catch (\Exception $e) {
                Log::error('Error procesando imágenes adicionales:', [
                    'error' => $e->getMessage(),
                    'property_id' => $property->id
                ]);
                throw new \Exception('Error procesando imágenes adicionales: ' . $e->getMessage());
            }
        }
    }
    /**
     * Handle image upload, processing, and optimization
     *
     * @param  UploadedFile  $file
     * @param  string  $path
     * @param  int  $maxWidth
     * @param  int  $maxHeight
     * @param  int  $quality
     * @return string[]
     * @throws \Exception
     */
    private function handleImage(
        UploadedFile $file,
        string $type,
        int $maxWidth = 1200,
        int $maxHeight = 1200,
        int $quality = 80,
        string $propertyCode = '',
        bool $createSmallVersion = false
    ): array {
        $paths = []; // Inicializar la variable paths aquí

        try {
            // Create image instance
            $image = Image::read($file);

            // Verificar dimensiones mínimas
//            if ($image->width() < 800 || $image->height() < 600) {
//                throw new \Exception("La imagen debe tener al menos 800x600 píxeles.");
//            }

            // Generate unique filename
            $basePath = "properties/{$propertyCode}/{$type}";
            $filename = uniqid('img_').'.'.$file->getClientOriginalExtension();
            $fullPath = storage_path("app/public/{$basePath}/{$filename}");

            // Ensure directory exists
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            $originalImage = clone $image;
            $originalImage->scaleDown(width: $maxWidth, height: $maxHeight);
            $this->addWatermark($originalImage);
            $originalImage->encodeByExtension('jpg', $quality)
                ->save($fullPath);
            $paths = ['original' => "{$basePath}/{$filename}"];

            if ($createSmallVersion) {
                $smallFilename = uniqid('img_') . '_small.' . $file->getClientOriginalExtension();
                $smallPath = storage_path("app/public/{$basePath}/{$smallFilename}");

                $smallImage = clone $image;
                $smallImage->scaleDown(width: 400, height: 300);
                $this->addWatermark($smallImage);
                $smallImage->encodeByExtension('jpg', 70)
                    ->save($smallPath);

                $paths['small'] = "{$basePath}/{$smallFilename}";
            }

            return $paths;
        } catch (\Exception $e) {
            Log::error('Error processing image:', [
                'error' => $e->getMessage(),
                'path' => $paths ?? 'No path available'  // Usar operador de fusión null para evitar errores
            ]);
            throw new \Exception("Error processing image: {$e->getMessage()}");
        }
    }

    /**
     * Add watermark to the image
     */
    private function addWatermark($image): void
    {
        try {

//            Log::info('Ruta del watermark:', [
//                'path' => storage_path('app/public/watermarks/logo.png'),
//                'exists' => file_exists(storage_path('app/public/watermarks/logo.png'))
//            ]);

            $watermarkPath = storage_path('app/public/watermarks/logo.png');
            if (!file_exists($watermarkPath)) {
                Log::error('Watermark file not found:', ['path' => $watermarkPath]);
                throw new \Exception("Watermark file not found");
            }


            // Cargar la imagen de marca de agua
            $watermark = Image::read($watermarkPath);

            $watermark->resize(
                $image->width(),
                $image->height()
            );

//            Log::info('Watermark details:', [
//                'original_width' => $watermark->width(),
//                'original_height' => $watermark->height(),
//                'main_image_width' => $image->width(),
//                'main_image_height' => $image->height()
//            ]);

            // Redimensionar la marca de agua al 20% del ancho de la imagen
//            $watermarkWidth = (int) ($image->width() * 0.20);
//
//            $aspectRatio = $watermark->height() / $watermark->width();
//            $watermarkHeight = (int) ($watermarkWidth * $aspectRatio);
//
//
//            $watermark->resize($watermarkWidth, $watermarkHeight);


//            Log::info('Resized watermark details:', [
//                'new_width' => $watermark->width(),
//                'new_height' => $watermark->height()
//            ]);

            // Calcular posición (esquina inferior derecha con padding)
//            $padding = 20;
            // Añadir la marca de agua con opacidad
            $image->place(
                $watermark,
                'center', // position
                0,            // x offset
                0,            // y offset
//                opacity: 0.6
            );

//            Log::info('Watermark applied:', [
//                'image_dimensions' => [
//                    'width' => $image->width(),
//                    'height' => $image->height()
//                ],
//                'watermark_dimensions' => [
//                    'width' => $watermark->width(),
//                    'height' => $watermark->height()
//                ]
//            ]);

        } catch (\Exception $e) {
            Log::error('Error adding watermark:', [
                'error' => $e->getMessage()
            ]);
            throw new \Exception("Error adding watermark: {$e->getMessage()}");
        }
    }

    /**
     * Process and store multiple property images
     * @throws \Exception
     */
    private function processPropertyImages(array $images, Property $property): void
    {
        $uploadedImages = [];
        $errors = [];

        try {
            foreach ($images as $index => $image) {
                try {
                    // Process each image with specific dimensions for property gallery
                    $paths = $this->handleImage(
                        $image,
                        'images',
                        1200,    // max width for gallery images
                        800,     // max height for gallery images
                        85,      // slightly higher quality for gallery
                        $property->code,
                        true
                    );

                    $uploadedImages[] = new PropertyImage([
                        'name' => $paths['original'],
                    ]);
                } catch (\Exception $e) {
                    // Almacenar error específico para cada imagen
                    $errors[] = "Error en la imagen " . ($index + 1) . ": " . $e->getMessage();

                    // Limpiar las imágenes que se subieron antes del error
                    foreach ($uploadedImages as $uploadedImage) {
                        Storage::disk('public')->delete($uploadedImage->name);
                    }
                }
            }

            if (!empty($errors)) {
                throw new ValidationException(validator([], []), [
                    'images' => $errors
                ]);
            }

            $property->images()->saveMany($uploadedImages);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            // Limpiar cualquier imagen que se haya subido
            foreach ($uploadedImages as $image) {
                Storage::disk('public')->delete($image->name);
                Storage::disk('public')->delete($image->name_small);
            }

            throw new \Exception('Error procesando imágenes: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug): View
    {
        $cities = City::select(['id', 'name'])->get();
        $propertyTypes = PropertyType::select(['id', 'type_name'])->get();
        $serviceTypes = ServiceType::select(['id', 'name'])->get();
        $agents = User::select(['id', 'name'])->where('role', 'agent')->get();
        $features = Facility::select(['id', 'name'])->get();
        $amenities = Amenity::select(['id', 'name'])->get();

        // Cargar la propiedad con todas sus relaciones
        $property = Property::with(['amenities', 'facilities', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        $projects = Property::select(['id', 'name'])
            ->where('is_project', true)
            ->where('id', '!=', $property->id) // Excluir la propiedad actual
            ->get();

        return view('backend.properties.edit', compact(
            'property',
            'cities',
            'propertyTypes',
            'serviceTypes',
            'agents',
            'features',
            'amenities',
            'projects'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Property $property): RedirectResponse
    {
        try {
            Log::info('Iniciando update en PropertyController para la propiedad ' . $property->id);

            // Obtener datos validados
            $validated = $request->validated();
            Log::info('Datos validados:', ['validated' => $validated]);

            return DB::transaction(function () use ($request, $property, $validated) {
                try {
                    // 1. Filtrar solo los campos que pertenecen a la tabla properties
                    $propertyData = array_intersect_key($validated, array_flip([
                        'name', 'address', 'neighborhood_id', 'size', 'size_max',
                        'city', 'country', 'propertytype_id', 'service_type_id',
                        'currency', 'chosen_currency', 'lowest_price', 'max_price',
                        'bedrooms', 'bathrooms', 'garage', 'garage_size',
                        'short_description', 'long_description', 'latitude', 'longitude',
                        'video', 'featured', 'hot', 'agent_id', 'status', 'is_project',
                        'units', 'project_id'
                    ]));

                    // 2. Actualizar los datos básicos de la propiedad
                    $property->update($propertyData);
                    Log::info('Datos básicos de la propiedad actualizados');

                    // 3. Procesar las relaciones usando el método mejorado
                    $this->processRelationsUpdate($property, $validated);
                    Log::info('Relaciones procesadas');

                    // 4. Procesar imágenes
                    $this->handleImagesUpdate($property, $request);

                    flash()->success('Propiedad actualizada satisfactoriamente.');
                    Log::info('Proceso de actualización completado con éxito');

                    return redirect()->route('backend.properties.index');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error en la actualización:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            });

        } catch (\Exception $e) {
            Log::error('Error actualizando propiedad:', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);

            flash()->warning('Ocurrió un error al actualizar la propiedad: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Procesar relaciones para la actualización (método nuevo)
     */
    private function processRelationsUpdate(Property $property, array $validated): void
    {
        // Sincronizar facilities si existen
        if (!empty($validated['features']) && is_array($validated['features'])) {
            $facilityData = [];

            foreach ($validated['features'] as $index => $featureId) {
                // Solo procesar si el featureId no está vacío y es numérico
                if (!empty($featureId) && is_numeric($featureId) && $featureId > 0) {
                    $facilityData[$featureId] = [
                        'name' => $validated['place_names'][$index] ?? '',
                        'distance' => $validated['distances'][$index] ?? ''
                    ];
                }
            }

            $property->facilities()->sync($facilityData);
        } else {
            // Si no hay features válidos, limpiar todas las relaciones
            $property->facilities()->sync([]);
        }

        // Sincronizar amenities si existen
        if (!empty($validated['amenities']) && is_array($validated['amenities'])) {
            // Filtrar amenities válidos
            $validAmenities = array_filter($validated['amenities'], function($amenityId) {
                return !empty($amenityId) && is_numeric($amenityId) && $amenityId > 0;
            });

            $property->amenities()->sync($validAmenities);
        } else {
            // Si no hay amenities válidos, limpiar todas las relaciones
            $property->amenities()->sync([]);
        }
    }

    /**
     * Método específico para manejar las imágenes durante la actualización
     */
    private function handleImagesUpdate(Property $property, Request $request): void
    {
        // Eliminar thumbnail si se solicita
        if ($request->has('remove_thumbnail') && $request->remove_thumbnail == '1') {
            if ($property->thumbnail && Storage::disk('public')->exists($property->thumbnail)) {
                Storage::disk('public')->delete($property->thumbnail);
            }
            $property->update(['thumbnail' => null]);
        }

        // Procesar nuevo thumbnail
        if ($request->hasFile('thumbnail')) {
            try {
                if ($property->thumbnail && Storage::disk('public')->exists($property->thumbnail)) {
                    Storage::disk('public')->delete($property->thumbnail);
                }

                $thumbnailPaths = $this->handleImage(
                    $request->file('thumbnail'),
                    'thumbnails',
                    800, 600, 80,
                    $property->code,
                    true
                );

                $property->update(['thumbnail' => $thumbnailPaths['original']]);
            } catch (\Exception $e) {
                Log::error('Error procesando thumbnail en actualización:', [
                    'error' => $e->getMessage(),
                    'property_id' => $property->id
                ]);
                throw $e;
            }
        }

        // Eliminar imágenes marcadas para eliminación
        if ($request->has('delete_images') && is_array($request->delete_images)) {
            foreach ($property->images as $index => $image) {
                if (isset($request->delete_images[$index]) && $request->delete_images[$index] == '1') {
                    if (Storage::disk('public')->exists($image->name)) {
                        Storage::disk('public')->delete($image->name);
                    }
                    $image->delete();
                }
            }
        }

        // Procesar imágenes adicionales nuevas
        if ($request->hasFile('images')) {
            try {
                $this->processPropertyImages($request->file('images'), $property);
            } catch (\Exception $e) {
                Log::error('Error procesando imágenes adicionales en actualización:', [
                    'error' => $e->getMessage(),
                    'property_id' => $property->id
                ]);
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $package): RedirectResponse
    {
        try {
            DB::transaction(function () use ($package) {
                $package->delete();
            });
            flash()->success('Paquete borrado satisfactoriamente.');
        } catch (ModelNotFoundException $e) {
            flash()->warning('El paquete no existe.');
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al borrar el paquete: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al borrar el paquete: '.$e->getMessage());
        }

        return redirect()->route('backend.properties.index');
    }
}
