<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        Article::factory()
            ->count(3)
            ->create([
                'user_id' => 1,
            ]);

        /** @noinspection PhpUndefinedMethodInspection */
        User::factory()
            ->count(5)
            ->hasArticles(3)
            ->create();
        /** @noinspection PhpUndefinedMethodInspection */
        User::factory()
            ->count(5)
            ->hasStories(3)
            ->create();

        User::whereHas('articles')
            ->orWhereHas('stories')
            ->whereNot('id', 1)
            ->get()
            ->each(function (User $user) {
                $user->assignRole('writer');
            });

        User::factory()
            ->count(20)
            ->create();

        User::whereDoesntHave('articles')
            ->whereNot('id', 1)
            ->limit(5)
            ->get()
            ->each(function (User $user) {
                $user->assignRole('moderator');
            });

        $this->call([
            TagSeeder::class,
            CommentSeeder::class,
            MediaSeeder::class,
        ]);
    }
}
