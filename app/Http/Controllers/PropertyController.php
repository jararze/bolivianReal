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
use App\Models\PropertyContract;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContractsExport;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $propertiesTypes = PropertyType::orderBy('type_name', 'ASC')->get();
        $serviceTypes = ServiceType::orderBy('name', 'ASC')->get();
        return view('backend.properties.index', compact('properties', 'propertiesTypes', 'serviceTypes'));
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
            Log::info('🚀 Iniciando store en PropertyController');

            $validated = $request->validated();
            Log::info('✅ Datos validados:', ['validated' => $validated]);

            $propertyData = $this->preparePropertyData($validated);
            Log::info('📋 Datos preparados para DB:', ['propertyData' => $propertyData]);

            return DB::transaction(function () use ($request, $propertyData) {
                try {
                    $property = Property::create($propertyData);
                    Log::info('🏠 Propiedad creada:', ['property' => $property->toArray()]);

                    $this->processRelations($property, $request->validated());
                    Log::info('🔗 Relaciones procesadas');

                    // ========== USAR EL NUEVO MÉTODO CON COMPRESIÓN ==========
                    $this->processImagesWithCompression($property, $request);
                    Log::info('🖼️ Imágenes procesadas con compresión');

                    flash()->success('Propiedad creada satisfactoriamente.');
                    Log::info('🎉 Proceso completado con éxito');

                    return redirect()->route(
                        $request->action === 'save' ? 'backend.properties.index' : 'backend.properties.create'
                    );
                } catch (ValidationException $e) {
                    DB::rollBack();
                    Log::error('❌ Excepción de validación en transacción:', ['errors' => $e->errors()]);
                    return back()->withErrors($e->errors())->withInput();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('❌ Excepción en transacción:', ['message' => $e->getMessage()]);
                    return back()->withError($e->getMessage())->withInput();
                }
            });

        } catch (ValidationException $e) {
            Log::error('❌ Excepción de validación:', ['errors' => $e->errors()]);
            flash()->error('Por favor corrige los errores en el formulario.');
            return back()->withErrors($e->errors())->withInput();
        } catch (QueryException $e) {
            Log::error('❌ Error de base de datos:', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'user_id' => auth()->id()
            ]);

            flash()->warning('Error al guardar en la base de datos. Por favor, intente nuevamente.');
            return back()->withInput();
        } catch (\Exception $e) {
            Log::error('❌ Error creando propiedad:', [
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
                'units', 'project_id', 'service_type_id','currency'
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
        try {
            Log::info('Procesando relaciones para propiedad: ' . $property->id);

            // MEJORA: Sincronizar facilities con validación más robusta
            if (!empty($validated['features']) && is_array($validated['features'])) {
                $facilityData = [];
                $validFeatures = 0;

                foreach ($validated['features'] as $index => $featureId) {
                    // Solo procesar si el featureId es válido
                    if (!empty($featureId) && is_numeric($featureId) && $featureId > 0) {
                        $facilityData[$featureId] = [
                            'name' => $validated['place_names'][$index] ?? '',
                            'distance' => $validated['distances'][$index] ?? ''
                        ];
                        $validFeatures++;
                    }
                }

                if ($validFeatures > 0) {
                    Log::info('Sincronizando facilities', ['valid_features' => $validFeatures]);
                    $property->facilities()->sync($facilityData);
                }
            }

            // MEJORA: Sincronizar amenities con filtrado de valores válidos
            if (!empty($validated['amenities']) && is_array($validated['amenities'])) {
                $validAmenities = array_filter($validated['amenities'], function($amenityId) {
                    return !empty($amenityId) && is_numeric($amenityId) && $amenityId > 0;
                });

                if (count($validAmenities) > 0) {
                    Log::info('Sincronizando amenities', ['count' => count($validAmenities)]);
                    $property->amenities()->sync($validAmenities);
                }
            }

            Log::info('Relaciones procesadas exitosamente');
        } catch (\Exception $e) {
            Log::error('Error procesando relaciones:', [
                'error' => $e->getMessage(),
                'property_id' => $property->id
            ]);
            throw $e;
        }
    }

    private function processImages(Property $property, StoreRequest $request): void
    {
        try {
            Log::info('Iniciando procesamiento de imágenes para propiedad: ' . $property->id);

            // MEJORA: Procesar thumbnail con mejor manejo de errores
            if ($request->hasFile('thumbnail')) {
                try {
                    Log::info('Procesando imagen principal');

                    $thumbnailPaths = $this->handleImage(
                        $request->file('thumbnail'),
                        'thumbnails',
                        800, 600, 80,
                        $property->code,
                        true
                    );

                    $property->update(['thumbnail' => $thumbnailPaths['original']]);
                    Log::info('Imagen principal procesada exitosamente');
                } catch (\Exception $e) {
                    Log::error('Error procesando thumbnail:', [
                        'error' => $e->getMessage(),
                        'property_id' => $property->id
                    ]);
                    throw new \Exception('Error procesando la imagen principal: ' . $e->getMessage());
                }
            }

            // MEJORA: Procesar imágenes adicionales con validación mejorada
            if ($request->hasFile('images')) {
                try {
                    Log::info('Procesando imágenes adicionales', ['count' => count($request->file('images'))]);

                    // Validar límite de imágenes
                    if (count($request->file('images')) > 20) {
                        throw new ValidationException(validator([], []), [
                            'images' => ['No puede subir más de 20 imágenes adicionales.']
                        ]);
                    }

                    $this->processPropertyImages($request->file('images'), $property);
                    Log::info('Imágenes adicionales procesadas exitosamente');
                } catch (ValidationException $e) {
                    throw $e;
                } catch (\Exception $e) {
                    Log::error('Error procesando imágenes adicionales:', [
                        'error' => $e->getMessage(),
                        'property_id' => $property->id
                    ]);
                    throw new \Exception('Error procesando imágenes adicionales: ' . $e->getMessage());
                }
            }

            Log::info('Procesamiento de imágenes completado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error general en processImages:', [
                'error' => $e->getMessage(),
                'property_id' => $property->id
            ]);
            throw $e;
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
     * Process and store multiple property images (MEJORADO)
     * @throws \Exception
     */
    private function processPropertyImages(array $images, Property $property): void
    {
        $uploadedImages = [];
        $errors = [];

        try {
            Log::info('Procesando ' . count($images) . ' imágenes para la propiedad ' . $property->id);

            foreach ($images as $index => $image) {
                try {
                    Log::info('Procesando imagen ' . ($index + 1) . ': ' . $image->getClientOriginalName());

                    // MEJORA: Validaciones más estrictas
                    if (!$image->isValid()) {
                        throw new \Exception('Archivo no válido');
                    }

                    if (!str_starts_with($image->getMimeType(), 'image/')) {
                        throw new \Exception('El archivo no es una imagen válida');
                    }

                    // MEJORA: Validar tamaño de archivo (5MB máximo)
                    if ($image->getSize() > 5242880) { // 5MB en bytes
                        throw new \Exception('La imagen no puede ser mayor a 5MB');
                    }

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

                    Log::info('Imagen procesada exitosamente: ' . $paths['original']);
                } catch (\Exception $e) {
                    // MEJORA: Almacenar error específico para cada imagen con más detalle
                    $errorMsg = "Error en la imagen " . ($index + 1) . " (" . $image->getClientOriginalName() . "): " . $e->getMessage();
                    $errors[] = $errorMsg;
                    Log::error($errorMsg);

                    // Limpiar las imágenes que se subieron antes del error
                    foreach ($uploadedImages as $uploadedImage) {
                        if (Storage::disk('public')->exists($uploadedImage->name)) {
                            Storage::disk('public')->delete($uploadedImage->name);
                        }
                    }

                    break; // Salir del bucle si hay error
                }
            }

            if (!empty($errors)) {
                throw new ValidationException(validator([], []), [
                    'images' => $errors
                ]);
            }

            // Guardar todas las imágenes en la base de datos
            if (!empty($uploadedImages)) {
                $property->images()->saveMany($uploadedImages);
                Log::info('Se guardaron ' . count($uploadedImages) . ' imágenes en la base de datos');
            }

        } catch (ValidationException $e) {
            Log::error('Errores de validación en imágenes:', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            // Limpiar cualquier imagen que se haya subido
            foreach ($uploadedImages as $image) {
                if (Storage::disk('public')->exists($image->name)) {
                    Storage::disk('public')->delete($image->name);
                }
            }

            Log::error('Error general procesando imágenes:', ['error' => $e->getMessage()]);
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
            Log::info('🚀 Iniciando update CON COMPRESIÓN en PropertyController para la propiedad ' . $property->id);

            // Obtener datos validados
            $validated = $request->validated();
            Log::info('✅ Datos validados:', ['validated' => $validated]);

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
                    Log::info('📝 Datos básicos de la propiedad actualizados');

                    // 3. Procesar las relaciones
                    $this->processRelationsUpdate($property, $validated);
                    Log::info('🔗 Relaciones procesadas');

                    // 4. ========== USAR EL NUEVO MÉTODO CON COMPRESIÓN ==========
                    $this->handleImagesUpdateWithCompression($property, $request);

                    flash()->success('Propiedad actualizada satisfactoriamente.');
                    Log::info('🎉 Proceso de actualización completado con éxito');

                    return redirect()->route('backend.properties.index');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('❌ Error en la actualización:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            });

        } catch (\Exception $e) {
            Log::error('❌ Error actualizando propiedad:', [
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
     * Método mejorado para manejar las imágenes durante la actualización
     */
    private function handleImagesUpdate(Property $property, Request $request): void
    {
        try {
            Log::info('Iniciando actualización de imágenes para propiedad: ' . $property->id);

            // MEJORA: Eliminar thumbnail con mejor logging
            if ($request->has('remove_thumbnail') && $request->remove_thumbnail == '1') {
                Log::info('Eliminando thumbnail actual');
                if ($property->thumbnail && Storage::disk('public')->exists($property->thumbnail)) {
                    Storage::disk('public')->delete($property->thumbnail);
                    Log::info('Archivo de thumbnail eliminado: ' . $property->thumbnail);
                }
                $property->update(['thumbnail' => null]);
            }

            // MEJORA: Procesar nuevo thumbnail con rollback en caso de error
            if ($request->hasFile('thumbnail')) {
                try {
                    Log::info('Procesando nuevo thumbnail');
                    $oldThumbnail = $property->thumbnail;

                    $thumbnailPaths = $this->handleImage(
                        $request->file('thumbnail'),
                        'thumbnails',
                        800, 600, 80,
                        $property->code,
                        true
                    );

                    // Solo eliminar el anterior después de que el nuevo se procese exitosamente
                    if ($oldThumbnail && Storage::disk('public')->exists($oldThumbnail)) {
                        Storage::disk('public')->delete($oldThumbnail);
                    }

                    $property->update(['thumbnail' => $thumbnailPaths['original']]);
                    Log::info('Thumbnail actualizado exitosamente');
                } catch (\Exception $e) {
                    Log::error('Error procesando nuevo thumbnail:', [
                        'error' => $e->getMessage(),
                        'property_id' => $property->id
                    ]);
                    throw $e;
                }
            }

            // MEJORA: Eliminar imágenes existentes con mejor validación
            if ($request->has('delete_images') && is_array($request->delete_images)) {
                Log::info('Procesando eliminación de imágenes existentes', ['delete_images' => $request->delete_images]);

                foreach ($request->delete_images as $imageId => $shouldDelete) {
                    if ($shouldDelete == '1') {
                        Log::info('Eliminando imagen con ID: ' . $imageId);

                        $image = $property->images()->where('id', $imageId)->first();
                        if ($image) {
                            // Eliminar archivos físicos
                            if (Storage::disk('public')->exists($image->name)) {
                                Storage::disk('public')->delete($image->name);
                                Log::info('Archivo físico eliminado: ' . $image->name);
                            }

                            // Eliminar registro de la base de datos
                            $image->delete();
                            Log::info('Registro de imagen eliminado de BD');
                        } else {
                            Log::warning('Imagen con ID ' . $imageId . ' no encontrada');
                        }
                    }
                }
            }

            // MEJORA: Procesar nuevas imágenes adicionales con límite
            if ($request->hasFile('images')) {
                try {
                    Log::info('Procesando nuevas imágenes adicionales', ['count' => count($request->file('images'))]);

                    // Validar límite total de imágenes
                    $currentImageCount = $property->images()->count();
                    $newImageCount = count($request->file('images'));

                    if (($currentImageCount + $newImageCount) > 25) {
                        throw new ValidationException(validator([], []), [
                            'images' => ['No puede tener más de 25 imágenes en total. Actualmente tiene ' . $currentImageCount . ' imágenes.']
                        ]);
                    }

                    $this->processPropertyImages($request->file('images'), $property);
                    Log::info('Nuevas imágenes procesadas exitosamente');
                } catch (ValidationException $e) {
                    throw $e;
                } catch (\Exception $e) {
                    Log::error('Error procesando nuevas imágenes:', [
                        'error' => $e->getMessage(),
                        'property_id' => $property->id
                    ]);
                    throw $e;
                }
            }

            Log::info('Actualización de imágenes completada exitosamente');
        } catch (\Exception $e) {
            Log::error('Error general en handleImagesUpdate:', [
                'error' => $e->getMessage(),
                'property_id' => $property->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property): RedirectResponse
    {
        try {
            DB::transaction(function () use ($property) {
                $property->delete();
            });
            flash()->success('Propiedad satisfactoriamente.');
        } catch (ModelNotFoundException $e) {
            flash()->warning('La Propiedad no existe.');
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al borrar el paquete: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al borrar el paquete: '.$e->getMessage());
        }

        return redirect()->route('backend.properties.index');
    }





    /**
     * Handle image upload with intelligent compression
     * Versión mejorada que comprime automáticamente si excede 2MB
     */
    private function handleImageWithCompression(
        UploadedFile $file,
        string $type,
        int $maxWidth = 1200,
        int $maxHeight = 1200,
        int $quality = 85,
        string $propertyCode = '',
        bool $createSmallVersion = false
    ): array {
        $paths = [];
        $maxSizeMB = 2; // 2MB máximo
        $maxSizeBytes = $maxSizeMB * 1024 * 1024;

        try {
            Log::info("📷 Procesando imagen: {$file->getClientOriginalName()}", [
                'size_original' => $this->formatBytes($file->getSize()),
                'max_allowed' => $this->formatBytes($maxSizeBytes)
            ]);

            // Create image instance
            $image = Image::read($file);

            // Generate paths
            $basePath = "properties/{$propertyCode}/{$type}";
            $filename = uniqid('img_').'.'.$file->getClientOriginalExtension();
            $fullPath = storage_path("app/public/{$basePath}/{$filename}");

            // Ensure directory exists
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            // ========== COMPRESIÓN INTELIGENTE ==========
            $originalImage = clone $image;

            // Redimensionar si es necesario (mantener tu lógica)
            $originalImage->scaleDown(width: $maxWidth, height: $maxHeight);

            // Agregar watermark (mantener tu lógica)
            $this->addWatermark($originalImage);

            // ========== NUEVA LÓGICA DE COMPRESIÓN ==========
            $finalQuality = $this->calculateOptimalQuality($file, $originalImage, $quality, $maxSizeBytes);

            // Guardar imagen principal
            $originalImage->encodeByExtension('jpg', $finalQuality)->save($fullPath);
            $paths['original'] = "{$basePath}/{$filename}";

            $finalSize = filesize($fullPath);
            Log::info("✅ Imagen principal guardada", [
                'path' => $paths['original'],
                'quality_used' => $finalQuality,
                'size_final' => $this->formatBytes($finalSize),
                'compression_ratio' => round((1 - $finalSize / $file->getSize()) * 100, 1) . '%'
            ]);

            // ========== VERSIÓN PEQUEÑA (SI SE SOLICITA) ==========
            if ($createSmallVersion) {
                $smallFilename = uniqid('img_') . '_small.' . $file->getClientOriginalExtension();
                $smallPath = storage_path("app/public/{$basePath}/{$smallFilename}");

                $smallImage = clone $image;
                $smallImage->scaleDown(width: 400, height: 300);
                $this->addWatermark($smallImage);

                // Para versión pequeña, usar calidad más baja
                $smallQuality = max(60, $finalQuality - 15);
                $smallImage->encodeByExtension('jpg', $smallQuality)->save($smallPath);

                $paths['small'] = "{$basePath}/{$smallFilename}";

                Log::info("✅ Versión pequeña guardada", [
                    'path' => $paths['small'],
                    'quality_used' => $smallQuality,
                    'size_final' => $this->formatBytes(filesize($smallPath))
                ]);
            }

            return $paths;

        } catch (\Exception $e) {
            Log::error('❌ Error processing image:', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            throw new \Exception("Error processing image: {$e->getMessage()}");
        }
    }

    /**
     * Calcular calidad óptima para mantener el archivo bajo el límite de tamaño
     */
    private function calculateOptimalQuality($originalFile, $processedImage, int $initialQuality, int $maxSizeBytes): int
    {
        $tempPath = storage_path('app/temp_quality_test.jpg');
        $quality = $initialQuality;
        $attempts = 0;
        $maxAttempts = 5;

        try {
            // Si el archivo original ya es pequeño, usar calidad inicial
            if ($originalFile->getSize() <= $maxSizeBytes) {
                Log::info("📦 Archivo original dentro del límite, usando calidad inicial: {$quality}%");
                return $quality;
            }

            Log::info("🔄 Calculando calidad óptima...");

            do {
                $attempts++;

                // Guardar temporalmente con la calidad actual
                $testImage = clone $processedImage;
                $testImage->encodeByExtension('jpg', $quality)->save($tempPath);

                $testSize = filesize($tempPath);

                Log::info("🎯 Prueba {$attempts}: Calidad {$quality}%, Tamaño: {$this->formatBytes($testSize)}");

                // Si está dentro del límite o llegamos al límite de intentos
                if ($testSize <= $maxSizeBytes || $attempts >= $maxAttempts || $quality <= 30) {
                    break;
                }

                // Reducir calidad para siguiente intento
                $quality = max(30, $quality - 15);

            } while ($quality > 30);

            // Limpiar archivo temporal
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }

            Log::info("✅ Calidad óptima calculada: {$quality}%");
            return $quality;

        } catch (\Exception $e) {
            // Limpiar archivo temporal en caso de error
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }

            Log::warning("⚠️ Error calculando calidad óptima, usando calidad por defecto: {$initialQuality}%");
            return $initialQuality;
        }
    }

    /**
     * Formatear bytes a formato legible
     */
    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1024 * 1024) {
            return round($bytes / (1024 * 1024), 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }

    /**
     * Versión mejorada de processImages que usa compresión inteligente
     */
    private function processImagesWithCompression(Property $property, StoreRequest $request): void
    {
        try {
            Log::info('🚀 Iniciando procesamiento de imágenes con compresión para propiedad: ' . $property->id);

            // ========== PROCESAR THUMBNAIL ==========
            if ($request->hasFile('thumbnail')) {
                try {
                    Log::info('📸 Procesando imagen principal con compresión');

                    $thumbnailPaths = $this->handleImageWithCompression(
                        $request->file('thumbnail'),
                        'thumbnails',
                        800, 600, 85, // Calidad inicial más alta
                        $property->code,
                        true
                    );

                    $property->update(['thumbnail' => $thumbnailPaths['original']]);
                    Log::info('✅ Imagen principal procesada exitosamente');
                } catch (\Exception $e) {
                    Log::error('❌ Error procesando thumbnail:', [
                        'error' => $e->getMessage(),
                        'property_id' => $property->id
                    ]);
                    throw new \Exception('Error procesando la imagen principal: ' . $e->getMessage());
                }
            }

            // ========== PROCESAR IMÁGENES ADICIONALES ==========
            if ($request->hasFile('images')) {
                try {
                    Log::info('🖼️ Procesando imágenes adicionales con compresión', [
                        'count' => count($request->file('images'))
                    ]);

                    // Validar límite de imágenes
                    if (count($request->file('images')) > 20) {
                        throw new ValidationException(validator([], []), [
                            'images' => ['No puede subir más de 20 imágenes adicionales.']
                        ]);
                    }

                    $this->processPropertyImagesWithCompression($request->file('images'), $property);
                    Log::info('✅ Imágenes adicionales procesadas exitosamente');
                } catch (ValidationException $e) {
                    throw $e;
                } catch (\Exception $e) {
                    Log::error('❌ Error procesando imágenes adicionales:', [
                        'error' => $e->getMessage(),
                        'property_id' => $property->id
                    ]);
                    throw new \Exception('Error procesando imágenes adicionales: ' . $e->getMessage());
                }
            }

            Log::info('🎉 Procesamiento de imágenes completado exitosamente');
        } catch (\Exception $e) {
            Log::error('❌ Error general en processImagesWithCompression:', [
                'error' => $e->getMessage(),
                'property_id' => $property->id
            ]);
            throw $e;
        }
    }


    /**
     * Procesar múltiples imágenes con compresión inteligente y orden preservado
     * CORREGIDO: Sin tocar la base de datos, solo orden en nombres de archivo
     */
    private function processPropertyImagesWithCompression(array $images, Property $property): void
    {
        $uploadedImages = [];
        $errors = [];

        try {
            Log::info("🔄 Procesando {count} imágenes con compresión y orden en nombre", ['count' => count($images)]);

            foreach ($images as $index => $image) {
                try {
                    $originalName = $image->getClientOriginalName();
                    Log::info("📷 Procesando imagen " . ($index + 1) . ": {$originalName}");

                    // Validaciones (mantener tu lógica existente)
                    if (!$image->isValid()) {
                        throw new \Exception('Archivo no válido');
                    }

                    if (!str_starts_with($image->getMimeType(), 'image/')) {
                        throw new \Exception('El archivo no es una imagen válida');
                    }

                    if ($image->getSize() > 10485760) { // 10MB inicial (se comprimirá a 2MB)
                        throw new \Exception('La imagen no puede ser mayor a 10MB');
                    }

                    // ========== EXTRAER ORDEN DEL NOMBRE ==========
                    $orderNumber = $this->extractOrderFromFilename($originalName);

                    // ========== USAR COMPRESIÓN INTELIGENTE CON ORDEN ==========
                    $paths = $this->handleImageWithCompressionAndOrder(
                        $image,
                        'images',
                        1200,    // max width para galería
                        800,     // max height para galería
                        85,      // calidad inicial
                        $property->code,
                        $orderNumber,
                        true
                    );

                    // ========== SOLO GUARDAR EL PATH - SIN ORDER_NUMBER ==========
                    $uploadedImages[] = new PropertyImage([
                        'name' => $paths['original'],
                        // NO incluir order_number - solo usar el nombre del archivo
                    ]);

                    Log::info("✅ Imagen procesada exitosamente: {$paths['original']} (Orden en nombre: {$orderNumber})");

                } catch (\Exception $e) {
                    $errorMsg = "Error en la imagen " . ($index + 1) . " ({$originalName}): " . $e->getMessage();
                    $errors[] = $errorMsg;
                    Log::error("❌ " . $errorMsg);

                    // Limpiar imágenes subidas antes del error
                    foreach ($uploadedImages as $uploadedImage) {
                        if (Storage::disk('public')->exists($uploadedImage->name)) {
                            Storage::disk('public')->delete($uploadedImage->name);
                        }
                    }
                    break;
                }
            }

            if (!empty($errors)) {
                throw new ValidationException(validator([], []), [
                    'images' => $errors
                ]);
            }

            // Guardar todas las imágenes en la base de datos (SOLO name y property_id)
            if (!empty($uploadedImages)) {
                $property->images()->saveMany($uploadedImages);
                Log::info("💾 Se guardaron " . count($uploadedImages) . " imágenes con orden preservado en nombres de archivo");
            }

        } catch (ValidationException $e) {
            Log::error('❌ Errores de validación en imágenes:', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            // Limpiar cualquier imagen que se haya subido
            foreach ($uploadedImages as $image) {
                if (Storage::disk('public')->exists($image->name)) {
                    Storage::disk('public')->delete($image->name);
                }
            }

            Log::error('❌ Error general procesando imágenes:', ['error' => $e->getMessage()]);
            throw new \Exception('Error procesando imágenes: ' . $e->getMessage());
        }
    }

    /**
     * Extraer número de orden del nombre del archivo
     */
    private function extractOrderFromFilename(string $filename): int
    {
        // Buscar patrón como "01_", "02_", etc. al inicio del nombre
        if (preg_match('/^(\d{2})_/', $filename, $matches)) {
            return (int) $matches[1];
        }

        // Si no encuentra patrón, devolver 999 para que vaya al final
        return 999;
    }


    /**
     * Handle image upload with compression and order preservation
     */
    private function handleImageWithCompressionAndOrder(
        UploadedFile $file,
        string $type,
        int $maxWidth = 1200,
        int $maxHeight = 1200,
        int $quality = 85,
        string $propertyCode = '',
        int $orderNumber = 1,
        bool $createSmallVersion = false
    ): array {
        $paths = [];
        $maxSizeMB = 2; // 2MB máximo
        $maxSizeBytes = $maxSizeMB * 1024 * 1024;

        try {
            // Limpiar el nombre original del archivo (quitar el prefijo de orden)
            $originalName = $file->getClientOriginalName();
            $cleanName = preg_replace('/^\d{2}_/', '', $originalName);

            Log::info("📷 Procesando imagen con orden en nombre: {$originalName} -> Orden: {$orderNumber}", [
                'clean_name' => $cleanName,
                'size_original' => $this->formatBytes($file->getSize()),
            ]);

            // Create image instance
            $image = Image::read($file);

            // Generate paths con el orden en el nombre del archivo
            $basePath = "properties/{$propertyCode}/{$type}";
            $orderPrefix = str_pad($orderNumber, 2, '0', STR_PAD_LEFT);
            $extension = pathinfo($cleanName, PATHINFO_EXTENSION) ?: 'jpg';
            $nameWithoutExt = pathinfo($cleanName, PATHINFO_FILENAME);

            // Crear nombre final: 01_imagen_original.jpg
            $filename = $orderPrefix . '_' . Str::slug($nameWithoutExt) . '_' . uniqid() . '.' . $extension;
            $fullPath = storage_path("app/public/{$basePath}/{$filename}");

            // Ensure directory exists
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            // ========== COMPRESIÓN INTELIGENTE ==========
            $originalImage = clone $image;

            // Redimensionar si es necesario
            $originalImage->scaleDown(width: $maxWidth, height: $maxHeight);

            // Agregar watermark
            $this->addWatermark($originalImage);

            // Calcular calidad óptima
            $finalQuality = $this->calculateOptimalQuality($file, $originalImage, $quality, $maxSizeBytes);

            // Guardar imagen principal
            $originalImage->encodeByExtension('jpg', $finalQuality)->save($fullPath);
            $paths['original'] = "{$basePath}/{$filename}";

            $finalSize = filesize($fullPath);
            Log::info("✅ Imagen principal guardada con orden en nombre", [
                'path' => $paths['original'],
                'order_in_filename' => $orderNumber,
                'quality_used' => $finalQuality,
                'size_final' => $this->formatBytes($finalSize),
                'compression_ratio' => round((1 - $finalSize / $file->getSize()) * 100, 1) . '%'
            ]);

            // ========== VERSIÓN PEQUEÑA (SI SE SOLICITA) ==========
            if ($createSmallVersion) {
                $smallFilename = $orderPrefix . '_' . Str::slug($nameWithoutExt) . '_' . uniqid() . '_small.' . $extension;
                $smallPath = storage_path("app/public/{$basePath}/{$smallFilename}");

                $smallImage = clone $image;
                $smallImage->scaleDown(width: 400, height: 300);
                $this->addWatermark($smallImage);

                // Para versión pequeña, usar calidad más baja
                $smallQuality = max(60, $finalQuality - 15);
                $smallImage->encodeByExtension('jpg', $smallQuality)->save($smallPath);

                $paths['small'] = "{$basePath}/{$smallFilename}";

                Log::info("✅ Versión pequeña guardada con orden en nombre", [
                    'path' => $paths['small'],
                    'order_in_filename' => $orderNumber,
                    'quality_used' => $smallQuality,
                    'size_final' => $this->formatBytes(filesize($smallPath))
                ]);
            }

            return $paths;

        } catch (\Exception $e) {
            Log::error('❌ Error processing image with order in filename:', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'order' => $orderNumber
            ]);
            throw new \Exception("Error processing image: {$e->getMessage()}");
        }
    }


    /**
     * Método mejorado para manejar las imágenes durante la actualización CON COMPRESIÓN
     */
    private function handleImagesUpdateWithCompression(Property $property, Request $request): void
    {
        try {
            Log::info('🚀 Iniciando actualización de imágenes CON COMPRESIÓN Y REORDENAMIENTO para propiedad: ' . $property->id);

            // ========== ELIMINAR THUMBNAIL ==========
            if ($request->has('remove_thumbnail') && $request->remove_thumbnail == '1') {
                Log::info('🗑️ Eliminando thumbnail actual');
                if ($property->thumbnail && Storage::disk('public')->exists($property->thumbnail)) {
                    Storage::disk('public')->delete($property->thumbnail);
                    Log::info('✅ Archivo de thumbnail eliminado: ' . $property->thumbnail);
                }
                $property->update(['thumbnail' => null]);
            }

            // ========== PROCESAR NUEVO THUMBNAIL CON COMPRESIÓN ==========
            if ($request->hasFile('thumbnail')) {
                try {
                    Log::info('📸 Procesando nuevo thumbnail con compresión');
                    $oldThumbnail = $property->thumbnail;

                    $thumbnailPaths = $this->handleImageWithCompression(
                        $request->file('thumbnail'),
                        'thumbnails',
                        800, 600, 85, // Calidad inicial más alta
                        $property->code,
                        true
                    );

                    // Solo eliminar el anterior después de que el nuevo se procese exitosamente
                    if ($oldThumbnail && Storage::disk('public')->exists($oldThumbnail)) {
                        Storage::disk('public')->delete($oldThumbnail);
                        Log::info('🗑️ Thumbnail anterior eliminado: ' . $oldThumbnail);
                    }

                    $property->update(['thumbnail' => $thumbnailPaths['original']]);
                    Log::info('✅ Thumbnail actualizado exitosamente con compresión');
                } catch (\Exception $e) {
                    Log::error('❌ Error procesando nuevo thumbnail:', [
                        'error' => $e->getMessage(),
                        'property_id' => $property->id
                    ]);
                    throw $e;
                }
            }

            // ========== REORDENAR IMÁGENES EXISTENTES ==========
            if ($request->has('image_orders') && is_array($request->image_orders)) {
                Log::info('🔄 Procesando reordenamiento de imágenes existentes');
                $this->reorderExistingImages($property, $request->image_orders);
            }

            // ========== ELIMINAR IMÁGENES EXISTENTES ==========
            if ($request->has('delete_images') && is_array($request->delete_images)) {
                Log::info('🗑️ Procesando eliminación de imágenes existentes', [
                    'delete_images' => array_filter($request->delete_images, fn($val) => $val == '1')
                ]);

                foreach ($request->delete_images as $imageId => $shouldDelete) {
                    if ($shouldDelete == '1') {
                        Log::info('🗑️ Eliminando imagen con ID: ' . $imageId);

                        $image = $property->images()->where('id', $imageId)->first();
                        if ($image) {
                            // Eliminar archivos físicos
                            if (Storage::disk('public')->exists($image->name)) {
                                Storage::disk('public')->delete($image->name);
                                Log::info('✅ Archivo físico eliminado: ' . $image->name);
                            }

                            // Eliminar registro de la base de datos
                            $image->delete();
                            Log::info('✅ Registro de imagen eliminado de BD');
                        } else {
                            Log::warning('⚠️ Imagen con ID ' . $imageId . ' no encontrada');
                        }
                    }
                }
            }

            // ========== PROCESAR NUEVAS IMÁGENES ADICIONALES CON COMPRESIÓN ==========
            if ($request->hasFile('images')) {
                try {
                    Log::info('🖼️ Procesando nuevas imágenes adicionales con compresión', [
                        'count' => count($request->file('images'))
                    ]);

                    // Validar límite total de imágenes
                    $currentImageCount = $property->images()->count();
                    $newImageCount = count($request->file('images'));

                    if (($currentImageCount + $newImageCount) > 25) {
                        throw new ValidationException(validator([], []), [
                            'images' => ['No puede tener más de 25 imágenes en total. Actualmente tiene ' . $currentImageCount . ' imágenes.']
                        ]);
                    }

                    $this->processPropertyImagesWithCompression($request->file('images'), $property);
                    Log::info('✅ Nuevas imágenes procesadas exitosamente con compresión');
                } catch (ValidationException $e) {
                    throw $e;
                } catch (\Exception $e) {
                    Log::error('❌ Error procesando nuevas imágenes:', [
                        'error' => $e->getMessage(),
                        'property_id' => $property->id
                    ]);
                    throw $e;
                }
            }

            Log::info('🎉 Actualización de imágenes completada exitosamente con compresión y reordenamiento');
        } catch (\Exception $e) {
            Log::error('❌ Error general en handleImagesUpdateWithCompression:', [
                'error' => $e->getMessage(),
                'property_id' => $property->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    private function reorderExistingImages(Property $property, array $imageOrders): void
    {
        try {
            Log::info('🔄 Iniciando reordenamiento de imágenes existentes');

            foreach ($imageOrders as $imageId => $newOrder) {
                $image = $property->images()->where('id', $imageId)->first();

                if (!$image) {
                    Log::warning("⚠️ Imagen con ID {$imageId} no encontrada para reordenar");
                    continue;
                }

                $currentPath = $image->name;
                $currentFilename = basename($currentPath);
                $directory = dirname($currentPath);

                // Extraer el orden actual del nombre
                $currentOrder = $this->extractOrderFromImageName($currentPath);

                if ($currentOrder == $newOrder) {
                    Log::info("✅ Imagen {$imageId} ya tiene el orden correcto: {$newOrder}");
                    continue;
                }

                // Crear nuevo nombre con el nuevo orden
                $newFilename = $this->generateNewOrderedFilename($currentFilename, $newOrder);
                $newPath = $directory . '/' . $newFilename;

                // Verificar que los archivos existan antes de renombrar
                $currentFullPath = storage_path('app/public/' . $currentPath);
                $newFullPath = storage_path('app/public/' . $newPath);

                if (!file_exists($currentFullPath)) {
                    Log::warning("⚠️ Archivo físico no encontrado: {$currentFullPath}");
                    continue;
                }

                // Renombrar archivo físico
                if (rename($currentFullPath, $newFullPath)) {
                    // Actualizar en la base de datos
                    $image->update(['name' => $newPath]);

                    Log::info("✅ Imagen reordenada exitosamente:", [
                        'image_id' => $imageId,
                        'old_order' => $currentOrder,
                        'new_order' => $newOrder,
                        'old_path' => $currentPath,
                        'new_path' => $newPath
                    ]);
                } else {
                    Log::error("❌ Error renombrando archivo físico:", [
                        'from' => $currentFullPath,
                        'to' => $newFullPath
                    ]);
                }
            }

            Log::info('🎉 Reordenamiento de imágenes completado');
        } catch (\Exception $e) {
            Log::error('❌ Error en reordenamiento de imágenes:', [
                'error' => $e->getMessage(),
                'property_id' => $property->id
            ]);
            throw $e;
        }
    }

    /**
     * Generar nuevo nombre de archivo con el orden especificado
     */
    private function generateNewOrderedFilename(string $currentFilename, int $newOrder): string
    {
        // Remover el prefijo de orden actual si existe
        $cleanFilename = preg_replace('/^\d{2}_/', '', $currentFilename);

        // Agregar nuevo prefijo de orden
        $orderPrefix = str_pad($newOrder, 2, '0', STR_PAD_LEFT);

        return $orderPrefix . '_' . $cleanFilename;
    }

    /**
     * Extraer orden del nombre de archivo guardado (método mejorado)
     */
    private function extractOrderFromImageName(string $imagePath): int
    {
        $filename = basename($imagePath);

        // Buscar patrón como "01_", "02_", etc. al inicio del nombre
        if (preg_match('/^(\d{2})_/', $filename, $matches)) {
            return (int) $matches[1];
        }

        // Si no encuentra patrón, devolver 999 para que vaya al final
        return 999;
    }

    public function lastPhase(): View
    {
        $properties = Property::with([
            'propertyType',
            'citys',
            'images',
            'activeContract',
            'contracts' => function($query) {
                $query->latest();
            }
        ])->orderBy('created_at', 'DESC')->get();

        // Estadísticas
        $stats = [
            'active' => Property::where('market_status', 'active')->count(),
            'off_market' => Property::where('market_status', 'off_market')->count(),
            'with_contracts' => Property::withActiveContracts()->count(),
            'expiring_soon' => Property::withExpiringContracts(3)->count(),
        ];

        return view('backend.lastPhase.index', compact('properties', 'stats'));
    }

    /**
     * Sacar propiedad del mercado
     */
    public function offMarket(Request $request, Property $property): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'off_market_reason' => 'required|in:sold,rented,anticretico,owner_decision,other',
                'off_market_notes' => 'nullable|string|max:1000',
                'off_market_date' => 'nullable|date',
            ]);

            $property->update([
                'market_status' => 'off_market',
                'off_market_reason' => $validated['off_market_reason'],
                'off_market_notes' => $validated['off_market_notes'] ?? null,
                'off_market_date' => $validated['off_market_date'] ?? now(),
            ]);

            Log::info('Propiedad sacada del mercado:', [
                'property_id' => $property->id,
                'property_name' => $property->name,
                'reason' => $validated['off_market_reason'],
                'user_id' => auth()->id()
            ]);

            flash()->success('Propiedad sacada del mercado exitosamente.');
            return redirect()->route('backend.properties.lastPhase.index');

        } catch (ValidationException $e) {
            flash()->error('Error en los datos proporcionados.');
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error sacando propiedad del mercado:', [
                'error' => $e->getMessage(),
                'property_id' => $property->id,
                'user_id' => auth()->id()
            ]);

            flash()->error('Ocurrió un error al sacar la propiedad del mercado.');
            return back()->withInput();
        }
    }

    /**
     * Reactivar propiedad
     */
    public function reactivate(Property $property): RedirectResponse
    {
        try {
            $property->update([
                'market_status' => 'active',
                'off_market_reason' => null,
                'off_market_notes' => null,
                'off_market_date' => null,
                'status' => true,
            ]);

            Log::info('Propiedad reactivada:', [
                'property_id' => $property->id,
                'property_name' => $property->name,
                'user_id' => auth()->id()
            ]);

            flash()->success('Propiedad reactivada exitosamente.');
            return redirect()->route('backend.properties.lastPhase.index');

        } catch (\Exception $e) {
            Log::error('Error reactivando propiedad:', [
                'error' => $e->getMessage(),
                'property_id' => $property->id,
                'user_id' => auth()->id()
            ]);

            flash()->error('Ocurrió un error al reactivar la propiedad.');
            return back();
        }
    }

    /**
     * Guardar o actualizar contrato
     */
    public function saveContract(Request $request, Property $property): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'contract_id' => 'nullable|exists:property_contracts,id',
                'contract_type' => 'required|in:rent,anticretico',
                'start_date' => 'required|date',
                'duration_months' => 'required|integer|min:1|max:120',
                'end_date' => 'nullable|date|after:start_date',
                'amount' => 'nullable|numeric|min:0',
                'currency' => 'required|in:Bs,$us',
                'tenant_name' => 'nullable|string|max:255',
                'tenant_phone' => 'nullable|string|max:50',
                'tenant_email' => 'nullable|email|max:255',
                'tenant_ci' => 'nullable|string|max:50',
                'tenant_address' => 'nullable|string|max:500',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Calcular fecha de fin si no se proporcionó
            if (empty($validated['end_date'])) {
                $startDate = \Carbon\Carbon::parse($validated['start_date']);
                $validated['end_date'] = $startDate->copy()
                    ->addMonths($validated['duration_months'])
                    ->format('Y-m-d');
            }

            // Si existe contract_id, actualizar; sino, crear
            if (!empty($validated['contract_id'])) {
                $contract = PropertyContract::findOrFail($validated['contract_id']);

                // Resetear alertas si se actualizan las fechas
                if ($contract->end_date != $validated['end_date']) {
                    $validated['alert_3months_sent'] = false;
                    $validated['alert_3months_sent_at'] = null;
                    $validated['alert_1month_sent'] = false;
                    $validated['alert_1month_sent_at'] = null;
                    $validated['alert_1week_sent'] = false;
                    $validated['alert_1week_sent_at'] = null;
                }

                unset($validated['contract_id']);
                $contract->update($validated);

                $message = 'Contrato actualizado exitosamente.';
                $action = 'updated';
            } else {
                unset($validated['contract_id']);
                $validated['property_id'] = $property->id;
                $validated['status'] = 'active';

                $contract = PropertyContract::create($validated);

                $message = 'Contrato creado exitosamente.';
                $action = 'created';
            }

            Log::info('Contrato guardado:', [
                'action' => $action,
                'contract_id' => $contract->id,
                'property_id' => $property->id,
                'property_name' => $property->name,
                'contract_type' => $validated['contract_type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'user_id' => auth()->id()
            ]);

            flash()->success($message);
            return redirect()->route('backend.properties.lastPhase.index');

        } catch (ValidationException $e) {
            flash()->error('Error en los datos proporcionados.');
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error guardando contrato:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'property_id' => $property->id,
                'user_id' => auth()->id()
            ]);

            flash()->error('Ocurrió un error al guardar el contrato.');
            return back()->withInput();
        }
    }

    /**
     * Eliminar contrato
     */
    public function deleteContract(PropertyContract $contract): RedirectResponse
    {
        try {
            $propertyName = $contract->property->name;
            $contractId = $contract->id;

            $contract->delete();

            Log::info('Contrato eliminado:', [
                'contract_id' => $contractId,
                'property_id' => $contract->property_id,
                'property_name' => $propertyName,
                'user_id' => auth()->id()
            ]);

            flash()->success('Contrato eliminado exitosamente.');
            return redirect()->route('backend.properties.lastPhase.index');

        } catch (\Exception $e) {
            Log::error('Error eliminando contrato:', [
                'error' => $e->getMessage(),
                'contract_id' => $contract->id ?? 'unknown',
                'user_id' => auth()->id()
            ]);

            flash()->error('Ocurrió un error al eliminar el contrato.');
            return back();
        }
    }

    /**
     * Renovar contrato
     */
    public function renewContract(Request $request, PropertyContract $contract): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'start_date' => 'required|date', // ← Simplificado
                'duration_months' => 'required|integer|min:1|max:120',
                'amount' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Crear el nuevo contrato usando el método renew del modelo
            $newContract = $contract->renew($validated);

            Log::info('Contrato renovado:', [
                'old_contract_id' => $contract->id,
                'new_contract_id' => $newContract->id,
                'property_id' => $contract->property_id,
                'property_name' => $contract->property->name,
                'user_id' => auth()->id()
            ]);

            flash()->success('Contrato renovado exitosamente. Nuevo contrato #' . $newContract->id . ' creado.');
            return redirect()->route('backend.contracts.show', $newContract);

        } catch (ValidationException $e) {
            flash()->error('Error en los datos proporcionados.');
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error renovando contrato:', [
                'error' => $e->getMessage(),
                'contract_id' => $contract->id,
                'user_id' => auth()->id()
            ]);

            flash()->error('Ocurrió un error al renovar el contrato: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Terminar contrato anticipadamente
     */
    public function terminateContract(Request $request, PropertyContract $contract): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'termination_reason' => 'required|string|max:1000',
                'termination_date' => 'nullable|date|before_or_equal:today',
            ]);

            $terminationDate = $validated['termination_date'] ?? now();

            // Actualizar el contrato
            $contract->update([
                'status' => 'terminated',
                'notes' => $contract->notes . "\n\n--- TERMINADO ANTICIPADAMENTE ---\n" .
                    "Fecha: " . $terminationDate . "\n" .
                    "Motivo: " . $validated['termination_reason'] . "\n" .
                    "Terminado por: " . auth()->user()->name,
            ]);

            Log::info('Contrato terminado:', [
                'contract_id' => $contract->id,
                'property_id' => $contract->property_id,
                'property_name' => $contract->property->name,
                'reason' => $validated['termination_reason'],
                'user_id' => auth()->id()
            ]);

            flash()->success('Contrato terminado exitosamente.');
            return redirect()->route('backend.contracts.show', $contract);

        } catch (ValidationException $e) {
            flash()->error('Error en los datos proporcionados.');
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error terminando contrato:', [
                'error' => $e->getMessage(),
                'contract_id' => $contract->id,
                'user_id' => auth()->id()
            ]);

            flash()->error('Ocurrió un error al terminar el contrato.');
            return back();
        }
    }

    /**
     * Vista principal - Todos los contratos
     */
    public function contractsIndex(Request $request): View
    {
        $query = PropertyContract::with(['property.propertyType', 'property.citys'])
            ->orderBy('created_at', 'DESC');

        // Filtros opcionales
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('contract_type')) {
            $query->where('contract_type', $request->contract_type);
        }

        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('end_date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tenant_name', 'LIKE', "%{$search}%")
                    ->orWhere('tenant_ci', 'LIKE', "%{$search}%")
                    ->orWhereHas('property', function($q2) use ($search) {
                        $q2->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('code', 'LIKE', "%{$search}%");
                    });
            });
        }

        $contracts = $query->paginate(15)->withQueryString();

        // Estadísticas
        $stats = [
            'total' => PropertyContract::count(),
            'active' => PropertyContract::active()->count(),
            'expired' => PropertyContract::expired()->count(),
            'expiring_soon' => PropertyContract::expiringIn(3)->count(),
            'rent' => PropertyContract::where('contract_type', 'rent')->count(),
            'anticretico' => PropertyContract::where('contract_type', 'anticretico')->count(),
        ];

        // Propiedades para filtro
        $properties = Property::select(['id', 'name', 'code'])
            ->orderBy('name')
            ->get();

        return view('backend.contracts.index', compact('contracts', 'stats', 'properties'));
    }

    /**
     * Reportes filtrados por tipo
     */
    public function contractsReport(Request $request, string $type): View
    {
        $query = PropertyContract::with(['property.propertyType', 'property.citys']);

        switch ($type) {
            case 'active':
                $query->active();
                $title = 'Contratos Activos';
                break;

            case 'expiring':
                $query->expiringIn(3);
                $title = 'Contratos por Vencer (3 meses)';
                break;

            case 'expired':
                $query->expired();
                $title = 'Contratos Vencidos';
                break;

            case 'rent':
                $query->rent()->active();
                $title = 'Contratos de Alquiler';
                break;

            case 'anticretico':
                $query->anticretico()->active();
                $title = 'Contratos de Anticrético';
                break;

            default:
                abort(404);
        }

        $contracts = $query->orderBy('end_date', 'asc')->paginate(20);

        return view('backend.contracts.report', compact('contracts', 'title', 'type'));
    }

    /**
     * Vista de alertas de vencimiento
     */
    public function contractsAlerts(): View
    {
        // Contratos que vencen en 3 meses
        $expiring3Months = PropertyContract::expiringIn(3)
            ->where('alert_3months_sent', false)
            ->with(['property'])
            ->orderBy('end_date', 'asc')
            ->get();

        // Contratos que vencen en 1 mes
        $expiring1Month = PropertyContract::expiringIn(1)
            ->where('alert_1month_sent', false)
            ->with(['property'])
            ->orderBy('end_date', 'asc')
            ->get();

        // Contratos que vencen en 1 semana
        $expiring1Week = PropertyContract::with(['property'])
            ->where('status', 'active')
            ->whereDate('end_date', '<=', now()->addWeek())
            ->whereDate('end_date', '>=', now())
            ->where('alert_1week_sent', false)
            ->orderBy('end_date', 'asc')
            ->get();

        // Contratos ya vencidos
        $expired = PropertyContract::expired()
            ->with(['property'])
            ->orderBy('end_date', 'desc')
            ->take(10)
            ->get();

        return view('backend.contracts.alerts', compact(
            'expiring3Months',
            'expiring1Month',
            'expiring1Week',
            'expired'
        ));
    }

    /**
     * Exportar contratos
     */
    public function contractsExport(Request $request, string $format)
    {
        $query = PropertyContract::with(['property.propertyType', 'property.citys']);

        // Aplicar filtros si vienen en la URL
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('contract_type')) {
            $query->where('contract_type', $request->contract_type);
        }

        if ($request->filled('type')) {
            switch ($request->type) {
                case 'active':
                    $query->active();
                    break;
                case 'expiring':
                    $query->expiringIn(3);
                    break;
                case 'expired':
                    $query->expired();
                    break;
            }
        }

        $contracts = $query->orderBy('created_at', 'DESC')->get();

        switch ($format) {
            case 'excel':
                return Excel::download(
                    new ContractsExport($contracts),
                    'contratos_' . date('Y-m-d') . '.xlsx'
                );

            case 'csv':
                return Excel::download(
                    new ContractsExport($contracts),
                    'contratos_' . date('Y-m-d') . '.csv',
                    \Maatwebsite\Excel\Excel::CSV
                );

            case 'pdf':
                $pdf = Pdf::loadView('backend.contracts.pdf', compact('contracts'));
                return $pdf->download('contratos_' . date('Y-m-d') . '.pdf');

            default:
                abort(404);
        }
    }

    /**
     * Ver detalles de un contrato específico
     */
    public function contractShow(PropertyContract $contract): View
    {
        $contract->load([
            'property.propertyType',
            'property.citys',
            'property.images',
            'createdBy',
            'updatedBy',
            'renewedFrom',
            'renewedTo'
        ]);

        return view('backend.contracts.show', compact('contract'));
    }


}
