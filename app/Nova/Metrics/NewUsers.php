<?php

namespace App\Nova\Metrics;

use App\Models\User;
use DateInterval;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class NewUsers extends Value
{
    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name(): string
    {
        return __('New Users');
    }

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     * @return ValueResult
     */
    public function calculate(NovaRequest $request): ValueResult
    {
        return $this->count($request, User::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array
    {
        return [
            30      => __(':days Days', ['days' => 30]),
            60      => __(':days Days', ['days' => 60]),
            90      => __(':days Days', ['days' => 90]),
            120     => __(':days Days', ['days' => 120]),
            150     => __(':days Days', ['days' => 150]),
            180     => __(':days Days', ['days' => 180]),
            'TODAY' => __('Today'),
            'MTD'   => __('Month To Date'),
            'QTD'   => __('Quarter To Date'),
            'YTD'   => __('Year To Date'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|DateInterval|float|int|null
     */
    public function cacheFor(): DateInterval|float|\DateTimeInterface|int|null
    {
        return null;
        // return now()->addMinutes(5);
    }
}
