<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->unique()->words(2, true);
    return [
        'category_name' => $name,
        'category_slug' => Str::slug($name),
    ];
});
