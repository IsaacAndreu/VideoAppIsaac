<?php

namespace App\Policies;

use App\Models\User as AppUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function manage(AppUser $user): bool
    {
        return $user->can('manage users');
    }
}
