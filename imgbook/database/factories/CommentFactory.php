<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'post_id' => Post::all()->random()->id,
        'user_id' => User::all()->random()->id,
    ];
});
