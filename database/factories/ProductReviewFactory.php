<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(ProductReview::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'product_id' => factory(Product::class),
        'headline' => $faker->sentence,
        'body' => $faker->text(500),
    ];
});
