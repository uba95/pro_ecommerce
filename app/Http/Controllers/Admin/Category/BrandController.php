<?php

namespace App\Http\Controllers\Admin\Category;

use App\Model\Admin\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\MethodsTrait;

class BrandController extends ParentController
{
    

    use MethodsTrait;

    public static function method($method, $id=null) {
     
        switch ($method) {
            case 'index':
                return array_values([
                    'models' => [Brand::all()],
                    'names' => ["brands"],
                    'path' => 'admin.categories.brands',
                    'data' => [],
                ]);
                break;

            case 'store':
                return array_values([
                    'models' => [Brand::class],
                    'names' => ["Brand"],
                    'path' => '',
                    'data' => [[
                        'brand_name' => 'required|unique:brands|max:255',
                        'brand_logo' => 'image|max:4096',
                    ]],
                ]);
                break;
            
            case 'edit':
                return array_values([
                    'models' => [Brand::findOrFail($id)],
                    'names' => ["brand"],
                    'path' => 'admin.categories.brands_edit',
                    'data' => [],
                ]);
                break;
            
            case 'update':
                return array_values([
                    'models' => [Brand::findOrFail($id)],
                    'names' => ["Brand"],
                    'path' => 'admin.brands.index',
                    'data' => [[
                        'brand_name' => ['required', 'max:255', Rule::unique('brands')->ignore($id)],
                        'brand_logo' => ['image', 'max:4096'],
                    ]],
                ]);
                break;
            
            case 'destroy':
                return array_values([
                    'models' => [Brand::findOrFail($id)],
                    'names' => ["Brand"],
                    'path' => '',
                    'data' => [],
                ]);               
                break;
        }
    }
}
