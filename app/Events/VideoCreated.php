<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Video $video;

    /**
     * Crea una nova instància de l'event.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * El canal on es farà broadcast.
     */
    public function broadcastOn(): Channel
    {
        // Canvia PrivateChannel per Channel si vols que sigui públic
        return new Channel('videos');
    }

    /**
     * Nom personalitzat de l’event per al broadcast.
     */
    public function broadcastAs(): string
    {
        return 'video.created';
    }

    /**
     * Dades que exposem al front.
     */
    public function broadcastWith(): array
    {
        return [
            'id'          => $this->video->id,
            'title'       => $this->video->title,
            'description' => $this->video->description,
            'url'         => $this->video->url,
            'series_id'   => $this->video->series_id,
            'user_id'     => $this->video->user_id,
            'created_at'  => $this->video->created_at->toDateTimeString(),
        ];
    }

    /**
     * Opcional: determina si s'ha de fer el broadcast.
     */
    public function broadcastWhen(): bool
    {
        return true;
    }
}
