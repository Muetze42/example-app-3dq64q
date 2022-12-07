<?php

namespace App\Traits\Models;

trait DefaultUser
{
    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    public static function booted(): void
    {
        static::defaultUser();
    }

    protected static function defaultUser(): void
    {
        static::creating(function ($model) {
            if (!$model->user_id) {
                $model->user_id = auth()->user()->getKey();
            }
        });
    }
}
