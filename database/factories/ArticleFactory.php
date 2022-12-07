<?php

namespace Database\Factories;

use App\Models\Article;
use App\Traits\Database\GetUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    use GetUser;

    protected $model = Article::class;

    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-100 days', '-50 days');

        return [
            'user_id'    => $this->getUser(),
            'title'      => $this->faker->sentence(5),
            'content'    => implode("\n\n", $this->faker->paragraphs(mt_rand(5, 10))),
            'excerpt'    => $this->faker->sentence(10),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
