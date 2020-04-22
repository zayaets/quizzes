<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'text' => $faker->realText(30, 2),
        'question_id' => factory(\App\Question::class)->create()->id,
        'is_right' => $faker->boolean(),
    ];
});
