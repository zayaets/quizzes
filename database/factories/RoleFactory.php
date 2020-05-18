<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->state(Role::class, 'user', function (Faker $faker) {
   return [
       'name' => 'User',
       'slug' => 'user',
       'permissions' => [
           'create-question' => true,
           'create-answers' => true,
           'update-question' => true,
           'update-answers' => true,
           'delete-question' => true,
           'delete-answers' => true,
       ]
   ];
});

$factory->state(Role::class, 'admin', function (Faker $faker) {
    return [
        'name' => 'Admin',
        'slug' => 'admin',
        'permissions' => [
            'create-question' => true,
            'create-answers' => true,

            'update-question' => true,
            'update-answers' => true,

            'delete-question' => true,
            'delete-answers' => true,

            'publish-question' => true
        ]
    ];
});
