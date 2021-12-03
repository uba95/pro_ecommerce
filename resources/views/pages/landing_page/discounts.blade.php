@if ($discounts_products->isNotEmpty())

    <div class="best_sellers">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="tabbed_container">
                        <div class="tabs clearfix tabs-right">
                            <div class="new_arrivals_title">Get Your Discount</div>
                            <ul class="clearfix d-none">
                                <li class="active">Top 20</li>
                            </ul>
                            <div class="tabs_line"><span></span></div>
                        </div>

                        <div class="bestsellers_panel panel active">

                            <!-- Best Sellers Slider -->
                            <div class="bestsellers_slider slider">

                                <!-- Best Sellers Item -->
                                @foreach ($discounts_products as $product)
                                
                                    <div class="bestsellers_item discount">
                                        <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">
                                            <div class="bestsellers_image"><img src="{{ $product->cover }}" alt="" ></div>
                                            <div class="bestsellers_content">
                                                <div class="bestsellers_category">
                                                    @php $category =  $categories->firstWhere('id', $product->category_id) @endphp
                                                    <a href ='{{ route('shop.index', ['model' => 'category', 'slug' => $category->category_slug]) }}'>
                                                        {{ $category->category_name }}
                                                    </a>    
                                                </div>
                                                <div class="bestsellers_name">
                                                    <a href='{{ route('products.show', $product->product_slug) }}'  style="display: inline-block; width: 150px; overflow: hidden !important; text-overflow: ellipsis;white-space: nowrap;">
                                                        {{ $product->product_name }}
                                                    </a>
                                                </div>
                                                <div class="rating_r rating_r_4 bestsellers_rating {{ 'discounts_rating' . $product->id }}"></div>
                                                <div class="bestsellers_price discount">
                                                    ${{ $product->discount_price }}
                                                    <span>${{ $product->selling_price }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @auth('web')
                                        <form class="addwishlist" data-id="{{ $product->id }}"> @csrf
                                            <div class="product_fav {{ current_user()->hasProductOnWishlist($product->id) ? 'active' : ''}}" style="cursor: pointer">
                                                <i class="fas fa-heart"></i>
                                            </div>    
                                        </form>  
                                        @endauth                                
                                        <ul class="bestsellers_marks">
                                            <li class="bestsellers_mark bestsellers_discount"> -{{ $product->discount_percent  }}%</li>
                                            <li class="bestsellers_mark bestsellers_new">new</li>
                                        </ul>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        var discounts_products = @json($discounts_products);
        Object.values(discounts_products).forEach(function (product) { 
            if (avg = product.ratings[0]?.avg) {
                $(".discounts_rating" + product.id).starRating({
                starSize: 16,
                readOnly: true,
                initialRating: avg,
                ratedColor: '#3550bd',
                }) 
            }}
        )
    </script>
    @endpush
@endif
