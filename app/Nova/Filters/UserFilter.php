<?php

namespace App\Nova\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserFilter extends Filter
{
    protected string $relation;

    public function __construct(string $relation)
    {
        $this->relation = $relation;
    }

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Author');
    }

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param NovaRequest $request
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where('user_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function options(NovaRequest $request): array
    {
        return User::has($this->relation)->orderBy('name')->pluck('id', 'name')->toArray();
    }
}
