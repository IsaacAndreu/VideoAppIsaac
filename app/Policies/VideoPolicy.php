<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view videos');
    }

    public function view(User $user, Video $video)
    {
        return $user->can('view videos');
    }

    public function create(User $user)
    {
        return $user->can('create videos');
    }

    public function update(User $user, Video $video)
    {
        return $user->can('edit videos');
    }

    public function delete(User $user, Video $video)
    {
        return $user->can('delete videos');
    }

    public function manage(User $user)
    {
        return $user->can('manage videos');
    }
}
