<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VideosController extends Controller
{
    /**
     * Mostra la llista de vídeos (accessible per a tothom).
     *
     * @return View
     */
    public function index(): View
    {
        $videos = Video::all();
        return view('videos.index', compact('videos'));
    }

    /**
     * Mostra un vídeo específic (només per usuaris autoritzats).
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Has d’iniciar sessió per veure el vídeo.');
        }

        if (!Gate::allows('view videos')) {
            abort(403, 'No tens permisos per veure aquest vídeo.');
        }

        $video = Video::findOrFail($id);
        return view('videos.show', compact('video'));
    }

    /**
     * Mostra el formulari per crear un vídeo nou.
     *
     * @return View
     */
    public function create(): View
    {
        return view('videos.manage.create');
    }

    /**
     * Desa un vídeo nou a la base de dades.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
        ]);

        Video::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'url' => $request->input('url'),
        ]);

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo creat correctament!');
    }

    /**
     * Mostra el formulari per editar un vídeo existent.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $video = Video::findOrFail($id);
        return view('videos.manage.edit', compact('video'));
    }

    /**
     * Actualitza un vídeo existent a la base de dades.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
        ]);

        $video = Video::findOrFail($id);
        $video->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'url' => $request->input('url'),
        ]);

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo actualitzat correctament!');
    }

    /**
     * Elimina un vídeo de la base de dades.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo eliminat correctament!');
    }

    /**
     * Mostra la pàgina de gestió de vídeos (per a usuaris amb permisos específics).
     *
     * @return View
     */
    public function manageIndex(): View
    {
        $videos = Video::all();
        return view('videos.manage.index', compact('videos'));
    }

    /**
     * Mostra els vídeos testejats per un usuari específic.
     *
     * @param int $userId
     * @return View
     */
    public function testedBy(int $userId): View
    {
        $videos = Video::whereHas('testedBy', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return view('videos.testedBy', compact('videos'));
    }
}
