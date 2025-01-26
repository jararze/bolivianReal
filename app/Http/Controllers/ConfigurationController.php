<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\ConfigurationService;

use Illuminate\Support\Facades\Cache;
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
            Cache::forget('appearance_settings');
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
        $settings = $this->configService->getHomeSlider();
        $search = request('search');
        $selectedIds = $settings['slider_ids'] ?? [];

//        dd($selectedIds);

        $properties = Property::select('id', 'name', 'thumbnail')
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('neighborhood', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            // Ordenar seleccionados primero
            ->orderByRaw("FIELD(id, " . implode(',', array_filter($selectedIds)) . ") DESC")
            ->latest()
            ->paginate(25)
            ->withQueryString();


        return view('backend.configurations.home-slider', [
            'settings' => $settings,
            'properties' => $properties,
        ]);
    }

    public function updateHomeSlider(UpdateHomeSliderRequest $request): \Illuminate\Http\JsonResponse
    {

        try {

            Log::debug('Update Slider Request:', [
                'received_data' => $request->all(),
                'property_ids' => $request->input('property_ids')
            ]);


            $propertyIds = collect($request->input('property_ids', []))
                ->filter()
                ->map(function($id) {
                    return (string) $id; // Asegurar que todos son strings
                })
                ->values()
                ->toArray();

            $settings = [
                'slider_ids' => $propertyIds,
                'active' => $request->boolean('active', true),
                'order' => $request->input('order', 'desc')
            ];

            Log::debug('Settings to save:', $settings);

            $this->configService->updateHomeSlider($settings);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Error updating slider:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el slider: ' . $e->getMessage()
            ], 500);
        }

    }

    protected function respondWithSuccess(string $route, string $message): RedirectResponse
    {
        return redirect()->route($route)->with('success', $message);
    }


}
