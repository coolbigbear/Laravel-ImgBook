<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use App\Post;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {

    static $post_id = 1;

    $path = $faker->image($dir = '/home/vagrant/laravel/laravel-web-app/imgbook/storage/app/public/images/tmp', $width = 640, $height = 480);
    $path = explode('public', $path);
    $path = '/storage' . $path[1];

    return [
        'image' => $path,
        'post_id' => $post_id++,
    ];
});


