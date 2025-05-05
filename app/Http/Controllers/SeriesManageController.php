<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SeriesManageController extends Controller
{
    /**
     * Mostrar totes les sèries.
     */
    public function index(): View
    {
        $series = Serie::paginate(10);
        return view('series.manage.index', compact('series'));
    }

    /**
     * Mostra el formulari per crear una nova sèrie.
     */
    public function create(): View
    {
        return view('series.manage.create');
    }

    /**
     * Desa una nova sèrie.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:255',
            'user_name' => 'required|string|max:255',
            'user_photo_url' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        Serie::create($request->only([
            'title', 'description', 'image', 'user_name', 'user_photo_url', 'published_at'
        ]));

        return redirect()->route('series.manage.index')->with('success', 'Sèrie creada correctament!');
    }

    /**
     * Formulari per editar una sèrie.
     */
    public function edit(int $id): View
    {
        $serie = Serie::findOrFail($id);
        return view('series.manage.edit', compact('serie'));
    }

    /**
     * Actualitza una sèrie existent.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $serie = Serie::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:255',
            'user_name' => 'required|string|max:255',
            'user_photo_url' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        $serie->update($request->only([
            'title', 'description', 'image', 'user_name', 'user_photo_url', 'published_at'
        ]));

        return redirect()->route('series.manage.index')->with('success', 'Sèrie actualitzada correctament!');
    }

    /**
     * Formulari per confirmar l'eliminació d'una sèrie.
     */
    public function delete(int $id): View
    {
        $serie = Serie::findOrFail($id);
        return view('series.manage.delete', compact('serie'));
    }

    /**
     * Elimina una sèrie.
     */
    public function destroy(int $id): RedirectResponse
    {
        $serie = Serie::findOrFail($id);

        // Opcional: desassignar vídeos relacionats
        foreach ($serie->videos as $video) {
            $video->series_id = null;
            $video->save();
        }

        $serie->delete();

        return redirect()->route('series.manage.index')->with('success', 'Sèrie eliminada correctament!');
    }

    /**
     * Mostrar totes les sèries testejades per un usuari.
     */
    public function testedby(int $userId): View
    {
        $user = User::findOrFail($userId);
        $series = Serie::where('user_name', $user->name)->get();

        return view('series.manage.testedby', compact('user', 'series'));
    }
}
