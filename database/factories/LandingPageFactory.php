<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LandingPageItem;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(LandingPageItem::class, function (Faker $faker) {

    $type = collect(['is_main_banner', 'is_banner_slider', 'is_advert'])->random();
    $data = [];

    switch ($type) {
        
        case 'is_main_banner':
            $img = $faker->image(storage_path('app\public\\'. LandingPageItem::IMAGES_STOREAGE), 600, 400, 'technics');
            $data = [
                'is_main_banner' => 1,
                'product_id' => factory(Product::class),
                'main_banner_text' => $faker->text(50),
                'main_banner_img' => substr($img, strpos($img, 'media'))
            ];
            break;

        case 'is_banner_slider':
            $img = $faker->image(storage_path('app\public\\'. LandingPageItem::IMAGES_STOREAGE), 700, 500, 'technics');
            $data = [
                'is_banner_slider' => 1,
                'product_id' => factory(Product::class),
                'banner_slider_text' => $faker->text(200),
                'banner_slider_img' => substr($img, strpos($img, 'media'))
            ];
            break;
            
        case 'is_advert':
            $img = $faker->image(storage_path('app\public\\'. LandingPageItem::IMAGES_STOREAGE), 180, 200, 'technics');
            $data = [
                'is_advert' => 1,
                'advert_headline' => $faker->text(20),
                'advert_text' => $faker->text(80),
                'advert_img' => substr($img, strpos($img, 'media'))];
            break;
    }
    
    return $data + ['status' => 1];
});
