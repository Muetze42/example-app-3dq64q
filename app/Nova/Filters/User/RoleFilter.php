<?php

namespace App\Nova\Filters\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class RoleFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Role');
    }

    /**
     * Apply the filter to the given query.
     *
     * @param NovaRequest $request
     * @param Builder $query
     * @param mixed $value
     * @return Builder
     */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        /* @var User|Builder $query */
        return $value == '-' ? $query->whereDoesntHave('roles') :
            $query->whereHas('roles', function ($role) use ($value) {
            /* @var Role|Builder $role */
            return $role->where('name', $value);
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function options(NovaRequest $request): array
    {
        return array_merge(
            Role::pluck('name', 'name')->toArray(),
            [__('No Role') => '-']
        );
    }
}
