@php
    $category = $categories->firstWhere('id', $product->category_id);
    $subcategory = $category->subcategories->firstWhere('id' , $product->subcategory_id);
    $brand = $brands->firstWhere('id', $product->brand_id);
@endphp
<div class="container my-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href ='{{ route('shop.index', ['model' => 'category', 'slug' => $category->category_slug]) }}'>
                    {{ $category->category_name }}
                </a>
            </li>
            @if ($subcategory)
                <li class="breadcrumb-item">
                    <a href ='{{ route('shop.index', ['model' => 'subcategory', 'slug' =>  $subcategory->subcategory_slug]) }}'>
                        {{  $subcategory->subcategory_name }}
                    </a>
                </li>
            @endif

            @if ($brand)
                <li class="breadcrumb-item">
                    <a href ='{{ route('shop.index', ['model' => 'brand', 'slug' => $brand->brand_slug]) }}'>
                        {{ $brand->brand_name }}
                    </a>
                </li>
            @endif
        </ol>
    </nav>
</div>
