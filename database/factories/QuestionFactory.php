<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->sentence(),
        'text' => $faker->unique()->realText(150, 2),
        'user_id' => factory(\App\User::class)->create()->id,
    ];
});
