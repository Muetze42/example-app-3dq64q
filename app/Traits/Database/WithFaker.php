<?php

namespace App\Traits\Database;

use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

trait WithFaker
{
    /**
     * The current Faker instance.
     *
     * @var Generator|null
     */
    protected ?Generator $faker;

    /**
     * @return Generator
     * @throws BindingResolutionException
     */
    protected function faker(): Generator
    {
        if (empty($this->faker)) {
            $this->faker = Container::getInstance()->make(Generator::class);
        }

        return $this->faker;
    }
}
