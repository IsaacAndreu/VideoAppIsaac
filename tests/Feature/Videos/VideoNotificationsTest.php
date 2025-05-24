<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Video;
use App\Events\VideoCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;

class VideoNotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Sembrar rols, permisos i usuaris per defecte
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function test_video_created_event_is_dispatched(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $video = Video::factory()->create([
            'user_id' => $user->id,
        ]);

        event(new VideoCreated($video));

        Event::assertDispatched(VideoCreated::class);
    }

    /** @test */
    public function test_push_notification_is_sent_when_video_is_created(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super-admin');

        $video = Video::factory()->create([
            'user_id' => $superAdmin->id,
        ]);

        event(new VideoCreated($video));

        Notification::assertSentTo(
            [$superAdmin],
            VideoCreatedNotification::class,
            function ($notification, $channels) use ($video) {
                return $notification->getVideo()->id === $video->id;
            }
        );
    }
}
