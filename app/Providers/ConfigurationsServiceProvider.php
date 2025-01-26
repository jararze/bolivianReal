<?php

namespace App\Providers;

use App\Models\Configuration;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class ConfigurationsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $configurations = Cache::remember('site_configurations', now()->addHours(24), function () {
                return [
                    'general' => Configuration::where('key', 'general_info')->first()?->value ?? [],
                    'appearance' => Configuration::where('key', 'appearance_settings')->first()?->value ?? [],
                    // Puedes agregar más configuraciones aquí
                ];
            });

            $view->with('configs', $configurations);
        });
    }
}
