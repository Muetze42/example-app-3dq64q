<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        Nova::userMenu(function (Request $request, Menu $menu) {
            $menu->append(
                MenuItem::externalLink(
                    __('Back to website'),
                    '/'
                )
            );

            $menu->prepend(
                MenuItem::make(
                    'My Profile',
                    "/resources/users/{$request->user()->getKey()}"
                )
            );

            return $menu;
        });

        Nova::footer(function ($request) {
            return '';
        });

        app()->bind(
            \Spatie\TagsField\Http\Controllers\TagsFieldController::class,
            \NormanHuth\HelpersLaravel\Spatie\Tags\TagsFieldController::class,
        );
    }

    /**
     * Configure the Nova authorization services.
     *
     * @return void
     */
    protected function authorization(): void
    {
        Nova::auth(function ($request) {
            return Gate::check('viewNova', [Nova::user($request)]);
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            /* @var \App\Models\User $user */
            return $user && $user->hasAdminAccess();
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards(): array
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools(): array
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Nova::resourcesIn(app_path('Nova/Resources'));
    }
}
