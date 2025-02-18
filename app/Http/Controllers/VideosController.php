<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class VideosController extends Controller
{
    /**
     * Mostra la llista de vídeos (només per usuaris autoritzats).
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Has d’iniciar sessió per veure els vídeos.');
        }

        if (!Gate::allows('manage-videos')) {
            abort(403, 'No tens permisos per gestionar vídeos.');
        }

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

        if (!Gate::allows('manage-videos')) {
            abort(403, 'No tens permisos per veure aquest vídeo.');
        }

        $video = Video::findOrFail($id);
        return view('videos.show', compact('video'));
    }
}
