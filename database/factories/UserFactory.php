<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Models\Blog::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function() {
            return factory('App\Models\User')->create()->id;
        },
        'title' => $title,
        'slug'  => str_slug($title),
        'subject' => $faker->paragraph
    ];
});

$factory->define(App\Models\BlogComment::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function() {
            return factory('App\Models\User')->create()->id;
        },
        'blog_id' => function() {
            return factory('App\Models\Blog')->create()->id;
        },
        'subject' => $faker->paragraph
    ];
});
