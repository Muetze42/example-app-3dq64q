<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return $user && $user->hasAdminAccess();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Activity $activity
     * @return bool
     */
    public function view(User $user, Activity $activity): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Activity $activity
     * @return bool
     */
    public function update(User $user, Activity $activity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Activity $activity
     * @return bool
     */
    public function delete(User $user, Activity $activity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User  $user
     * @param Activity $activity
     * @return bool
     */
    public function restore(User $user, Activity $activity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Activity $activity
     * @return bool
     */
    public function forceDelete(User $user, Activity $activity): bool
    {
        return false;
    }
}
