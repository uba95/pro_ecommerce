<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopProductsService
{
    private string $model;
    private string $sortOrder;
    private string $modelClass;
    private object $modelData;

    public static function getModel(string $model) : object { 

        $obj = new self;
        $obj->model =  $model;
        $obj->modelClass =  "App\Models\\" . $model;
        return $obj;
    } 

    public function findBySlug(string $slug) : object { 

        $this->modelData = $this->modelClass::findBySlugOrFail($slug);
        return $this;
    }

    public function sortBy(string $sort = null , string $order = null) : object {

        $sort ??= 'date';
        $order ??= 'desc';
        $sortBy = [
            'date' => 'id',
            'name' => 'product_name',
            'price' => 'CASE WHEN discount_price IS NULL THEN selling_price ELSE discount_price END',
            'rating' => '(SELECT AVG(VALUE) FROM product_ratings WHERE products.id = product_ratings.product_id)',
        ][$sort];
        $this->sortOrder =  $sortBy . ' ' . $order;
        return $this;
    }

    private function getName() : string {
        return $this->model . '_name';
    }

    public function getTitle(string $search = null) : string {
        return $search ?  Str::title($search) : Str::title($this->modelData->{$this->getName()});
    }

    public function getModelProducts() : HasMany {
        return $this->modelData->products()->orderByRaw($this->sortOrder);
    }

    public function searchProducts(string $search, ?string $category) : Builder {

        return Product::selection()
        ->when($category, fn($q) => $q->addSelect('categories.category_slug')
        ->join('categories', 'products.category_id', 'categories.id'))
        ->search(strtolower($search), $category)
        ->orderByRaw($this->sortOrder);
    }
}
