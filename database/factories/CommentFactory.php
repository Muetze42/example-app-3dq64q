<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Story;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class CommentFactory extends ArticleFactory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-50 days');

        $rand = mt_rand(0, 1);
        if ($rand) {
            $commentableType = Article::class;
            $commentableId = $this->getArticle()->getKey();
        } else {
            $commentableType = Story::class;
            $commentableId = $this->getStory()->getKey();
        }

        return [
            'content'          => $this->faker->paragraphs(1, true),
            'commentable_type' => $commentableType,
            'commentable_id'   => $commentableId,
            'created_at'       => $date,
            'updated_at'       => $date,

            'user_id' => $this->getUser(),
        ];
    }

    protected function getArticle(): Model|Builder|UserFactory|null
    {
        $article = Article::inRandomOrder()->first();
        if (!$article) {
            $article = Article::factory();
        }

        return $article;
    }

    protected function getStory(): Model|Builder|UserFactory|null
    {
        $story = Story::inRandomOrder()->first();
        if (!$story) {
            $story = Story::factory();
        }

        return $story;
    }
}
