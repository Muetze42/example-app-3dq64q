<?php

namespace App\Models;

use App\Traits\Models\DefaultUser;
use App\Traits\Models\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;

/**
 * App\Models\Story
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string|null $excerpt
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\StoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Story newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Story newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Story query()
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Story withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Story withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Story withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Story withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Story withoutTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static Builder|Model latest()
 */
class Story extends Model
{
    use HasFactory,
        HasComments,
        HasTags,
        DefaultUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * Get the user that owns the article.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
