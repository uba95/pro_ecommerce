<?php

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BlogCategory::class, 5)->create()->each(function ($category) {   
            factory(BlogPost::class, rand(1, 5))->create(['category_id' => $category->id]);
        });;
    }
}
