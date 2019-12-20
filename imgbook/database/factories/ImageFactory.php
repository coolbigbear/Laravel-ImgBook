<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use App\Post;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {

    static $post_id = 2;

    $path = $faker->image($dir = '/home/vagrant/laravel/laravel-web-app/imgbook/storage/app/public/images/tmp', 500, 500, '', true, false);
    $path = explode('public', $path);
    $path = '/storage' . $path[1];

    return [
        'image' => $path,
        'post_id' => $post_id++,
    ];
});


