<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Traits\Database\GetUser;
use App\Traits\Database\WithFaker;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    use WithFaker, GetUser;

    /**
     * Run the database seeds.
     *
     * @throws BindingResolutionException
     * @return void
     */
    public function run(): void
    {
        foreach (glob(app_path('Models/*.php')) as $file) {
            $class = 'App\\Models\\'.basename(str_replace('.php', '', $file));
            $model = app($class);
            if (in_array('App\Traits\Models\HasComments', class_uses($model))) {
                /* @var \App\Models\Article|\App\Models\Story $model */
                $model->all()->each(function ($item) use ($class) {
                    $date = now()->subDays(50);

                    $max = mt_rand(2, 4);
                    for ($i = 1; $i <= $max; $i++) {
                        $addDays = mt_rand(0, 10);
                        $date = $date->addDays($addDays)->hour(mt_rand(0, 23))->minute(mt_rand(0, 59))->second(mt_rand(0, 59));
                        Comment::create([
                            'content'          => $this->faker()->paragraphs(1, true),
                            'commentable_type' => $class,
                            'commentable_id'   => $item->getKey(),
                            'created_at'       => $date,
                            'updated_at'       => $date,
                            'user_id'          => $this->getUser()->getKey()
                        ]);
                    }
                });
            }
        }
    }
}
