<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VideosController extends Controller
{
    public function __construct()
    {
        // Només usuaris autenticats poden accedir a les rutes de gestió
        $this->middleware('auth')->only([
            'create', 'store', 'edit', 'update', 'destroy', 'manageIndex'
        ]);

        // Permís per veure un vídeo concret
        $this->middleware('can:view videos')->only('show');

        // Permís per a qualsevol operació de gestió de vídeos
        $this->middleware('can:manage videos')->only([
            'create', 'store', 'edit', 'update', 'destroy', 'manageIndex'
        ]);
    }

    /**
     * Llista pública de vídeos.
     */
    public function index(): View
    {
        $videos = Video::all();
        return view('videos.index', compact('videos'));
    }

    /**
     * Mostra un vídeo específic (requereix permís).
     */
    public function show(Video $video): View
    {
        return view('videos.show', compact('video'));
    }

    /**
     * Formulari per crear un vídeo.
     */
    public function create(): View
    {
        $series = Serie::all();
        return view('videos.manage.create', compact('series'));
    }

    /**
     * Desa un nou vídeo.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'url'         => 'required|url',
            'series_id'   => 'nullable|exists:series,id',
        ]);

        Video::create([
            ...$data,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('videos.manage.index')
            ->with('success', 'Vídeo creat correctament!');
    }

    /**
     * Formulari per editar un vídeo.
     */
    public function edit(Video $video): View
    {
        $series = Serie::all();
        return view('videos.manage.edit', compact('video', 'series'));
    }

    /**
     * Actualitza un vídeo existent.
     */
    public function update(Request $request, Video $video): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'url'         => 'required|url',
            'series_id'   => 'nullable|exists:series,id',
        ]);

        $video->update($data);

        return redirect()->route('videos.manage.index')
            ->with('success', 'Vídeo actualitzat correctament!');
    }

    /**
     * Elimina un vídeo.
     */
    public function destroy(Video $video): RedirectResponse
    {
        $video->delete();

        return redirect()->route('videos.manage.index')
            ->with('success', 'Vídeo eliminat correctament!');
    }

    /**
     * Llista de gestió de vídeos (privat).
     */
    public function manageIndex(): View
    {
        $videos = Video::all();
        return view('videos.manage.index', compact('videos'));
    }

    /**
     * Mostra els vídeos testejats per un usuari.
     */
    public function testedBy(int $userId): View
    {
        $videos = Video::where('tested_by', $userId)->get();
        return view('videos.testedBy', compact('videos'));
    }
}
