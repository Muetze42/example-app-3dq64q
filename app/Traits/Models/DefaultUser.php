<?php

namespace App\Traits\Models;

trait DefaultUser
{
    /**
     * Boot Default User Trait
     *
     * @return void
     */
    protected static function bootDefaultUser(): void
    {
        static::creating(function ($model) {
            if (!$model->user_id) {
                $model->user_id = auth()->user()->getKey();
            }
        });
    }
}
