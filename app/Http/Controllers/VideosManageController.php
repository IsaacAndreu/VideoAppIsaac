<?php

namespace App\Http\Controllers;

use App\Events\VideoCreated;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VideosManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:viewAny,App\Models\Video')->only('index');
        $this->middleware('can:create,App\Models\Video')->only(['create', 'store']);
        $this->middleware('can:view,video')->only('show');
        $this->middleware('can:update,video')->only(['edit', 'update']);
        $this->middleware('can:delete,video')->only(['delete', 'destroy']);
    }

    public function index(): View
    {
        $videos = Video::all();
        return view('videos.manage.index', compact('videos'));
    }

    public function create(): View
    {
        // Passeseries_id si venen de la vista de sèrie
        $series = \App\Models\Serie::all();
        return view('videos.manage.create', compact('series'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'url'         => 'required|url',
            'series_id'   => 'nullable|exists:series,id',
        ]);

        // Crear el vídeo
        $video = Video::create([
            'title'       => $data['title'],
            'description' => $data['description'],
            'url'         => $data['url'],
            'series_id'   => $data['series_id'] ?? null,
            'user_id'     => auth()->id(),
        ]);

        // Dispatch de l'event
        event(new VideoCreated($video));

        return to_route('videos.manage.index')
            ->with('success', 'Vídeo creat correctament!');
    }

    public function show(Video $video): View
    {
        return view('videos.manage.show', compact('video'));
    }

    public function edit(Video $video): View
    {
        $series = \App\Models\Serie::all();
        return view('videos.manage.edit', compact('video', 'series'));
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'url'         => 'required|url',
            'series_id'   => 'nullable|exists:series,id',
        ]);

        $video->update($data);

        return to_route('videos.manage.index')
            ->with('success', 'Vídeo actualitzat correctament!');
    }

    public function delete(Video $video): View
    {
        return view('videos.manage.delete', compact('video'));
    }

    public function destroy(Video $video): RedirectResponse
    {
        $video->delete();

        return to_route('videos.manage.index')
            ->with('success', 'Vídeo eliminat correctament!');
    }

    public function testedBy(int $userId): View
    {
        $videos = Video::where('tested_by', $userId)->get();
        return view('videos.testedBy', compact('videos'));
    }
}
