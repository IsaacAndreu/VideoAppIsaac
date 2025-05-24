<?php
// app/Listeners/SendVideoCreatedNotification.php

namespace App\Listeners;

use App\Events\VideoCreated;
use App\Models\User;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVideoCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(VideoCreated $event): void
    {
        $video = $event->video;

        // Recupera tots els super-admins
        $admins = User::role('super-admin')->get();

        // A cada admin li enviem la notificació
        foreach ($admins as $admin) {
            $admin->notify(new VideoCreatedNotification($video));
        }
    }
}
