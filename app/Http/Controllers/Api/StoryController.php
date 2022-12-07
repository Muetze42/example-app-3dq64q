<?php

namespace App\Http\Controllers\Api;

use App\Models\Story;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class StoryController extends ArticleController
{
    protected mixed $spatieTagsType = Story::class;

    protected array $allowInclude = [
        'user',
        'tags',
        'comments',
    ];

    /**
     * @return array
     */
    protected function storeValidationRules(): array
    {
        return [
            'title'   => ['required', 'string', 'max:50'],
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
            'excerpt' => ['string'],
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
    }
}
