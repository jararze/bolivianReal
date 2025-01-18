<?php

namespace App\Http\Controllers;

use App\Http\Requests\Property\StoreRequest;
use App\Http\Requests\Property\UpdateRequest;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Facility;
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
    public function index(): View
    {
        $properties = Property::with('images')->paginate(20);
        return view('backend.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $cities = City::select(['id', 'name'])->get();
        $propertyTypes = PropertyType::select(['id', 'type_name'])->get();
        $serviceTypes = ServiceType::select(['id', 'name'])->get();
        $agents = User::select(['id', 'name'])->where('role', 'agent')->get();
        $projects = Property::select(['id', 'name'])->where('is_project', true)->get();
        $features = Facility::select(['id', 'name'])->get();
        $amenities = Amenity::select(['id', 'name'])->get();


        return view('backend.properties.create', [
            'cities' => $cities,
            'propertyTypes' => $propertyTypes,
            'serviceTypes' => $serviceTypes,
            'agents' => $agents,
            'projects' => $projects,
            'features' => $features,
            'amenities' => $amenities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Log::channel('daily')->info('Datos recibidos en PropertyController@store:', [
            'all_data' => $request->all(),
            'files' => $request->allFiles()
        ]);
        try {
            $validated = $request->validated();


            Log::info('Datos validados:', ['validated' => $validated]);

            // Preparar los datos para la base de datos
            $propertyData = $this->preparePropertyData($validated);

            // Log los datos preparados
            Log::info('Datos preparados para DB:', ['propertyData' => $propertyData]);

            return DB::transaction(function () use ($request, $propertyData) {
                try {
                    // Create property
                    $property = Property::create($propertyData);
                    Log::info('Propiedad creada:', ['property' => $property->toArray()]);

                    // Procesar relaciones
                    $this->processRelations($property, $request->validated());

                    // Procesar imágenes
                    try {
                        $this->processImages($property, $request);
                    } catch (ValidationException $e) {
                        throw $e;
                    } catch (\Exception $e) {
                        throw new ValidationException(validator([], []), [
                            'images' => [$e->getMessage()]
                        ]);
                    }

                    flash()->success('Propiedad creada satisfactoriamente.');

                    return redirect()->route(
                        $request->action === 'save' ? 'backend.properties.index' : 'backend.properties.create'
                    );
                } catch (ValidationException $e) {
                    DB::rollBack();
                    return back()
                        ->withErrors($e->errors())
                        ->withInput();
                }
            });

        } catch (ValidationException $e) {
            flash()->error('Por favor corrige los errores en el formulario.');
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            Log::error('Database error creating property:', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'user_id' => auth()->id()
            ]);

            flash()->warning('Error al guardar en la base de datos. Por favor, intente nuevamente.');
            return back()->withInput();

        } catch (\Exception $e) {
            Log::error('Error creating property:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            flash()->warning('Ocurrió un error al crear la propiedad. Por favor, intente nuevamente.');
            return back()->withInput();
        }
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

            Log::info('Código generado:', ['code' => $code]);

            // Filtrar solo los campos que van directamente a la tabla properties
            $propertyFields = [
                'name', 'address', 'neighborhood', 'size', 'size_max',
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

            Log::info('Datos de propiedad preparados:', ['propertyData' => $propertyData]);

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
                $thumbnailPath = $this->handleImage(
                    $request->file('thumbnail'),
                    'properties/thumbnails',
                    800,
                    600
                );
                $property->update(['thumbnail' => $thumbnailPath]);
            } catch (\Exception $e) {
                Log::error('Error procesando thumbnail:', [
                    'error' => $e->getMessage(),
                    'property_id' => $property->id
                ]);
                throw $e;
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
                throw $e;
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
     * @return string
     * @throws \Exception
     */
    private function handleImage(
        UploadedFile $file,
        string $path,
        int $maxWidth = 1200,
        int $maxHeight = 1200,
        int $quality = 80
    ): string {
        try {
            // Create image instance
            $image = Image::read($file);

            Log::info('Image Meta Information:', [
                'mime' => $file->getMimeType(),        // e.g. image/jpeg
                'width' => $image->width(),      // original width
                'height' => $image->height(),    // original height
                'original_name' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize()
            ]);

            // Verificar dimensiones mínimas
            if ($image->width() < 800 || $image->height() < 600) {
                throw new \Exception("La imagen debe tener al menos 800x600 píxeles.");
            }

            // Resize image maintaining aspect ratio
            $image->scaleDown(width: $maxWidth, height: $maxHeight);

            $this->addWatermark($image);

            // Generate unique filename
            $filename = uniqid('img_').'.'.$file->getClientOriginalExtension();
            $fullPath = storage_path("app/public/{$path}/{$filename}");

            // Ensure directory exists
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            // Save image with compression
            $image->toJpeg($quality)->save($fullPath);

            return "{$path}/{$filename}";
        } catch (\Exception $e) {
            Log::error('Error processing image:', [
                'error' => $e->getMessage(),
                'path' => $path
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
            // Cargar la imagen de marca de agua
            $watermark = Image::read(storage_path('app/public/watermarks/logo.png'));

            // Redimensionar la marca de agua al 20% del ancho de la imagen
            $watermarkWidth = (int) ($image->width() * 0.20);
            $watermark->scale(width: $watermarkWidth);

            // Calcular posición (esquina inferior derecha con padding)
            $padding = 20;
            // Añadir la marca de agua con opacidad
            $image->place(
                $watermark,
                'bottom-right', // position
                20,            // x offset
                20,            // y offset
                opacity: 0.7   // opacity como named parameter
            );

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
                    $path = $this->handleImage(
                        $image,
                        'properties/images',
                        1200,    // max width for gallery images
                        800,     // max height for gallery images
                        85      // slightly higher quality for gallery
                    );

                    $uploadedImages[] = new PropertyImage(['name' => $path]);
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
            }

            throw new \Exception('Error procesando imágenes: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $package): View
    {
        return view('backend.properties.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Property $package): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $package) {
                $package->update($request->validated());
            });

            flash()->success('Paquete actualizado.');

            return redirect()->route('backend.properties.index');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al actualizar el paquete: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al actualizar el paquete: '.$e->getMessage());
        }

        return back()->withInput();
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
