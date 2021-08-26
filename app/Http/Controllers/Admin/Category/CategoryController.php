<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('can:view categories',    ['only' => ['index', 'show']]);
        $this->middleware('can:create categories',  ['only' => ['create', 'store']]);
        $this->middleware('can:edit categories',    ['only' => ['edit', 'update']]);
        $this->middleware('can:delete categories',  ['only' => ['destroy']]);
    }

    public function index() {
        return view('admin.categories.index', ['categories' => Category::all()]);
    }

    public function show(Request $request, Category $category) {
        return $request->expectsJson() ? response()->json($category->subcategories) 
        : redirect()->route('admin.categories.index');
    }

    public function store(Request $request) { 
        $validatedData = $request->validate(['category_name' => 'required|unique:categories|max:50']);
        Category::create($validatedData);
        return redirect()->back()->with(toastNotification('Category', 'created'));
    }

    public function edit(Category $category) {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Category $category, Request $request) {
        $validatedData = $request->validate([
            'category_name' => ['required', 'max:50', Rule::unique('categories')->ignore($category->id)],
        ]);
        $category->update($validatedData);
        return redirect()->route('admin.categories.index')->with(toastNotification('Category', 'updated'));
    }
    
    public function destroy(Category $category) {
        $category->delete();
        return redirect()->back()->with(toastNotification('Category', 'deleted'));
    }
}