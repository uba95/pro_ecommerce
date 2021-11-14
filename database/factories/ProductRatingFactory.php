<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(ProductRating::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'product_id' => factory(Product::class),
        'value' => $faker->numberBetween(1, 5) . $faker->randomElement([0, 5]),
    ];
});
