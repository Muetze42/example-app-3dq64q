<?php

namespace App\Traits\Database;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

trait GetUser
{
    protected function getUser(): Model|Builder|UserFactory|null
    {
        $user = User::inRandomOrder()->first();
        if (!$user) {
            $user = User::factory();
        }

        return $user;
    }
}
