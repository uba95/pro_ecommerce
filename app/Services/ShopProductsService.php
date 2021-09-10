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
    public ?object $modelData = null;

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
            'date' => 'products.id',
            'name' => 'products.product_name',
            'price' => 'CASE WHEN products.discount_price IS NULL THEN products.selling_price ELSE products.discount_price END',
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

        return $this->modelData->products()->shop()->orderByRaw($this->sortOrder);
    }

    public function searchProducts(string $search, ?string $category, ?string $subcategory, ?string $brand) : Builder {

        return Product::selection()->shop()
        ->search(strtolower($search), $category, $subcategory, $brand)
        ->orderByRaw($this->sortOrder);
    }
}

// ->when($category, fn($q) => $q->with('category')->whereHas('category', fn($q) => $q->where('category_slug', $category)))
// ->when($subcategory, fn($q) => $q->with('subcategory')->whereHas('subcategory', fn($q) => $q->where('subcategory_slug', $subcategory)))
// ->when($brand, fn($q) => $q->with('brand')->whereHas('brand', fn($q) => $q->where('brand_slug', $brand)))
