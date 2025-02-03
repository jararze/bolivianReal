<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\ConfigurationService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Log;
use App\Http\Requests\Configuration\{UpdateGeneralInfoRequest,
    UpdateAppearanceRequest,
    UpdateHomeInfoRequest,
    UpdateHomeSliderRequest,
    UpdateAboutUsRequest,
    UpdateSocialNetworksRequest,
    UpdateReasonsRequest,
    UpdateAdvertisingRequest};
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

        $properties = Property::select('id', 'name', 'thumbnail')
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('neighborhood', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->orderByRaw("FIELD(id, " . implode(',', array_filter($selectedIds)) . ") DESC")
            ->latest()
            ->paginate(15)
            ->withQueryString();


        return view('backend.configurations.home-slider', [
            'settings' => $settings,
            'properties' => $properties,
        ]);
    }


    public function sliderOrder(): View
    {
        $settings = $this->configService->getHomeSlider();

        $slides = $this->configService->getOrderedSlides();
        return view('backend.configurations.home-slider-order', [
            'settings' => $settings,
            'slides' => $slides
        ]);
    }

    public function updateSliderOrder(Request $request)
    {
        $this->configService->updateSlideOrder($request->slide_order);
        return response()->json(['success' => true]);
    }

    public function uploadSlideImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        try {
            $path = $request->file('image')->store('slider-images', 'public');
            return response()->json([
                'success' => true,
                'url' => Storage::url($path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen'
            ], 500);
        }
    }

    public function updateHomeSlider(UpdateHomeSliderRequest $request): JsonResponse
    {

        try {

            Log::debug('Update Slider Request:', [
                'received_data' => $request->all(),
                'property_ids' => $request->input('property_ids'),
                'custom_slides' => $request->input('custom_slides')
            ]);


            $propertyIds = collect($request->input('property_ids', []))
                ->filter()
                ->map(fn($id) => (string) $id)
                ->values()
                ->toArray();

            $customSlides = collect($request->input('custom_slides', []))
                ->filter()
                ->values()
                ->toArray();

            $settings = [
                'slider_ids' => $propertyIds,
                'custom_slides' => $customSlides,
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

    public function homeInfo(): View
    {
        $data = $this->configService->getHomeInfo();
        return view('backend.configurations.home', ['values' => $data]);
    }

    public function updateHomeInfo(UpdateHomeInfoRequest $request): RedirectResponse
    {
        try {
            $this->configService->updateHomeInfo($request->validated());
            return $this->respondWithSuccess(
                'backend.configurations.home',
                'Información de la página principal actualizada correctamente'
            );
        } catch (\Exception $e) {
            Log::error('Home Info Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar la información: ' . $e->getMessage()]);
        }

    }

    protected function respondWithSuccess(string $route, string $message): RedirectResponse
    {
        return redirect()->route($route)->with('success', $message);
    }


}
