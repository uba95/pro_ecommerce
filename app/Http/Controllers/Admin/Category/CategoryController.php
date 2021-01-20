<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Model\Admin\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function categories() {
     
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
}
