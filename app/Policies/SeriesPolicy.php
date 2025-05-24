<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Serie;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeriesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any series.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view series');
    }

    /**
     * Determine whether the user can view a given series.
     */
    public function view(User $user, Serie $serie): bool
    {
        return $user->can('view series');
    }

    /**
     * Determine whether the user can create series.
     */
    public function create(User $user): bool
    {
        return $user->can('create series');
    }

    /**
     * Determine whether the user can update a given series.
     */
    public function update(User $user, Serie $serie): bool
    {
        return $user->can('edit series');
    }

    /**
     * Determine whether the user can delete a given series.
     */
    public function delete(User $user, Serie $serie): bool
    {
        return $user->can('delete series');
    }

    /**
     * Determine whether the user can perform any "manage" action on series.
     */
    public function manage(User $user): bool
    {
        return $user->can('manage series');
    }
}
