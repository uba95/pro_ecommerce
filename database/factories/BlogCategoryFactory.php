<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Faker\Generator as Faker;

$factory->define(BlogCategory::class, function (Faker $faker) {

    $name = $faker->unique()->words(2, true);

    return [
        'blog_category_name' => $name,
        'blog_category_slug' => Str::slug($name),
    ];
});
