<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\View\View;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:viewAny,App\Models\Serie')->only('index');
        $this->middleware('can:view,serie')->only('show');
    }

    public function index(): View
    {
        $search = request('search');

        $series = Serie::query()
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->paginate(6);

        return view('series.index', compact('series'));
    }

    public function show(Serie $serie): View
    {
        $serie->load('videos');
        return view('series.show', compact('serie'));
    }
}
