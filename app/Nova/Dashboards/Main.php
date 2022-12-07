<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ArticlesPerUser;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\StoriesPerUser;
use App\Nova\Metrics\UsersPerDay;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards(): array
    {
        return [
            new NewUsers,
            new UsersPerDay,
            new ArticlesPerUser,
            new StoriesPerUser,
        ];
    }
}
