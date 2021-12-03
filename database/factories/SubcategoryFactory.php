<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Subcategory;
use Faker\Generator as Faker;

$factory->define(Subcategory::class, function (Faker $faker) {
    $name = $faker->unique()->words(2, true);
    return [
        'category_id' => factory(Category::class),
        'subcategory_name' => $name,
        'subcategory_slug' => Str::slug($name),
    ];
});
