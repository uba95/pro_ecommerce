<?php

use App\Admin;
use App\Model\Address;
use App\Model\Admin\Brand;
use App\Model\Admin\Category;
use App\Model\Admin\Product;
use App\Model\Admin\Subcategory;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MyCountryTableSeeder::class);
        $time = ['created_at'=> now(), 'updated_at'=> now()];

        Admin::insert([
            [ 'name' => 'aaa', 'email' => '123@gmail.com', 'password' => bcrypt(111)] + $time,
            [ 'name' => 'bbb', 'email' => 'bb@gmail.com', 'password' => bcrypt(111)] + $time,
        ]);
        
        Category::insert([
            [ 'category_name' => 'Mens Fashion'] + $time,
            [ 'category_name' => 'Womens Fashion'] + $time,
            [ 'category_name' => 'Childs'] + $time,
            [ 'category_name' => 'Watches'] + $time,
            [ 'category_name' => 'Furniture'] + $time,
            [ 'category_name' => 'Electronics'] + $time,
            [ 'category_name' => 'Health & Beauty'] + $time,
            [ 'category_name' => 'Sports & Outdoor '] + $time,
            [ 'category_name' => 'Home & Living'] + $time,
        ]);

        Subcategory::insert([
            [ 'category_id' => '1', 'subcategory_name' => 'Mens Tshirts'] + $time,
            [ 'category_id' => '1', 'subcategory_name' => 'Mens Shirts'] + $time,
            [ 'category_id' => '1', 'subcategory_name' => 'Mens Pants'] + $time,

            [ 'category_id' => '2', 'subcategory_name' => 'Womens Tshirts'] + $time,
            [ 'category_id' => '2', 'subcategory_name' => 'Womens Shirts '] + $time,
            [ 'category_id' => '2', 'subcategory_name' => 'Womens Pants'] + $time,

            [ 'category_id' => '3', 'subcategory_name' => 'Child Dress & Footware'] + $time,
            [ 'category_id' => '3', 'subcategory_name' => 'Child Body Care'] + $time,
            [ 'category_id' => '3', 'subcategory_name' => 'Child Diaper'] + $time,

            [ 'category_id' => '4', 'subcategory_name' => 'Mens Watches'] + $time,
            [ 'category_id' => '4', 'subcategory_name' => 'Womans Watches'] + $time,
            [ 'category_id' => '4', 'subcategory_name' => 'Kids Watches'] + $time,

            [ 'category_id' => '5', 'subcategory_name' => 'Tables'] + $time,
            [ 'category_id' => '5', 'subcategory_name' => 'Chairs'] + $time,
            [ 'category_id' => '5', 'subcategory_name' => 'Sofas'] + $time,

            [ 'category_id' => '6', 'subcategory_name' => 'Computers & Labtops'] + $time,
            [ 'category_id' => '6', 'subcategory_name' => 'Phones'] + $time,
            [ 'category_id' => '6', 'subcategory_name' => 'Consoles'] + $time,
            [ 'category_id' => '6', 'subcategory_name' => 'Cameras'] + $time,

            [ 'category_id' => '7', 'subcategory_name' => 'Body Spray'] + $time,
            [ 'category_id' => '7', 'subcategory_name' => 'Finger Ring'] + $time,
            [ 'category_id' => '7', 'subcategory_name' => 'Jewelry'] + $time,

            [ 'category_id' => '8', 'subcategory_name' => 'Exercise & Fitness'] + $time,
            [ 'category_id' => '8', 'subcategory_name' => 'Golf'] + $time,
            [ 'category_id' => '8', 'subcategory_name' => 'Camping'] + $time,

            [ 'category_id' => '9', 'subcategory_name' => 'Appliances'] + $time,
            [ 'category_id' => '9', 'subcategory_name' => 'Room Decoration'] + $time,
            [ 'category_id' => '9', 'subcategory_name' => 'Light and Lamp'] + $time,
            [ 'category_id' => '9', 'subcategory_name' => 'Security'] + $time,
        ]);

        Brand::insert([
            [ 'brand_name' => 'Sony'] + $time,
            [ 'brand_name' => 'Lenovo'] + $time,
            [ 'brand_name' => 'Assus'] + $time,
            [ 'brand_name' => 'Cannon'] + $time,
            [ 'brand_name' => 'Dell'] + $time,
            [ 'brand_name' => 'Gucci'] + $time,
            [ 'brand_name' => 'Levis'] + $time,
            [ 'brand_name' => 'Nike'] + $time,
            [ 'brand_name' => 'Adidas'] + $time,
            [ 'brand_name' => 'Apple'] + $time,
            [ 'brand_name' => 'Samsung'] + $time,
            [ 'brand_name' => 'Rolex'] + $time,
            [ 'brand_name' => 'Omega'] + $time,
        ]);

        Product::insert([[
            'category_id' => '1', 'subcategory_id' => '1', 'brand_id' => '7',
            'product_name' => 'Product1', 'product_code' => '111', 'product_quantity' => '222', 'product_weight' => '0.5',
            'product_details' => 'Product1', 'product_color' => '["black"]', 'product_size' => '["xl"]',
            'discount_price' => '99', 'selling_price' => '199', 'status' => '1', 'main_slider' => 1
            ] + $time,
            [
            'category_id' => '1', 'subcategory_id' => '1', 'brand_id' => '7',
            'product_name' => 'Product2', 'product_code' => '222', 'product_quantity' => '222', 'product_weight' => '0.5',
            'product_details' => 'Product2', 'product_color' => '["black"]', 'product_size' => '["xl"]',
            'discount_price' => null, 'selling_price' => '99', 'status' => '1', 'main_slider' => 1
            ] + $time,
        ]);

        User::insert([
            [ 'name' => 'Ubaida Awad', 'email' => '123@gmail.com', 'password' => bcrypt(111)] + $time,
            [ 'name' => 'Jon Doe', 'email' => 'bb@gmail.com', 'password' => bcrypt(111)] + $time,
        ]);

        Address::insert([
            ['alias' => 'home', 'address_1' => 'add1', 'address_2' => 'add2', 'zip' => '80911',
            'city' => 'Simla', 'country_id' => '226', 'user_id' => 1, 'phone' => '719-541-4872'] + $time,

            ['alias' => 'office', 'address_1' => 'add11', 'address_2' => 'add22', 'zip' => '44139',
            'city' => 'Solon', 'country_id' => '226', 'user_id' => 1, 'phone' => '440-349-7867'] + $time,
        ]);
    }
}
