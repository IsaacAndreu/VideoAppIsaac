<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use App\Models\Video;

class VideosManageController extends Controller
{
    /**
     * Mostra la llista de vídeos per gestionar-los.
     *
     * @return View
     */
    public function index(): View
    {
        $videos = Video::all();
        return view('videos.manage.index', compact('videos'));
    }

    /**
     * Mostra el formulari per crear un nou vídeo.
     *
     * @return View
     */
    public function create(): View
    {
        return view('videos.manage.create');
    }

    /**
     * Desa un nou vídeo a la base de dades.
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
            'user_id' => auth()->id(), // assigna l'id de l'usuari autenticat
        ]);

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo creat correctament!');
    }


    /**
     * Mostra un vídeo específic.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $video = Video::findOrFail($id);
        return view('videos.show', compact('video'));
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
     * Actualitza un vídeo existent.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
        ]);

        $video = Video::findOrFail($id);
        $video->update($request->only('title', 'description', 'url'));

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo actualitzat correctament.');
    }

    /**
     * Mostra la vista de confirmació per eliminar un vídeo.
     *
     * @param int $id
     * @return View
     */
    public function delete(int $id): View
    {
        $video = Video::findOrFail($id);
        return view('videos.manage.delete', compact('video'));
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

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo eliminat correctament.');
    }

    /**
     * Mostra els vídeos testejats per un usuari específic.
     *
     * @param int $userId
     * @return View
     */
    public function testedby(int $userId): View
    {
        $videos = Video::where('tested_by', $userId)->get();
        return view('videos.testedBy', compact('videos'));
    }
}
