<?php

namespace App\Nova\Resources;

use App\Nova\Filters\Activities\EventFilter;
use App\Nova\Filters\Activities\LogNameFilter;
use App\Nova\Filters\Activities\SubjectTypeFilter;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Activity extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Activity::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __('Activities');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return __('Activity');
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title(): string
    {
        return __('Activity').' '.$this->created_at->format('m.d.Y H:i:s');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'properties',
        'causer.name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @throws \Exception
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Text::make(__('Event'), 'event')->sortable(),

            Text::make(__('Subject Type'), 'subject_type', function () {
                return class_basename($this->subject_type);
            })->sortable(),

            Text::make(__('Log Name'), 'log_name')
                ->sortable(),

            MorphTo::make(__('Subject'), 'subject')
                ->nullable(),
            MorphTo::make(__('Causer'), 'causer')
                ->viewable($request->user()->is_admin)->nullable(),

            Text::make(__('Excepted properties'), 'except', function () {
                if (!empty($this->except)) {
                    return '<span class="font-bold">'.implode(', ', (array) $this->except).'</span>';
                }
                return null;
            })->onlyOnDetail()->asHtml(),

            Code::make(__('Old properties'), 'properties->old')
                ->json(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                ->onlyOnDetail()->canSee(function () {
                    return $this->event != 'created';
                }),
            Code::make(__('New properties'), 'properties->attributes')
                ->json(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                ->onlyOnDetail(),

            DateTime::make(__('Logged at'), 'created_at')
                ->sortable()->filterable()->exceptOnForms()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [
            new EventFilter,
            new LogNameFilter,
            new SubjectTypeFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
