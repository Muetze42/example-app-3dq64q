<?php

namespace App\Http\Controllers\Api;

use NormanHuth\ApiController\Controller;

class ActivityController extends Controller
{
    /**
     * @var array
     */
    protected array $indexFilter = [
        'log_name',
        'event',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
    ];

    /**
     * @var array
     */
    protected array $indexLikeFilter = [
        'properties',
    ];

    /**
     * @var string
     */
    protected string $orderDirection = 'desc';
}
