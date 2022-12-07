<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use NormanHuth\ApiController\Controller;

class UserController extends Controller
{
    protected array $allowInclude = ['roles'];
    protected array $showAllowInclude = ['articles', 'articles.media'];

    protected function indexQuery(Builder $query, Request $request): Builder
    {
        $user = $request->user();
        if ($user && $user->hasRole('admin')) {
            return $query;
        }

        return $query->where('id', $user->getKey());
    }
}
