<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Brand;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    $name = $faker->unique()->words(2, true);
    return [
        'brand_name' => $name,
        'brand_slug' => Str::slug($name),
    ];
});
