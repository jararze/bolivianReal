<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\ConfigurationService;

use Log;
use App\Http\Requests\Configuration\{
    UpdateGeneralInfoRequest,
    UpdateAppearanceRequest,
    UpdateHomeSliderRequest,
    UpdateAboutUsRequest,
    UpdateSocialNetworksRequest,
    UpdateReasonsRequest,
    UpdateAdvertisingRequest
};
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ConfigurationController extends Controller
{

    protected $configService;

    public function __construct(ConfigurationService $configService)
    {
        $this->configService = $configService;
    }


    public function index(): View
    {
        return view('backend.configurations.index');
    }

    public function generalInfo(): View
    {
        $data = $this->configService->getGeneralInfo();
        return view('backend.configurations.general', ['values' => $data]);
    }

    public function updateGeneralInfo(UpdateGeneralInfoRequest $request): RedirectResponse
    {
        $this->configService->updateGeneralInfo($request->validated());
        return $this->respondWithSuccess('backend.configurations.general',
            'Información general actualizada correctamente');
    }

    public function appearance(): View
    {
        $data = $this->configService->getAppearanceSettings();
        return view('backend.configurations.appearance', ['values' => $data]);
    }

    public function updateAppearance(UpdateAppearanceRequest $request): RedirectResponse
    {
        try {
            Log::info('Appearance Update Request:', $request->all());
            $this->configService->updateAppearance($request);
            return $this->respondWithSuccess('backend.configurations.appearance', 'Apariencia actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Appearance Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar la apariencia: ' . $e->getMessage()]);
        }

    }

    public function homeSlider(): View
    {
        $settings  = $this->configService->getHomeSlider();

        // Get all properties that could be in slider
        $properties = Property::select('id', 'name', 'thumbnail')
            ->latest()
            ->get();

        // Get currently selected properties
        $selectedProperties = Property::whereIn('id', $settings['slider_ids'] ?? [])
            ->select('id', 'name', 'thumbnail')
            ->get();

        return view('backend.configurations.home-slider', [
            'settings' => $settings,
            'properties' => $properties,
            'selectedProperties' => $selectedProperties,
        ]);
    }

    public function updateHomeSlider(UpdateHomeSliderRequest $request): RedirectResponse
    {

        try {
            $this->configService->updateHomeSlider($request);

            return $this->respondWithSuccess('backend.configurations.home-slider',
                'Slider actualizado correctamente');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar el slider: ' . $e->getMessage()]);
        }

    }

    protected function respondWithSuccess(string $route, string $message): RedirectResponse
    {
        return redirect()->route($route)->with('success', $message);
    }


}
