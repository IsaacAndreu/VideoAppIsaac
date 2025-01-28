<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Video;
use App\Models\Test;

class VideosController extends Controller
{
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
     * Filtra vídeos que han estat testejats per un usuari específic.
     *
     * @param int $userId
     * @return \Illuminate\Contracts\View\View
     */
    public function testedBy(int $userId)
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\Video> $videos */
        $videos = Video::whereHas('tests', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return view('videos.testedBy', compact('videos'));
    }

    /**
     * Relació amb el model Test.
     *
     * @return HasMany<Test>
     */
    public function tests(): \Illuminate\Database\Eloquent\Collection
    {
        return Test::all();
    }

}
