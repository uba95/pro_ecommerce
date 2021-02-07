<?php
namespace App\Http\ViewComposers;

use App\Model\Admin\Category;
use Illuminate\View\View;

class CategoryComposer {
    

    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }


    public function composer(View $view) {
     
        return $view->with('categories', Category::with('subcategories:category_id,subcategory_name')->get());
    }
}