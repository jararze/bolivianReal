<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\ServiceTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {


    Route::resource('service-types', ServiceTypeController::class, ['as' => 'backend']);

    Route::resource('property-types', PropertyTypeController::class, ['as' => 'backend']);

    Route::resource('cities', CityController::class, ['as' => 'backend']);

    Route::resource('amenities', AmenityController::class, ['as' => 'backend']);

    Route::resource('facilities', FacilityController::class, ['as' => 'backend']);

    Route::resource('packages', PackageController::class, ['as' => 'backend']);

    Route::resource('properties', PropertyController::class, ['as' => 'backend']);

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
