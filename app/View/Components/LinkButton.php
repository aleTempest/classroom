<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LinkButton extends Component
{
    public $href;
    public $color;

    public function __construct($href, $color = 'indigo')
    {
        $this->href = $href;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.link-button');
    }
}
