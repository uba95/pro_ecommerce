<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    
    $categories_ids = Category::pluck('id');
    $category = $categories_ids->isNotEmpty() ? $categories_ids->random() : factory(Category::class)->create();

    $subcategories_ids = Subcategory::where('category_id', $category->id ?? $category)->pluck('id');
    $subcategory = $subcategories_ids->isNotEmpty() ? $subcategories_ids->random() : null;

    $brands_ids = Brand::pluck('id');
    $brand = $brands_ids->isNotEmpty() ? $brands_ids->random() : null;

    $name = $faker->unique()->sentence(4);
    $selling_price =  $faker->optional(0.5, $faker->numberBetween(1, 10))->numberBetween(10, 50) * $faker->randomElement([10,50]);
    $cover = $faker->image(storage_path('app\public\media\products\covers'), 150, 150, 'technics');

    for ($i = 0; $i < rand(3,5); $i++) { $color[] = $faker->hexcolor; }
    
    return [
        'category_id' => $category,
        'subcategory_id' => $subcategory,
        'brand_id' => $brand,
        'product_name' => $name,
        'product_slug' => Str::slug($name),
        'sku' => $faker->unique()->randomNumber(6, true),
        'product_quantity' => $faker->numberBetween(0, 100),
        'product_details' => $faker->paragraphs(rand(10, 20), true),
        'product_color' => $color,
        'product_size' => $faker->randomElement([['M', 'L', 'XL', 'XXL'], ['16GB', '32GB', '64GB', '128GB'], null]),
        'product_weight' => $faker->randomFloat(2, 0.10, 2.00),
        'selling_price' => $selling_price,
        'discount_price' => $faker->boolean(25) ? priceAfterDiscount($selling_price, $faker->numberBetween(1, 8) * 10, true) : null,
        'cover' => substr($cover, strpos($cover, 'media')),
        'status' => 1,
    ];
});

