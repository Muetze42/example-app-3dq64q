<?php

namespace App\Nova\Metrics;

use App\Models\Article;
use App\Models\User;
use DateInterval;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class ArticlesPerUser extends Partition
{
    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Article Per User');
    }

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     * @return PartitionResult
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count($request, Article::class, 'user_id')
            ->label(fn ($value) => match ($value) {
                null => 'None',
                default => optional(User::find($value))->name
            });
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return DateTimeInterface|DateInterval|float|int|null
     */
    public function cacheFor(): DateInterval|float|DateTimeInterface|int|null
    {
        return null;
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'article-per-user';
    }
}
