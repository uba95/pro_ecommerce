<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\ParentController;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
use Illuminate\Validation\Rule;
use App\Model\Admin\Subcategory;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MethodsTrait;

class SubCategoryController extends ParentController
{
    
    use MethodsTrait;

    public static function method($method, $id=null) {
     
        switch ($method) {
            case 'index':
                return array_values([
                    'models' => [Subcategory::with('category')->get(), Category::all()],
                    'names' => ["subcategories", "categories"],
                    'path' => 'admin.categories.subcategories',
                    'data' => [],
                ]);
                break;

            case 'store':
                return array_values([
                    'models' => [Subcategory::class],
                    'names' => ["Subcategory"],
                    'path' => '',
                    'data' => [[
                        'subcategory_name' => 'required|unique:subcategories|max:255',
                        'category_id' => 'required|numeric',
                    ], 
                    [
                        'category_id.required' => 'The category name field is required.'
                    ]],
                ]);
                break;
            
            case 'edit':
                return array_values([
                    'models' => [Subcategory::with('category')->findOrFail($id), Category::all()],
                    'names' => ["subcategory", "categories"],
                    'path' => 'admin.categories.subcategories_edit',
                    'data' => [],
                ]);
                break;
            
            case 'update':
                return array_values([
                    'models' => [Subcategory::findOrFail($id)],
                    'names' => ["Subcategory"],
                    'path' => 'admin.subcategories.index',
                    'data' => [[
                        'subcategory_name' => ['required', 'max:255', Rule::unique('subcategories')->ignore($id)],
                        'category_id' => ['required', 'numeric'],
                    ], 
                    [
                        'category_id.required' => 'The category name field is required.'
                    ]],
                ]);
                break;
            
            case 'destroy':
                return array_values([
                    'models' => [Subcategory::findOrFail($id)],
                    'names' => ["Subcategory"],
                    'path' => '',
                    'data' => [],
                ]);               
                break;
        }
    }
}
