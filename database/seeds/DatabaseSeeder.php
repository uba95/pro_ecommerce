<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Address;
use App\Models\BrandCategory;
use App\Models\Product;
use App\Models\Category;
use App\Models\SiteSettings;
use App\Models\Subcategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Truncate all tables, except migrations
        $database = 'Tables_in_' . DB::getDatabaseName();
        DB::statement("SET foreign_key_checks=0");
        foreach (DB::select('SHOW TABLES') as $table) {
            if ($table->{$database} !== 'migrations')
                DB::table($table->{$database})->truncate();
        }
        DB::statement("SET foreign_key_checks=1");

        $this->call(MyCountryTableSeeder::class);
        $this->call(PermissionSeeder::class);

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

        Product::insert(array_map(fn($v) => 
        Arr::add($v, 'product_slug', Str::slug($v['product_name'], '-')) + $time,
            [
                [
                'category_id' => '1', 'subcategory_id' => '1', 'brand_id' => '10',
                'product_name' => 'Product1', 'sku' => '111', 'product_quantity' => '222', 'product_weight' => '0.5',
                'product_details' => 'Product1', 'product_color' => '["black"]', 'product_size' => '["xl"]',
                'discount_price' => '100', 'selling_price' => '200', 'status' => '1', 'main_slider' => 1
                ],
                [
                'category_id' => '1', 'subcategory_id' => '1', 'brand_id' => '10',
                'product_name' => 'Product2', 'sku' => '222', 'product_quantity' => '222', 'product_weight' => '0.5',
                'product_details' => 'Product2', 'product_color' => '["black"]', 'product_size' => '["xl"]',
                'discount_price' => null, 'selling_price' => '150', 'status' => '1', 'main_slider' => 1
                ],
                [
                'category_id' => '1', 'subcategory_id' => '1', 'brand_id' => '10',
                'product_name' => 'Product3', 'sku' => '11', 'product_quantity' => '22', 'product_weight' => '0.1',
                'product_details' => 'Product1', 'product_color' => '["black", "red"]', 'product_size' => '["xl"]',
                'discount_price' => '15', 'selling_price' => '20', 'status' => '1', 'main_slider' => 1
                ],
                [
                'category_id' => '1', 'subcategory_id' => '1', 'brand_id' => '7',
                'product_name' => 'Product4', 'sku' => '22', 'product_quantity' => '22', 'product_weight' => '0.1',
                'product_details' => 'Product2', 'product_color' => '["black"]', 'product_size' => '["xl", "xxl"]',
                'discount_price' => null, 'selling_price' => '50', 'status' => '1', 'main_slider' => 1
                ],    
            ]
        ));

        User::insert(array_map(fn($v) => $v + $time,
            [
                [ 'name' => 'Ubaida Awad', 'email' => '123@gmail.com', 'password' => bcrypt(111)],
                [ 'name' => 'Jon Doe', 'email' => 'bb@gmail.com', 'password' => bcrypt(111)],
            ]   
        ));

        Address::insert(array_map(fn($v) => $v + $time,
            [
                ['alias' => 'home', 'address_1' => 'add1', 'address_2' => 'add2', 'zip' => '80911',
                'city' => 'Simla', 'country_id' => '226', 'user_id' => 1, 'phone' => '719-541-4872'],

                ['alias' => 'office', 'address_1' => 'add11', 'address_2' => 'add22', 'zip' => '44139',
                'city' => 'Solon', 'country_id' => '226', 'user_id' => 1, 'phone' => '440-349-7867'],
            ]
        ));

        SiteSettings::insert(
            [
                'phone' =>	'719-541-4872',
                'email' =>	'123@gmail.com',
                'address' =>	'home1',
                'facebook' => 'facebook.com',
                'youtube' => 	'youtube.com',
                'twitter' => 	'twitter.com',
            ] +  $time
        );
    }
}
