<?php

namespace App\View\Components\Frontend;

use App\Models\Property;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Slider extends Component
{
    public $properties;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $sliderConfig = site_config('home_slider');

        if ($sliderConfig && !empty($sliderConfig['slider_ids'])) {
            // Obtener las propiedades basado en los IDs guardados en la configuración
            $this->properties = Property::with(['images', 'propertyType'])
                ->whereIn('id', (array)$sliderConfig['slider_ids'])
                ->where('status', true)
                ->get();
        } else {
            // Fallback: si no hay configuración, mostrar propiedades destacadas
            $this->properties = Property::with(['images', 'propertyType'])
                ->where('status', true)
                ->where('featured', true)
                ->take(1) // Por defecto 1, o podrías hacerlo configurable también
                ->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.slider');
    }
}
