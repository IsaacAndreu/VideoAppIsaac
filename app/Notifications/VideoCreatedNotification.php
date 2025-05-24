<?php

namespace App\Notifications;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class VideoCreatedNotification extends Notification
{
    use Queueable;

    protected Video $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Getter públic per accedir al vídeo (per als tests).
     */
    public function getVideo(): Video
    {
        return $this->video;
    }

    /**
     * Canals de notificació.
     */
    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Missatge per correu electrònic.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Nou vídeo creat: {$this->video->title}")
            ->line("S'ha creat un nou vídeo titulat “{$this->video->title}”.")
            ->action('Veure vídeo', route('videos.show', $this->video))
            ->line('Gràcies per la teva atenció!');
    }

    /**
     * Dades per a la base de dades.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'video_id'    => $this->video->id,
            'title'       => $this->video->title,
            'created_by'  => $this->video->user->name,
        ];
    }

    /**
     * Missatge per broadcast (Pusher).
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'video_id'    => $this->video->id,
            'title'       => $this->video->title,
            'created_by'  => $this->video->user->name,
        ]);
    }
}
