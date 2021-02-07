<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\ParentController;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MethodsTrait;

class CategoryController extends ParentController
{
    use MethodsTrait;

    public static function method($method, $id=null) {
     
        switch ($method) {
            case 'index':
                return array_values([
                    'models' => [Category::all()],
                    'names' => ["categories"],
                    'path' => 'admin.categories.index',
                    'data' => [],
                ]);
                break;

            case 'store':
                return array_values([
                    'models' => [Category::class],
                    'names' => ["Category"],
                    'path' => '',
                    'data' => [[
                        'category_name' => 'required|unique:categories|max:255',
                    ]],
                ]);
                break;
            
            case 'edit':
                return array_values( [
                    'models' => [Category::findOrFail($id)],
                    'names' => ["category"],
                    'path' => 'admin.categories.edit',
                    'data' => [],
                ]);
                break;
            
            case 'update':
                return array_values( [
                    'models' => [Category::findOrFail($id)],
                    'names' => ["Category"],
                    'path' => 'admin.categories.index',
                    'data' => [[
                        'category_name' => ['required', 'max:255', Rule::unique('categories')->ignore($id)]
                    ]],
                ]);
                break;
            
            case 'destroy':
                return array_values([
                    'models' => [Category::findOrFail($id)],
                    'names' => ["Category"],
                    'path' => '',
                    'data' => [],
                ]);               
                break;
        }
    }

    public function show(Request $request, Category $category) {
     
        return $request->expectsJson() ? response()->json($category->subcategories) 
        : redirect()->route('admin.categories.index');
    }
}
