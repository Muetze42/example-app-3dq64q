<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use NormanHuth\ApiController\Controller;

class ArticleController extends Controller
{
    protected mixed $spatieTagsType = Article::class;

    protected array $allowInclude = [
        'user',
        'tags',
        'media',
        'comments',
    ];

    /**
     * This action is performed before the show request
     *
     * @param Request $request
     */
    protected function beforeStoreAction(Request $request): void
    {
        $this->storeAction = $request->input('unique') ? 'firstOrCreate' : 'create';
    }

    /**
     * @return array
     */
    protected function storeValidationRules(): array
    {
        return [
            'title'   => ['required', 'string', 'max:50'],
            'excerpt' => ['nullable', 'string', 'max:100'],
            'content' => ['required', 'string'],
        ];
    }

    /**
     * @return array
     */
    protected function updateValidationRules(): array
    {
        return [
            'title'   => ['string', 'max:50'],
            'content' => ['string', 'max:100'],
            'excerpt' => ['string', 'nullable'],
        ];
    }

    /**
     * Perform Action After Resource Is Stored Or Updated
     * Do Image Uploads etc.
     *
     * @param Request $request
     * @param mixed $model
     * @throws AuthorizationException
     * @return void
     */
    protected function afterStoredUpdated(Request $request, mixed $model): void
    {
        $tags = $request->input('tags');

        if ($tags) {
            $this->syncSpatieTags($request, $model->getKey(), $tags);
        }

        if ($request->hasFile('picture')) {
            $model->addMediaFromRequest('picture')->toMediaCollection('picture');
        }
    }
}
