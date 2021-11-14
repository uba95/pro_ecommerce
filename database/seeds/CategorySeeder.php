<?php


use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = ['created_at'=> now(), 'updated_at'=> now()];
        
        Category::insert(array_map(fn($v) => 
            Arr::add($v, 'category_slug', Str::slug($v['category_name'], '-')) + $time,
            [
                [ 'category_name' => 'Mens Fashion'],
                [ 'category_name' => 'Womens Fashion'],
                [ 'category_name' => 'Childs'],
                [ 'category_name' => 'Watches'],
                [ 'category_name' => 'Furniture'],
                [ 'category_name' => 'Electronics'],
                [ 'category_name' => 'Health & Beauty'],
                [ 'category_name' => 'Sports & Outdoor '],
                [ 'category_name' => 'Home & Living'],
            ]
        ));

        Subcategory::insert(array_map(fn($v) => 
            Arr::add($v, 'subcategory_slug', Str::slug($v['subcategory_name'], '-')) + $time,
            [
                [ 'category_id' => '1', 'subcategory_name' => 'Mens Tshirts'],
                [ 'category_id' => '1', 'subcategory_name' => 'Mens Shirts'],
                [ 'category_id' => '1', 'subcategory_name' => 'Mens Pants'],

                [ 'category_id' => '2', 'subcategory_name' => 'Womens Tshirts'],
                [ 'category_id' => '2', 'subcategory_name' => 'Womens Shirts '],
                [ 'category_id' => '2', 'subcategory_name' => 'Womens Pants'],

                [ 'category_id' => '3', 'subcategory_name' => 'Child Dress & Footware'],
                [ 'category_id' => '3', 'subcategory_name' => 'Child Body Care'],
                [ 'category_id' => '3', 'subcategory_name' => 'Child Diaper'],

                [ 'category_id' => '4', 'subcategory_name' => 'Mens Watches'],
                [ 'category_id' => '4', 'subcategory_name' => 'Womans Watches'],
                [ 'category_id' => '4', 'subcategory_name' => 'Kids Watches'],

                [ 'category_id' => '5', 'subcategory_name' => 'Tables'],
                [ 'category_id' => '5', 'subcategory_name' => 'Chairs'],
                [ 'category_id' => '5', 'subcategory_name' => 'Sofas'],

                [ 'category_id' => '6', 'subcategory_name' => 'Computers & Labtops'],
                [ 'category_id' => '6', 'subcategory_name' => 'Phones'],
                [ 'category_id' => '6', 'subcategory_name' => 'Consoles'],
                [ 'category_id' => '6', 'subcategory_name' => 'Cameras'],

                [ 'category_id' => '7', 'subcategory_name' => 'Body Spray'],
                [ 'category_id' => '7', 'subcategory_name' => 'Finger Ring'],
                [ 'category_id' => '7', 'subcategory_name' => 'Jewelry'],

                [ 'category_id' => '8', 'subcategory_name' => 'Exercise & Fitness'],
                [ 'category_id' => '8', 'subcategory_name' => 'Golf'],
                [ 'category_id' => '8', 'subcategory_name' => 'Camping'],

                [ 'category_id' => '9', 'subcategory_name' => 'Appliances'],
                [ 'category_id' => '9', 'subcategory_name' => 'Room Decoration'],
                [ 'category_id' => '9', 'subcategory_name' => 'Light and Lamp'],
                [ 'category_id' => '9', 'subcategory_name' => 'Security'],
            ]
        ));

        Brand::insert(array_map(fn($v) => 
            Arr::add($v, 'brand_slug', Str::slug($v['brand_name'], '-')) + $time,
            [
                [ 'brand_name' => 'Sony'],
                [ 'brand_name' => 'Lenovo'],
                [ 'brand_name' => 'Assus'],
                [ 'brand_name' => 'Cannon'],
                [ 'brand_name' => 'Dell'],
                [ 'brand_name' => 'Gucci'],
                [ 'brand_name' => 'Levis'],
                [ 'brand_name' => 'Nike'],
                [ 'brand_name' => 'Adidas'],
                [ 'brand_name' => 'Apple'],
                [ 'brand_name' => 'Samsung'],
                [ 'brand_name' => 'Rolex'],
                [ 'brand_name' => 'Omega'],
            ]
        ));
    }
}
