<?php

namespace App\View\Components\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PropertyGallery extends Component
{

    public $images, $name;

    public function __construct($images, $name = '')
    {
        $this->images = $images;
        $this->name = $name;
    }

    public function render(): View
    {
        return view('components.frontend.property-gallery');
    }
}
