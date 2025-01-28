<?php

namespace App\View\Components;

use Illuminate\View\Component;

class VideosAppLayout extends Component
{
    /**
     * Renderitza el component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.videos-app');
    }
}

