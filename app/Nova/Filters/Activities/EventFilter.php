<?php

namespace App\Nova\Filters\Activities;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class EventFilter extends Filter
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
        return __('Event');
    }

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
        return $query->where('event', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function options(NovaRequest $request): array
    {
        return Activity::orderBy('event')->pluck('event', 'event')->toArray();
    }
}
