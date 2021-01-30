<?php

use App\Admin;
use App\Model\Admin\Brand;
use App\Model\Admin\Category;
use App\Model\Admin\Subcategory;
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
        // $this->call(UsersTableSeeder::class);
        $now = Carbon::now()->toDateTimeString();

        Admin::insert([
            [ 'name' => 'aaa', 'email' => '123@gmail.com', 'password' => bcrypt(111), 'created_at'=>$now, 'updated_at'=>$now],
            [ 'name' => 'bbb', 'email' => 'bb@gmail.com', 'password' => bcrypt(111), 'created_at'=>$now, 'updated_at'=>$now],
        ]);
        
        Category::insert([
            [ 'category_name' => 'Mens Fashion', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_name' => 'Womens Fashion', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_name' => 'Childs', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_name' => 'Watches', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_name' => 'Furniture', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_name' => 'Electronics', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_name' => 'Health & Beauty', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_name' => 'Sports & Outdoor ', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_name' => 'Home & Living', 'created_at'=>$now, 'updated_at'=>$now],
        ]);

        Subcategory::insert([
            [ 'category_id' => '1', 'subcategory_name' => 'Mens Tshirts', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '1', 'subcategory_name' => 'Mens Shirts', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '1', 'subcategory_name' => 'Mens Pants', 'created_at'=>$now, 'updated_at'=>$now],

            [ 'category_id' => '2', 'subcategory_name' => 'Womens Tshirts', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '2', 'subcategory_name' => 'Womens Shirts ', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '2', 'subcategory_name' => 'Womens Pants', 'created_at'=>$now, 'updated_at'=>$now],

            [ 'category_id' => '3', 'subcategory_name' => 'Child Dress & Footware', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '3', 'subcategory_name' => 'Child Body Care', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '3', 'subcategory_name' => 'Child Diaper', 'created_at'=>$now, 'updated_at'=>$now],

            [ 'category_id' => '4', 'subcategory_name' => 'Mens Watches', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '4', 'subcategory_name' => 'Womans Watches', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '4', 'subcategory_name' => 'Kids Watches', 'created_at'=>$now, 'updated_at'=>$now],

            [ 'category_id' => '5', 'subcategory_name' => 'Tables', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '5', 'subcategory_name' => 'Chairs', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '5', 'subcategory_name' => 'Sofas', 'created_at'=>$now, 'updated_at'=>$now],

            [ 'category_id' => '6', 'subcategory_name' => 'Computers & Labtops', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '6', 'subcategory_name' => 'Phones', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '6', 'subcategory_name' => 'Consoles', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '6', 'subcategory_name' => 'Cameras', 'created_at'=>$now, 'updated_at'=>$now],

            [ 'category_id' => '7', 'subcategory_name' => 'Body Spray', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '7', 'subcategory_name' => 'Finger Ring', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '7', 'subcategory_name' => 'Jewelry', 'created_at'=>$now, 'updated_at'=>$now],

            [ 'category_id' => '8', 'subcategory_name' => 'Exercise & Fitness', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '8', 'subcategory_name' => 'Golf', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '8', 'subcategory_name' => 'Camping', 'created_at'=>$now, 'updated_at'=>$now],

            [ 'category_id' => '9', 'subcategory_name' => 'Appliances', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '9', 'subcategory_name' => 'Room Decoration', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '9', 'subcategory_name' => 'Light and Lamp', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'category_id' => '9', 'subcategory_name' => 'Security', 'created_at'=>$now, 'updated_at'=>$now],
        ]);

        Brand::insert([
            [ 'brand_name' => 'Sony', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Lenovo', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Assus', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Cannon', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Dell', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Gucci', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Levis', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Nike', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Adidas', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Apple', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Samsung', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Rolex', 'created_at'=>$now, 'updated_at'=>$now],
            [ 'brand_name' => 'Omega', 'created_at'=>$now, 'updated_at'=>$now],
        ]);

    }
}