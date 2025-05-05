<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\View\View;

class SeriesController extends Controller
{
    /**
     * Mostrar totes les sèries disponibles (públic), amb funcionalitat de cerca.
     */
    public function index(): View
    {
        $search = request('search');

        $series = Serie::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->paginate(6); // 6 sèries per pàgina

        return view('series.index', compact('series'));
    }


    /**
     * Mostrar una sèrie concreta amb els seus vídeos associats.
     */
    public function show(int $id): View
    {
        $serie = Serie::with('videos')->findOrFail($id);

        return view('series.show', compact('serie'));
    }
}
