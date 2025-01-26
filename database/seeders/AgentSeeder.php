<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AgentSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Preparar directorio para fotos
        $targetPath = storage_path('app/public/agents');
        if (!File::exists($targetPath)) {
            File::makeDirectory($targetPath, 0755, true);
        }

        // Lista de títulos de trabajo realistas para agentes inmobiliarios
        $jobTitles = [
            'Asesor Inmobiliario Senior',
            'Agente de Bienes Raíces',
            'Consultor Inmobiliario',
            'Especialista en Propiedades de Lujo',
            'Asesor de Inversiones Inmobiliarias',
            'Agente Comercial Senior',
            'Especialista en Desarrollo Urbano',
            'Consultor de Propiedades Residenciales',
            'Asesor de Proyectos Inmobiliarios',
            'Director de Ventas Inmobiliarias'
        ];

        for ($i = 0; $i < 10; $i++) {
            $name = $this->faker->firstName;
            $lastname = $this->faker->lastName;

            // Copiar una imagen de ejemplo al storage (ajusta la ruta según tus imágenes)
            $photoName = 'agent_' . Str::random(10) . '.jpg';
            $sourcePath = public_path('assets/front/images/agents/default.jpg');
            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $targetPath . '/' . $photoName);
            }

            User::create([
                'name' => $name,
                'lastname' => $lastname,
                'jobtitle' => $this->faker->randomElement($jobTitles),
                'username' => strtolower($name . '.' . $lastname),
                'email' => strtolower($name . '.' . $lastname . '@tudominio.com'),
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Contraseña por defecto
                'photo' => 'agents/' . $photoName,
                'phone' => $this->faker->numerify('+591 #### ####'),
                'address' => $this->faker->streetAddress,
                'city' => $this->faker->randomElement(['Santa Cruz', 'La Paz', 'Cochabamba']),
                'country' => 'Bolivia',
                'aboutme' => $this->generateAboutMe(),
                'package_id' => 1,
                'package_status' => 'active',
                'role' => 'agent',
                'status' => 'active',
                'remember_token' => Str::random(10),
            ]);
        }


    }

    protected function generateAboutMe()
    {
        $experience = $this->faker->numberBetween(3, 15);
        $specialties = $this->faker->randomElements([
            'propiedades residenciales',
            'inmuebles comerciales',
            'terrenos',
            'desarrollos inmobiliarios',
            'propiedades de lujo',
            'condominios',
            'oficinas',
            'locales comerciales'
        ], 3);

        return "Profesional inmobiliario con {$experience} años de experiencia en el mercado boliviano. " .
            "Especializado en " . implode(', ', $specialties) . ". " .
            "Comprometido con brindar el mejor servicio y asesoramiento a mis clientes, " .
            "ayudándoles a encontrar la propiedad perfecta que se ajuste a sus necesidades y objetivos. " .
            $this->faker->paragraph();
    }
}
