<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SeriesManageController extends Controller
{
    public function __construct()
    {
        // Requereix estar autenticat per a totes les rutes
        $this->middleware('auth');

        // Permisos segons la política SeriesPolicy
        $this->middleware('can:viewAny,App\Models\Serie')->only('index');
        $this->middleware('can:create,App\Models\Serie')->only(['create', 'store']);
        $this->middleware('can:view,serie')->only('show');
        $this->middleware('can:update,serie')->only(['edit', 'update']);
        $this->middleware('can:delete,serie')->only(['delete', 'destroy']);
    }

    /**
     * Mostrar totes les sèries.
     */
    public function index(): View
    {
        $series = Serie::paginate(10);

        return view('series.manage.index', compact('series'));
    }

    /**
     * Formulari per crear una nova sèrie.
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
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'image'        => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        // Guarda qui la crea
        $data['user_id'] = auth()->id();

        Serie::create($data);

        return redirect()
            ->route('series.manage.index')
            ->with('success', 'Sèrie creada correctament!');
    }

    /**
     * Mostra el detall d’una sèrie.
     */
    public function show(Serie $serie): View
    {
        $serie->load('videos');

        return view('series.manage.show', compact('serie'));
    }

    /**
     * Formulari per editar una sèrie.
     */
    public function edit(Serie $serie): View
    {
        return view('series.manage.edit', compact('serie'));
    }

    /**
     * Actualitza una sèrie existent.
     */
    public function update(Request $request, Serie $serie): RedirectResponse
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'image'        => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        $serie->update($data);

        return redirect()
            ->route('series.manage.index')
            ->with('success', 'Sèrie actualitzada correctament!');
    }

    /**
     * Formulari per confirmar l’eliminació d’una sèrie.
     */
    public function delete(Serie $serie): View
    {
        return view('series.manage.delete', compact('serie'));
    }

    /**
     * Elimina una sèrie.
     */
    public function destroy(Serie $serie): RedirectResponse
    {
        // Opcional: desassignar vídeos relacionats
        $serie->videos()->update(['series_id' => null]);

        $serie->delete();

        return redirect()
            ->route('series.manage.index')
            ->with('success', 'Sèrie eliminada correctament!');
    }

    /**
     * Mostrar totes les sèries creades per un usuari (tested by).
     */
    public function testedby(int $userId): View
    {
        $series = Serie::where('user_id', $userId)->get();

        return view('series.manage.testedby', compact('series'));
    }
}
