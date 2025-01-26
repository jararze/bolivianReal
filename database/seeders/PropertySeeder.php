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
        $chunks = collect(range(1, 100))->chunk(10);

        foreach ($chunks as $chunk) {
            DB::transaction(function() use ($chunk) {
                foreach ($chunk as $index) {
                    $this->createPropertyWithRelations();
                }
            });
        }
    }

    protected function createPropertyWithRelations()
    {
        // Crear la propiedad
        $property = Property::create($this->generateProperty());

        // Crear imágenes aleatorias (3-5 por propiedad)
        $this->createPropertyImages($property);

        // Crear relaciones con facilities (2-4 por propiedad)
        $this->createFacilities($property);

        // Crear relaciones con amenities (3-6 por propiedad)
        $this->createAmenities($property);

        return $property;
    }

    protected function prepareDefaultImages()
    {
        // Crear directorio si no existe
        $targetPath = storage_path('app/public/properties/thumbnails');
        $imagesPath = storage_path('app/public/properties/images');

        foreach ([$targetPath, $imagesPath] as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
        }

        // Copiar imágenes de ejemplo al storage
        $sourcePath = public_path('assets/front/images/properties');
        $defaultImages = [];

        if (File::exists($sourcePath)) {
            $files = File::files($sourcePath);
            foreach ($files as $file) {
                if (in_array($file->getExtension(), ['jpg', 'jpeg', 'png'])) {
                    // Generar nombres únicos
                    $thumbName = 'thumb_' . Str::random(10) . '.jpg';
                    $imageName = 'img_' . Str::random(10) . '.jpg';

                    // Procesar thumbnail
                    $thumb = Image::read($file)
                        ->scaleDown(width: 800, height: 600)
                        ->toJpeg(80);
                    $thumb->save($targetPath . '/' . $thumbName);

                    // Procesar imagen principal
                    $image = Image::read($file)
                        ->scaleDown(width: 1200, height: 800)
                        ->toJpeg(85);
                    $image->save($imagesPath . '/' . $imageName);

                    $defaultImages[] = [
                        'thumb' => 'properties/thumbnails/' . $thumbName,
                        'image' => 'properties/images/' . $imageName
                    ];
                }
            }
        }

        if (empty($defaultImages)) {
            throw new \Exception('No se encontraron imágenes en: ' . $sourcePath);
        }

        $this->defaultImages = $defaultImages;
    }

    protected function createPropertyImages(Property $property)
    {
        $imageCount = rand(3, 5);

        for ($i = 0; $i < $imageCount; $i++) {
            if (!empty($this->defaultImages)) {
                $randomImage = $this->faker->randomElement($this->defaultImages);

                // Crear registro en property_images
                PropertyImage::create([
                    'property_id' => $property->id,
                    'name' => $randomImage['image'], // Usamos la imagen principal, no el thumbnail
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
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

    protected function generateProperty()
    {
        $isProject = $this->faker->boolean(20);
        $propertyName = $this->generatePropertyName();
        $lowestPrice = $this->faker->numberBetween(50000, 1000000);

        // Seleccionar un thumbnail aleatorio
        $randomImage = $this->faker->randomElement($this->defaultImages);
        $thumbnail = $randomImage['thumb'];

        $maxPossibleAmenities = min(8, count($this->amenities));
        $randomCount = $this->faker->numberBetween(3, $maxPossibleAmenities);
        $amenityIds = $this->faker->randomElements(
            array_map('strval', range(1, 10)),
            $randomCount
        );

        return [
            'name' => $propertyName,
            'slug' => Str::slug($propertyName),
            'code' => $this->generatePropertyCode(),
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
            'thumbnail' => $thumbnail, // Ahora es un string único
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
