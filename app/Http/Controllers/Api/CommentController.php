<?php

namespace App\Http\Controllers\Api;

use NormanHuth\ApiController\Controller;

class CommentController extends Controller
{
    /**
     * @var array
     */
    protected array $autoloadRelations = [
        'user',
        'commentable',
    ];

    /**
     * Validation Rules For Each Request
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'content' => ['required', 'string'],
        ];
    }
}
