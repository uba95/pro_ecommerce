<div class="shop_sidebar">

    <div class="sidebar_section filter_by_section">
        <div class="sidebar_title">Filter By</div>
        <div class="sidebar_subtitle">Price</div>
        <div class="filter_price">
            <div id="slider-range" class="slider_range"></div>
        <p>Range: </p>
            <p><input type="text" id="amount" class="amount" readonly style="border:0; font-weight:bold;"></p>
        </div>
    </div>

    <div class="sidebar_section mt-5">
        <div class="sidebar_title">Categories</div>
        <ul class="sidebar_categories mt-3">
            @foreach (
                (request('model') == 'category' ? [$model] : 
                (request('model') == 'subcategory' ? [$model->category] : 
                $products->pluck('category_name', 'category_slug'))) as $slug => $category
            )
            <li>
                <a
                    @if (request()->search)
                        href ='{{ route('shop.index', request()->only('search', 'brand') + ['category' => $category->category_slug ?? $slug]) }}' 
                    @else
                        href ='{{ route('shop.index', request()->only('brand') + ['model' => 'category', 'slug' => $category->category_slug ?? $slug]) }}' 
                    @endif
                    style="color: rgba(0,0,0,0.85)">
                        {{ $category->category_name ?? $category}}
                </a>
                <ul class="small mt-1 ml-2">
                    @foreach (
                        (request('model') == 'category' ? $model->subcategories : 
                        (request('model') == 'subcategory' ? [$model] : 
                        $products->where('category_name', $category)->pluck('subcategory_name', 'subcategory_slug'))) as $slug => $subcategory
                    )
                    <li>
                        <a 
                            @if (request()->search)
                                href ='{{ route('shop.index', request()->only('search', 'brand') + ['subcategory' => $subcategory->subcategory_slug  ?? $slug]) }}' 
                            @else
                                href ='{{ route('shop.index', request()->only('brand') + ['model' => 'subcategory', 'slug' => $subcategory->subcategory_slug  ?? $slug]) }}' 
                            @endif
                            style="color: rgba(0,0,0,0.7)">
                                {{ $subcategory->subcategory_name ?? $subcategory }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="sidebar_section">
        <div class="sidebar_subtitle brands_subtitle">Brands</div>
        <ul class="brands_list">
            @foreach (
                request('model') == 'brand' 
                ? [$model] 
                : $products->pluck('brand_name', 'brand_slug') as $slug => $brand
            )
            <li class="brand">
                <a 
                    @if (request()->search)
                        href ='{{ route('shop.index', request()->only('search', 'category', 'subcategory') + ['brand' => $brand->brand_slug  ?? $slug]) }}' 
                    @else
                        href ='{{ route('shop.index', request()->only('category', 'subcategory') + ['model' => 'brand', 'slug' => $brand->brand_slug  ?? $slug]) }}' 
                    @endif
                    style="color: rgba(0,0,0,0.7)">
                        {{ $brand->brand_name ?? $brand }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
