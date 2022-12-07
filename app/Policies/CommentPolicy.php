<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
     * @param Comment $comment
     * @return bool
     */
    public function view(?User $user, Comment $comment): bool
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
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User|null $user
     * @param Comment $comment
     * @return bool
     */
    public function update(?User $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User|null $user
     * @param Comment $comment
     * @return bool
     */
    public function delete(?User $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User|null  $user
     * @param Comment $comment
     * @return bool
     */
    public function restore(?User $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User|null $user
     * @param Comment $comment
     * @return bool
     */
    public function forceDelete(?User $user, Comment $comment): bool
    {
        return true;
    }
}
