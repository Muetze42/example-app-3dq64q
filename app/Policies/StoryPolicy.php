<?php

namespace App\Policies;

use App\Models\Story;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoryPolicy
{
    use HandlesAuthorization;

    protected bool $samePermission;

    protected function samePermission(?User $user, Story $story): bool
    {
        if (!isset($this->samePermission)) {
            $this->samePermission = $user && ($user->hasRole('admin') ||
                    ($user->can('edit comments') && $user->getKey() === $story->user_id));
        }

        return $this->samePermission;
    }

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
     * @param Story $story
     * @return bool
     */
    public function view(?User $user, Story $story): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User|null $user
     * @return bool
     */
    public function create(?User $user): bool
    {
        return $user && $user->can('edit articles');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User|null $user
     * @param Story $story
     * @return bool
     */
    public function update(?User $user, Story $story): bool
    {
        return $this->samePermission($user, $story);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User|null $user
     * @param Story $story
     * @return bool
     */
    public function delete(?User $user, Story $story): bool
    {
        return $this->samePermission($user, $story);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User|null  $user
     * @param Story $story
     * @return bool
     */
    public function restore(?User $user, Story $story): bool
    {
        return $this->samePermission($user, $story);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User|null $user
     * @param Story $story
     * @return bool
     */
    public function forceDelete(?User $user, Story $story): bool
    {
        return $user && $user->hasRole('admin');
    }

    /**
     * Determine whether the user can add a comment to the podcast.
     *
     * @param ?User $user
     * @return bool
     */
    public function addComment(?User $user): bool
    {
        return true;
    }
}
