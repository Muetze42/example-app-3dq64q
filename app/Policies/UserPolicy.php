<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param User $model
     * @return bool
     */
    public function view(?User $user, User $model): bool
    {
        return $user && ($user->hasRole('admin') || $user->getKey() == $model->getKey());
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User|null $user
     * @return bool
     */
    public function create(?User $user): bool
    {
        return $user && $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User|null $user
     * @param User $model
     * @return bool
     */
    public function update(?User $user, User $model): bool
    {
        return $user && ($user->hasRole('admin') || $user->getKey() == $model->getKey());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User|null $user
     * @param User $model
     * @return bool
     */
    public function delete(?User $user, User $model): bool
    {
        return $user && $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User|null  $user
     * @param User $model
     * @return bool
     */
    public function restore(?User $user, User $model): bool
    {
        return $user && $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User|null $user
     * @param User $model
     * @return bool
     */
    public function forceDelete(?User $user, User $model): bool
    {
        return $user && $user->hasRole('admin');
    }
}
