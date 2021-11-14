<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {

    $avatar = $faker->image(storage_path('app\public\media\users\avatars'),100, 100);
    
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'avatar' => substr($avatar, strpos($avatar, 'media')),
        'email_verified_at' => now(),
        'password' => '$2y$10$GNJe0nyStvWxG7Cfuu2IZO8GxTFUjvxEXAjWi/N4apURUUvMEziGu', // 111
        'remember_token' => Str::random(10),
    ];
});
