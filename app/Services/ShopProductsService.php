<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;

class ShopProductsService
{
    private $model;
    private $sortOrder;
    private $modelClass;
    private $modelData;

    public static function getModel($model) { 
        $obj = new self;
        $obj->model =  $model;
        $obj->modelClass =  "App\Models\\" . $model;
        return $obj;
    } 

    public function findBySlug($slug) { 
        $this->modelData = $this->modelClass::findBySlugOrFail($slug);
        return $this;
    }

    public function sortBy($sort = null , $order = null) {
        $sort ??= 'date';
        $order ??= 'desc';

        $sortBy = [
            'date' => 'id',
            'name' => 'product_name',
            'price' => 'CASE WHEN discount_price IS NULL THEN selling_price ELSE discount_price END',
        ][$sort];
        $this->sortOrder =  $sortBy . ' ' . $order;
        return $this;
    }

    private function getName() {
        return $this->model . '_name';
    }

    public function getTitle($search = null) {
        return $search ?  Str::title($search) : Str::title($this->modelData->{$this->getName()});
    }

    public function getModelProducts() {
        return $this->modelData->products()->orderByRaw($this->sortOrder);
    }

    public function searchProducts($search, $category) {
        return Product::selection()
        ->when($category, fn($q) => $q->addSelect('categories.category_slug')
        ->join('categories', 'products.category_id', 'categories.id'))
        ->search(strtolower($search), $category)
        ->orderByRaw($this->sortOrder);
    }
}
