<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\HotDealProduct;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(HotDealProduct::class, function (Faker $faker) {
    return [
        'product_id' => factory(Product::class),
        'status' => 1,
        'started_at' => now()->startOfDay(),
        'expired_at' => now()->startOfDay()->addDays(rand(1,7)),
    ];
});
