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
                [ 'category_name' => 'Desktop'],
                [ 'category_name' => 'Labtop'],
                [ 'category_name' => 'Mobile'],
                [ 'category_name' => 'TV'],
                [ 'category_name' => 'Camera'],
                [ 'category_name' => 'Console'],
            ]
        ));

        Subcategory::insert(array_map(fn($v) => 
            Arr::add($v, 'subcategory_slug', Str::slug($v['subcategory_name'], '-')) + $time,
            [
                [ 'category_id' => '1', 'subcategory_name' => 'Computer Motherboards'],
                [ 'category_id' => '1', 'subcategory_name' => 'Computer Graphic Cards'],
                [ 'category_id' => '1', 'subcategory_name' => 'Computer Cpus'],
                [ 'category_id' => '1', 'subcategory_name' => 'Computer Accessories'],
                [ 'category_id' => '6', 'subcategory_name' => 'Playstion'],
                [ 'category_id' => '6', 'subcategory_name' => 'Xbox'],
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
                [ 'brand_name' => 'Apple'],
                [ 'brand_name' => 'Samsung'],
                [ 'brand_name' => 'Hp'],
            ]
        ));
    }
}
