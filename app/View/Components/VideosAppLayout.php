<?php

namespace App\View\Components;

use Illuminate\View\Component;

class VideosAppLayout extends Component
{
    /**
     * Renderitza la vista del layout.
     */
    public function render()
    {
        return view('layouts.videos-app');
    }
}
