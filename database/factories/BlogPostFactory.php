<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    
    $title = $faker->unique()->sentence;
    $post_image = $faker->image(storage_path('app\public\media\blog'), 1000, 400, 'technics');

    return [
        'category_id' => BlogCategory::pluck('id')->random(),
        'post_title' => $title,
        'post_slug' => Str::slug($title),
        'details' => $faker->paragraphs(rand(10, 20), true),
        'post_image' => substr($post_image, strpos($post_image, 'media')),
        'status' => 1,
    ];
});
