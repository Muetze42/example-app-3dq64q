<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use NormanHuth\HelpersLaravel\Traits\Spatie\LogsActivityTrait;

/**
 * App\Models\Model
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @method static Builder|Model newModelQuery()
 * @method static Builder|Model newQuery()
 * @method static Builder|Model query()
 * @mixin \Eloquent
 * @method static Builder|Model latest()
 */
class Model extends BaseModel
{
    use LogsActivityTrait;

    /**
     * Scope a query to get the latest first
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}
