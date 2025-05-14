<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\NeighborhoodController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\ServiceTypeController;
use App\Models\Configuration;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

Route::get('/css/theme-dynamic.css', function () {
    try {
        $config = Configuration::where('key', 'appearance_settings')
            ->where('status', true)
            ->first();

        // Convertir el valor a array si es una Collection
        $appearanceSettings = $config ? ($config->value instanceof \Illuminate\Support\Collection
            ? $config->value->toArray()
            : $config->value) : [];

        Log::info('Settings for CSS:', [
            'settings' => $appearanceSettings
        ]);

        return response()
            ->view('css.theme-dynamic', [
                'settings' => $appearanceSettings
            ])
            ->header('Content-Type', 'text/css')
            ->header('Cache-Control', 'public, max-age=3600');

    } catch (\Exception $e) {
        Log::error('CSS Error: ' . $e->getMessage());

        return response(
            ":root {
                --primary-color: #48a640;
                --secondary-color: #0dbae8;
                --support-color: #f4903f;
            }",
            200
        )->header('Content-Type', 'text/css');
    }
})->middleware(['web'])->name('theme.dynamic.css');

Route::get('/api/refresh-random-properties', [HomeController::class, 'refreshRandomProperties']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/property/search', [HomeController::class, 'search'])->name('properties.search');
    Route::get('/property/{id}', [HomeController::class, 'show'])->name('properties.show');
    Route::get('/about/', [HomeController::class, 'about'])->name('about');
    Route::get('/services/', [HomeController::class, 'services'])->name('services');
    Route::get('/promotions/', [HomeController::class, 'promotions'])->name('promotions');
//    Route::get('/properties-front', [PropertyController::class, 'index'])->name('properties_front.index');
//    Route::get('/properties-front/{property}', [PropertyController::class, 'show'])->name('properties_front.show');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
//    Route::get('/contact', [ContactController::class, 'index'])->name('contact');

    Route::get('/submit-property', function () {
        return view('frontend.submit-property');
    })->name('submit-property');

    Route::get('/project', function () {
        return view('frontend.project');
    })->name('project');

    Route::post('/properties/store', [PropertyController::class, 'store'])->name('store');
});

Route::middleware(['auth', 'verified'])->group(function () {


    Route::resource('service-types', ServiceTypeController::class, ['as' => 'backend']);

    Route::resource('property-types', PropertyTypeController::class, ['as' => 'backend']);

    Route::resource('cities', CityController::class, ['as' => 'backend']);

    Route::resource('neighborhood', NeighborhoodController::class, ['as' => 'backend']);

    Route::resource('amenities', AmenityController::class, ['as' => 'backend']);

    Route::resource('facilities', FacilityController::class, ['as' => 'backend']);

    Route::resource('packages', PackageController::class, ['as' => 'backend']);

    Route::resource('properties', PropertyController::class, ['as' => 'backend']);

    Route::get('/api/neighborhoods/by-city/{cityId}', [PropertyController::class, 'getNeighborhoodsByCity']);

    Route::prefix('configurations')->name('backend.configurations.')->group(function () {
        // Main Dashboard
        Route::get('/', [ConfigurationController::class, 'index'])->name('index');

        // General Information
        Route::get('/general', [ConfigurationController::class, 'generalInfo'])->name('general');
        Route::post('/general', [ConfigurationController::class, 'updateGeneralInfo'])->name('general.update');

        // Appearance
        Route::get('/appearance', [ConfigurationController::class, 'appearance'])->name('appearance');
        Route::post('/appearance', [ConfigurationController::class, 'updateAppearance'])->name('appearance.update');

        // Home Slider
        Route::get('/home-slider', [ConfigurationController::class, 'homeSlider'])->name('home-slider');
        Route::post('/home-slider', [ConfigurationController::class, 'updateHomeSlider'])->name('home-slider.update');
        Route::post('/home-slider/upload', [ConfigurationController::class, 'uploadSlideImage'])->name('home-slider.upload');
        Route::get('/home-slider/order', [ConfigurationController::class, 'sliderOrder'])->name('home-slider.order');
        Route::post('/home-slider/order', [ConfigurationController::class, 'updateSliderOrder'])->name('home-slider.updateOrder');

        Route::get('/home-info', [ConfigurationController::class, 'homeInfo'])->name('home');
        Route::post('/home-info', [ConfigurationController::class, 'updateHomeInfo'])->name('home.update');

        // About Us
        Route::get('/about-us', [ConfigurationController::class, 'aboutUs'])->name('about-us');
        Route::post('/about-us', [ConfigurationController::class, 'updateAboutUs'])->name('about-us.update');

        // Social Networks
        Route::get('/social', [ConfigurationController::class, 'social'])->name('social');
        Route::post('/social', [ConfigurationController::class, 'updateSocial'])->name('social.update');

        // Our Reasons
        Route::get('/reasons', [ConfigurationController::class, 'reasons'])->name('reasons');
        Route::post('/reasons', [ConfigurationController::class, 'updateReasons'])->name('reasons.update');

        // Advertising Banners
        Route::get('/advertising', [ConfigurationController::class, 'advertising'])->name('advertising');
        Route::post('/advertising', [ConfigurationController::class, 'updateAdvertising'])->name('advertising.update');
    });

    Route::get('/configuration/files', function(App\Services\ConfigurationService $configService) {
        $files = $configService->listUploadedFiles();
        return view('configuration.files', compact('files'));
    });




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
