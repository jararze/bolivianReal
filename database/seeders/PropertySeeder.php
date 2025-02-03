<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\ServiceType;
use App\Models\User;
use App\Models\PropertyImage;
use App\Models\Facility;
use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Intervention\Image\Laravel\Facades\Image;
class PropertySeeder extends Seeder
{
    protected $faker;
    protected $propertyTypes;
    protected $serviceTypes;
    protected $agents;
    protected $defaultImages;
    protected $facilities;
    protected $amenities;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cargar datos necesarios una sola vez
        $this->propertyTypes = PropertyType::pluck('id')->toArray();
        $this->serviceTypes = ServiceType::pluck('id')->toArray();
        $this->agents = User::where('role', 'agent')->pluck('id')->toArray();
        $this->facilities = Facility::pluck('id')->toArray();
        $this->amenities = Amenity::pluck('id')->toArray();

        // Preparar imágenes por defecto
        $this->prepareDefaultImages();

        // Crear propiedades en chunks para mejor rendimiento
        $chunks = collect(range(1, 200))->chunk(10);

        foreach ($chunks as $chunk) {
            DB::transaction(function() use ($chunk) {
                foreach ($chunk as $index) {
                    $this->createPropertyWithRelations();
                }
            });
        }
    }

    protected function prepareDefaultImages()
    {
        // Copiar imágenes de ejemplo al storage
        $sourcePath = public_path('assets/front/images/properties');
        $defaultImages = [];

        if (File::exists($sourcePath)) {
            $files = collect(File::files($sourcePath))
                ->filter(fn($file) => in_array($file->getExtension(), ['jpg', 'jpeg', 'png']));

            foreach ($files as $file) {
                $defaultImages[] = [
                    'path' => $file->getPathname(),
                    'extension' => $file->getExtension()
                ];
            }
        }

        if (empty($defaultImages)) {
            throw new \Exception('No se encontraron imágenes en: ' . $sourcePath);
        }

        $this->defaultImages = $defaultImages;
    }

    protected function createPropertyWithRelations()
    {
        $propertyCode = $this->generatePropertyCode();
        $propertyData = $this->generateProperty($propertyCode);
        $property = Property::create($propertyData);

        // Crear imágenes aleatorias (3-5 por propiedad)
        $this->createPropertyImages($property);

        // Crear relaciones con facilities (2-4 por propiedad)
        $this->createFacilities($property);

        // Crear relaciones con amenities (3-6 por propiedad)
        $this->createAmenities($property);

        return $property;
    }

    protected function processImage($sourcePath, $type, $maxWidth, $maxHeight, $quality, $propertyCode)
    {
        $image = Image::read($sourcePath);

        // Generate base path and filename
        $basePath = "properties/{$propertyCode}/{$type}";
        $filename = uniqid('img_') . '.jpg';
        $fullPath = storage_path("app/public/{$basePath}/{$filename}");

        // Ensure directory exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Process image
        $processedImage = clone $image;
        $processedImage->scaleDown(width: $maxWidth, height: $maxHeight);

        // Add watermark
        $watermarkPath = storage_path('app/public/watermarks/logo.png');
        if (file_exists($watermarkPath)) {
            $watermark = Image::read($watermarkPath);
            $watermark->resize($processedImage->width(), $processedImage->height());
            $processedImage->place($watermark, 'center', 0, 0);
        }

        // Save image
        $processedImage->encodeByExtension('jpg', $quality)->save($fullPath);

        // Create small version
        $smallFilename = uniqid('img_') . '_small.jpg';
        $smallPath = storage_path("app/public/{$basePath}/{$smallFilename}");

        $smallImage = clone $image;
        $smallImage->scaleDown(width: 400, height: 300);
        if (file_exists($watermarkPath)) {
            $watermark = Image::read($watermarkPath);
            $watermark->resize($smallImage->width(), $smallImage->height());
            $smallImage->place($watermark, 'center', 0, 0);
        }
        $smallImage->encodeByExtension('jpg', 70)->save($smallPath);

        return [
            'original' => "{$basePath}/{$filename}",
            'small' => "{$basePath}/{$smallFilename}"
        ];
    }



    protected function createPropertyImages(Property $property)
    {
        // Verificar si tenemos imágenes por defecto
        if (empty($this->defaultImages)) {
            throw new \Exception('No hay imágenes por defecto disponibles');
        }

        $imageCount = rand(3, 5);
        $selectedImages = $this->faker->randomElements($this->defaultImages, $imageCount);

        $firstImage = $selectedImages[0];
        $thumbnailPaths = $this->processImage(
            $firstImage['path'],
            'thumbnails',
            800,
            600,
            80,
            $property->code
        );

        $property->update(['thumbnail' => $thumbnailPaths['original']]);

        foreach ($selectedImages as $image) {
            $paths = $this->processImage(
                $image['path'],
                'images',
                1200,
                800,
                85,
                $property->code
            );

            PropertyImage::create([
                'property_id' => $property->id,
                'name' => $paths['original'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    protected function createFacilities(Property $property)
    {
        // Obtener el número mínimo entre el número deseado y el disponible
        $maxPossibleFacilities = count($this->facilities);
        $facilityCount = min(rand(2, 4), $maxPossibleFacilities);

        // Seleccionar facilities aleatorios
        $selectedFacilities = $this->faker->randomElements(
            $this->facilities,
            $facilityCount
        );

        foreach ($selectedFacilities as $facilityId) {
            DB::table('facility_properties')->insert([
                'property_id' => $property->id,
                'facility_id' => $facilityId,
                'name' => $this->faker->word,
                'distance' => $this->faker->numberBetween(1, 10) . ' km',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    protected function createAmenities(Property $property)
    {
        // Obtener el número mínimo entre el número deseado y el disponible
        $maxPossibleAmenities = count($this->amenities);
        $amenityCount = min(rand(3, 6), $maxPossibleAmenities);

        // Seleccionar amenities aleatorios
        $selectedAmenities = $this->faker->randomElements(
            $this->amenities,
            $amenityCount
        );

        foreach ($selectedAmenities as $amenityId) {
            DB::table('amenity_property')->insert([
                'property_id' => $property->id,
                'amenity_id' => $amenityId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    protected function generatePropertyCode()
    {
        return IdGenerator::generate([
            'table' => 'properties',
            'field' => 'code',
            'length' => 10,
            'prefix' => 'P' . date('ym')
        ]);
    }

    protected function generateProperty($propertyCode)
    {
        $isProject = $this->faker->boolean(20);
        $propertyName = $this->generatePropertyName();
        $lowestPrice = $this->faker->numberBetween(50000, 1000000);

        // Seleccionar un thumbnail aleatorio
//        $randomImage = $this->faker->randomElement($this->defaultImages);
//        $thumbnail = $randomImage['thumb'];

        $maxPossibleAmenities = min(8, count($this->amenities));
        $randomCount = $this->faker->numberBetween(3, $maxPossibleAmenities);
        $amenityIds = $this->faker->randomElements(
            array_map('strval', range(1, 10)),
            $randomCount
        );

        return [
            'name' => $propertyName,
            'slug' => Str::slug($propertyName),
            'code' => $propertyCode,
            'is_project' => $isProject,
            'service_type_id' => $this->faker->randomElement($this->serviceTypes),
            'project_id' => $isProject ? null : $this->faker->optional(0.3)->randomNumber(3),
            'project_status' => $isProject ? $this->faker->randomElement(['En planos', 'En construcción', 'Próxima entrega']) : null,
            'delivery' => $isProject ? $this->faker->dateTimeBetween('+6 months', '+2 years') : null,
            'units' => $isProject ? $this->faker->numberBetween(10, 100) : null,
            'construction_Date' => $isProject ? $this->faker->dateTimeBetween('-1 year', '+1 year') : null,
            'lowest_price' => $lowestPrice,
            'max_price' => $this->faker->optional(0.7)->numberBetween($lowestPrice, $lowestPrice * 1.5),
            'currency' => $this->faker->randomElement(['$us', 'Bs']),
//            'thumbnail' => $thumbnail, // Ahora es un string único
            'short_description' => $this->faker->paragraph(),
            'long_description' => $this->faker->paragraphs(3, true),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bedrooms_max' => $this->faker->optional(0.3)->numberBetween(2, 6),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'bathrooms_max' => $this->faker->optional(0.3)->numberBetween(2, 5),
            'garage' => $this->faker->numberBetween(0, 3),
            'garage_max' => $this->faker->optional(0.3)->numberBetween(1, 4),
            'garage_size' => $this->faker->optional()->randomFloat(2, 15, 30),
            'garage_size_max' => $this->faker->optional()->randomFloat(2, 20, 35),
            'size' => $this->faker->randomFloat(2, 60, 500),
            'size_max' => $this->faker->optional(0.3)->randomFloat(2, 80, 600),
            'video' => $this->faker->optional(0.1)->url,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->randomElement([1, 2, 3, 4]), // Ahora es un ID de ciudad
            'country' => 'Bolivia',
            'neighborhood' => $this->faker->optional(0.8)->word,
            'latitude' => $this->faker->latitude(-17.7, -17.8),
            'longitude' => $this->faker->longitude(-63.1, -63.2),
            'featured' => $this->faker->boolean(10),
            'hot' => $this->faker->boolean(5),
            'propertytype_id' => $this->faker->randomElement($this->propertyTypes),
            'amenities_id' => json_encode($amenityIds),
            'agent_id' => $this->faker->randomElement($this->agents),
            'created_by' => 1,
            'status' => $this->faker->boolean(80),
            'status_for_what' => $this->faker->numberBetween(0, 2),
            'chosen_currency' => true,
            'sold_units' => $isProject ? $this->faker->numberBetween(0, 50) : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    protected function generatePropertyName()
    {
        $types = ['Casa', 'Departamento', 'Terreno', 'Local Comercial', 'Oficina'];
        $locations = ['Norte', 'Sur', 'Este', 'Oeste', 'Centro'];
        $features = ['Moderna', 'Exclusiva', 'Amplia', 'Lujosa', 'Familiar'];

        return $this->faker->randomElement($types) . ' ' .
            $this->faker->randomElement($features) . ' en ' .
            $this->faker->randomElement($locations);
    }
}
