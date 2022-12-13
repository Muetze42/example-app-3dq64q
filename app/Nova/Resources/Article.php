<?php

namespace App\Nova\Resources;

use App\Nova\Filters\UserFilter;
use App\Nova\Metrics\ArticlesPerUser;
use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use NormanHuth\HelpersLaravel\Spatie\Tags\Tags;

class Article extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Article::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __('Articles');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return __('Article');
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'excerpt',
        'user.name',
        'content',
        'tags.name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Title'), 'title')->withMeta([
                'extraAttributes' => [
                    'maxlength' => 50,
                ],
            ])->sortable()->rules('required', 'string', 'max:50'),
            BelongsTo::make(__('Author'), 'user', User::class),
            Markdown::make(__('Content'), 'content')
                ->rules('required', 'string')->alwaysShow(),

            Textarea::make(__('Excerpt'), 'excerpt')->withMeta([
                'extraAttributes' => [
                    'maxlength' => 100,
                ],
            ])->rules('nullable', 'string', 'max:100')->alwaysShow()->nullable(),

            Medialibrary::make(__('Image'), 'picture')
                ->previewUsing('thumb')->rules('required')->single(),

            Tags::make(__('Tags'), 'tags')
                ->type(static::$model)
                ->withMeta(['placeholder' => __('Add tag...')]),

            MorphMany::make(__('Comments'), 'comments', Comment::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [
            new ArticlesPerUser,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [
            new UserFilter('articles'),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
