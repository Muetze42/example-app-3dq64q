<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @return void
     */
    public function run(): void
    {
        Article::whereDoesntHave('media')
            ->get()
            ->each(function (Article $article) {
                $article->addMediaFromUrl('https://loremflickr.com/640/480')
                    ->toMediaCollection('picture');
            });
    }
}
