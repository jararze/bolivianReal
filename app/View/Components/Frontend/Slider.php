<?php

namespace App\View\Components\Frontend;

use App\Models\Property;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Slider extends Component
{
    public $slides;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $settings = site_config('home_slider');
        $this->slides = [];

        if (!empty($settings['slide_order'])) {
            // Seguir el orden definido
            foreach ($settings['slide_order'] as $item) {
                if ($item['type'] === 'property' && in_array($item['id'], $settings['slider_ids'])) {
                    $property = Property::find($item['id']);
                    if ($property) {
                        $this->slides[] = ['type' => 'property', 'data' => $property];
                    }
                } elseif ($item['type'] === 'custom') {
                    $customSlide = collect($settings['custom_slides'])->get($item['id']);
                    if ($customSlide) {
                        $this->slides[] = ['type' => 'custom', 'data' => $customSlide];
                    }
                }
            }
        } else {
            // Mantener el orden original si no hay slide_order
            if (!empty($settings['slider_ids'])) {
                foreach ($settings['slider_ids'] as $id) {
                    $property = Property::find($id);
                    if ($property) {
                        $this->slides[] = ['type' => 'property', 'data' => $property];
                    }
                }
            }

            if (!empty($settings['custom_slides'])) {
                foreach ($settings['custom_slides'] as $slide) {
                    $this->slides[] = ['type' => 'custom', 'data' => $slide];
                }
            }
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
