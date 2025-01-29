<?php

namespace App\Services;

use App\Models\Configuration;
use App\Models\Property;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ConfigurationService
{
    protected $cacheTime = 3600; // 1 hour cache
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * Get menu configuration
     */
    public function getGeneralInfo(): Collection
    {
        return Cache::remember('general_info', $this->cacheTime, function () {
            return Configuration::getConfig('general_info', collect([
                'name' => '',
                'phone' => '',
                'direction' => '',
                'email' => '',
                'attentionHour' => '',
            ]));
        });
    }

    /**
     * Update menu configuration
     */
    public function updateGeneralInfo(array $data): void
    {
        Configuration::setConfig('general_info', $data, 'general');
        Cache::forget('general_info');
    }

    public function getAppearanceSettings(): Collection
    {
        return Cache::remember('appearance_settings', $this->cacheTime, function () {
            return Configuration::getConfig('appearance_settings', collect([
                'logo' => null,
                'logo_internal' => null,
                'favicon' => null,
                'site_name' => '',
                'primary_color' => '#48a640',
                'secondary_color' => '#0dbae8',
                'support_color' => '#f4903f',
            ]));
        });
    }

    public function updateAppearance($request): void
    {

        try {
            $settings = $this->getAppearanceSettings();

            // Handle image uploads
            $images = ['logo', 'logo_internal', 'favicon'];
            foreach ($images as $image) {
                if ($request->hasFile($image)) {
                    try {

                        $oldFile = $settings[$image] ?? null;

                        $settings[$image] = $this->handleImageUpload(
                            $request->file($image),
                            $image,
                            $oldFile ? $oldFile['filename'] : null
                        );
                    } catch (\Exception $e) {
                        Log::error("Error processing {$image}: " . $e->getMessage());
                        throw new \Exception("Error processing {$image}: " . $e->getMessage());
                    }

                }
            }

            // Update other settings
            $settings['site_name'] = $request->site_name;
            $settings['primary_color'] = $request->primary_color;
            $settings['secondary_color'] = $request->secondary_color;
            $settings['support_color'] = $request->support_color;

            // Save all settings
            Configuration::setConfig('appearance_settings', $settings->toArray(), 'appearance');

            // Clear cache
            Cache::forget('appearance_settings');

        } catch (\Exception $e) {
            Log::error('Error in updateAppearance: ' . $e->getMessage());
            throw $e;
        }

    }


    /**
     * Home Slider Methods
     */
    public function getHomeSlider(): Collection
    {
        return Cache::remember('home_slider', $this->cacheTime, function () {
            return Configuration::getConfig('home_slider', collect([
                'slider_ids' => [], // Array of property IDs to show in slider
                'custom_slides' => [],
                'active' => true,   // Whether the slider is active
                'order' => 'desc'   // Order of properties in slider
            ]));
        });
    }

    public function updateHomeSlider($data)
    {

        try {
            Log::debug('Updating slider with data:', $data);

            $settings = [
                'slider_ids' => $data['slider_ids'] ?? [], // Cambiar slider_ids por property_ids
                'custom_slides' => $data['custom_slides'] ?? [],
                'active' => (bool) ($data['active'] ?? true), // Convertir a booleano manualmente
                'order' => $data['order'] ?? 'desc'
            ];

            Configuration::setConfig('home_slider', $settings, 'slider');
            Cache::forget('home_slider');

            return true;
        } catch (\Exception $e) {
            Log::error('Error in updateHomeSlider:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }


    public function getOrderedSlides()
    {
        $settings = $this->getHomeSlider();
        $slides = [];

        // Agregar propiedades
        foreach($settings['slider_ids'] as $propertyId) {
            $property = Property::find($propertyId);
            if($property) {
                $slides[] = [
                    'type' => 'property',
                    'id' => $propertyId,
                    'title' => $property->name,
                    'image' => $property->thumbnail
                ];
            }
        }

        // Agregar slides personalizados
        foreach($settings['custom_slides'] as $index => $slide) {
            $slides[] = [
                'type' => 'custom',
                'id' => $index,
                'title' => $slide['title'],
                'image' => $slide['image']
            ];
        }

        return $slides;
    }

    public function updateSlideOrder(array $order)
    {
        $settings = $this->getHomeSlider();
        $settings['slide_order'] = $order;

        Configuration::setConfig('home_slider', $settings->toArray(), 'slider');
        Cache::forget('home_slider');
    }


    /**
     * Image Handling Methods
     */
    protected function handleImageUpload(UploadedFile $file, string $type, ?string $oldFile = null): array
    {
        $filename = date('YmdHi') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $this->getImagePath($type);


        // Create directory if it doesn't exist
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0755, true);
        }

        // Handle SVG files differently
        if (strtolower($file->getClientOriginalExtension()) === 'svg') {
            $file->move(public_path($path), $filename);
        } else {
            // Process raster images using Intervention Image
            $this->processImage($file, $type)->save(public_path("{$path}/{$filename}"));
        }

        // Delete old file if exists
        if ($oldFile) {
            $this->deleteOldImage($path, $oldFile);
        }

        return [
            'filename' => $filename,
            'path' => "{$path}/{$filename}",
            'url' => asset("{$path}/{$filename}")
        ];
    }

    protected function processImage(UploadedFile $file, string $type)
    {

        $image = Image::read($file);

        switch ($type) {
            case 'logo':
                // For main logo, maintain larger size for better quality
                return $image->scale(width: 800)
                    ->toJpeg(quality: 90); // Higher quality encoding

            case 'logo_internal':
                // Internal logo can be smaller as it's typically used in dashboard
                return $image->scale(width: 400)
                    ->toJpeg(quality: 85);

            case 'favicon':
                // Favicon needs to be small and square
                return $image->coverDown(32, 32)
                    ->toJpeg(quality: 100); // Maximum quality for favicon

            default:
                return $image->scale(width: 1200)
                    ->toJpeg(quality: 80);
        }
    }

    protected function getImagePath(string $type): string
    {
        return "upload/configuration/{$type}";
    }

    protected function deleteOldImage(string $path, string $filename): void
    {
        $oldPath = public_path("{$path}/{$filename}");
        Log::info("Attempting to delete file at: " . $oldPath); // Add logging

        if (file_exists($oldPath)) {
            try {
                unlink($oldPath);
                Log::info("Successfully deleted file: " . $oldPath);
            } catch (\Exception $e) {
                Log::error("Failed to delete file: " . $oldPath . ". Error: " . $e->getMessage());
            }
        } else {
            Log::warning("File not found for deletion: " . $oldPath);
        }
    }

    /**
     * Cache Management Methods
     */
    public function clearAllCaches(): void
    {
        $cacheKeys = [
            'general_info',
            'appearance_settings',
            'theme_settings',
            'accessibility_settings'
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Get all settings for a complete backup
     */
    public function getAllSettings(): Collection
    {
        return collect([
            'general' => $this->getGeneralInfo(),
            'appearance' => $this->getAppearanceSettings(),
            'theme' => $this->getThemeSettings(),
            'accessibility' => $this->getAccessibilitySettings(),
        ]);
    }


    public function listUploadedFiles(): array
    {
        $directories = ['logo', 'logo_internal', 'favicon'];
        $files = [];

        foreach ($directories as $dir) {
            $path = public_path("upload/configuration/{$dir}");
            if (is_dir($path)) {
                $files[$dir] = array_diff(scandir($path), array('.', '..'));
            }
        }

        return $files;
    }

}
