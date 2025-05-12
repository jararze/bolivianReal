<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RichTextEditor extends Component
{
    public $name;
    public $value;
    public $rows;
    public $placeholder;
    /**
     * Create a new component instance.
     */
    public function __construct($name, $value = '', $rows = 10, $placeholder = '')
    {
        $this->name = $name;
        $this->value = $value;
        $this->rows = $rows;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.rich-text-editor');
    }
}
