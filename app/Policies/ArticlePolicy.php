<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    protected bool $samePermission;

    protected function samePermission(?User $user, Article $article): bool
    {
        if (!isset($this->samePermission)) {
            $this->samePermission = $user && ($user->hasRole('admin') ||
                    ($user->can('edit articles') && $user->getKey() === $article->user_id));
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
     * @param Article $article
     * @return bool
     */
    public function view(?User $user, Article $article): bool
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
     * @param Article $article
     * @return bool
     */
    public function update(?User $user, Article $article): bool
    {
        return $this->samePermission($user, $article);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User|null $user
     * @param Article $article
     * @return bool
     */
    public function delete(?User $user, Article $article): bool
    {
        return $this->samePermission($user, $article);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User|null  $user
     * @param Article $article
     * @return bool
     */
    public function restore(?User $user, Article $article): bool
    {
        return $this->samePermission($user, $article);
    }

    /**
     * Determine whether the user can add a tag to the article.
     *
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function addTag(User $user, Article $article): bool
    {
        return $this->samePermission($user, $article);
    }

    /**
     * Determine whether the user can detach a tag from an article.
     *
     * @param User $user
     * @param Article $article
     * @param Tag $tag
     * @return bool
     */
    public function detachTag(User $user, Article $article, Tag $tag): bool
    {
        return $this->samePermission($user, $article);
    }
}
