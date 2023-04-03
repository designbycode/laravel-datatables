<?php

namespace Designbycode\Datatables\Tests\Stubs\Factories;

use Designbycode\Datatables\Tests\Stubs\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->sentence(20),
        ];
    }
}
