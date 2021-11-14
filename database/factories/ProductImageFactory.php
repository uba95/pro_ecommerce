<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\Models\ProductImage;
use Faker\Generator as Faker;

$factory->define(ProductImage::class, function (Faker $faker) {

    $name = $faker->image(storage_path('app\public\media\products\images'), 500, 500, 'technics');

    return [
        'product_id' => factory(Product::class),
        'name' => substr($name, strpos($name, 'media')),
    ];
});
