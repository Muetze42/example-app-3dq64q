<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Story;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $genres = [
            'Fantasy',
            'Science-Fiction',
            'History',
            'Thriller',
            'Action',
            'Comedy',
            'Drama',
        ];

        foreach ($genres as $genre) {
            Tag::firstOrCreate([
                'name' => $genre,
                'type' => Story::class,
            ]);
        }

        Story::all()->each(function (Story $story) {
            $tags = Tag::where('type', Story::class)
                ->inRandomOrder()
                ->limit(mt_rand(1,3))
                ->get();

            $story->syncTags($tags);
        });

        $languages = [
            'Python',
            'Java',
            'JavaScript',
            'C#',
            'C++',
            'PHP',
            'TypeScript',
            'Swift',
            'Kotlin',
            'Go',
            'Rust',
        ];

        foreach ($languages as $language) {
            Tag::firstOrCreate([
                'name' => $language,
                'type' => Article::class,
            ]);
        }

        Article::all()->each(function (Article $story) {
            $tags = Tag::where('type', Article::class)
                ->inRandomOrder()
                ->limit(mt_rand(1,3))
                ->get();

            $story->syncTags($tags);
        });
    }
}
