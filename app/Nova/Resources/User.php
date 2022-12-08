<?php

namespace App\Nova\Resources;

use App\Nova\Fields\RoleBooleanGroup;
use App\Nova\Filters\User\RoleFilter;
use App\Nova\Metrics\UsersPerDay;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\PasswordConfirmation;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\User::class;

    /**
     * Build an "index" query filter for the given resource.
     *
     * @param NovaRequest $request
     * @param Builder $query
     * @return Builder
     */
    public static function indexFilter(NovaRequest $request, Builder $query): Builder
    {
        /* @var \App\Models\User|Builder $query */
        if ($request->user()->hasRole('admin')) {
            return $query;
        }

        return $query->where('id', $request->user()->getKey());
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'email',
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

            Text::make(__('Name'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Images::make(__('Avatar'), 'avatar')
                ->conversionOnIndexView('thumb')
                ->croppingConfigs(['aspectRatio' => 1])->mustCrop()->hideFromIndex(),

            Avatar::make('Avatar')->thumbnail(function () {
                return $this->getFirstMediaUrl('avatar', 'thumb');
            })->onlyOnIndex(),

            Text::make(__('Email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make(__('Password'), 'password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults(), 'confirmed')
                ->updateRules('nullable', Rules\Password::defaults(), 'confirmed'),

            PasswordConfirmation::make(__('Password Confirmation')),

            RoleBooleanGroup::make(__('Roles'), 'roles'),

            HasMany::make(__('Articles'), 'articles', Article::class),
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
            new UsersPerDay,
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
            new RoleFilter,
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
