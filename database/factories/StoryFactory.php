<?php

namespace Database\Factories;

use App\Models\Story;

class StoryFactory extends ArticleFactory
{
    protected $model = Story::class;

    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-100 days', '-50 days');

        return [
            'user_id'    => $this->getUser(),
            'title'      => $this->faker->sentence(),
            'content'    => implode("\n\n", $this->faker->paragraphs(mt_rand(5, 10))),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
