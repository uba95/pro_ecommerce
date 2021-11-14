@if ($trend_year_products->isNotEmpty())
    <div class="trends">
        <div class="trends_background" style="background-image:url({{ asset('frontend/images/trends_background.jpg')}})"></div>
        <div class="trends_overlay"></div>
        <div class="container">
            <div class="row">

                <!-- Trends Content -->
                <div class="col-lg-3">
                    <div class="trends_container">
                        <h2 class="trends_title">Trends {{ now()->year }}</h2>
                        {{-- <div class="trends_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing Donec et.</p></div> --}}
                        <div class="trends_slider_nav">
                            <div class="trends_prev trends_nav"><i class="fas fa-angle-left ml-auto"></i></div>
                            <div class="trends_next trends_nav"><i class="fas fa-angle-right ml-auto"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Trends Slider -->
                <div class="col-lg-9">
                    <div class="trends_slider_container">

                        <!-- Trends Slider -->
                        <div class="owl-carousel owl-theme trends_slider">

                            @foreach ($trend_year_products as $product)
                                <!-- Trends Slider Item -->
                                <div class="owl-item">
                                    <div class="trends_item {{ $product->discount_price ? 'discount' :  ($product->isNew() ? 'is_new' : '') }}">
                                        <div class="trends_image d-flex flex-column align-items-center justify-content-center">
                                            <img src="{{ $product->cover }}" alt="">
                                        </div>
                                        <div class="trends_content">
                                            <div class="trends_category">
                                                @php $category =  $categories->firstWhere('id', $product->category_id) @endphp
                                                <a href ='{{ route('shop.index', ['model' => 'category', 'slug' => $category->category_slug]) }}'>
                                                    {{ $category->category_name }}
                                                </a>    
                                        </div>
                                            <div class="trends_info clearfix">
                                                <div class="trends_name">
                                                    <a href='{{ route('products.show', $product->product_slug) }}'>{{ $product->product_name }}</a>
                                                </div>
                                                <div class="trends_price">${{ $product->discount_price ?? $product->selling_price }}</div>
                                            </div>
                                        </div>
                                        <ul class="trends_marks">
                                            <li class="trends_mark trends_discount"> -{{ $product->discount_percent  }}%</li>
                                            <li class="trends_mark trends_new">new</li>
                                        </ul>

                                        @auth('web')
                                        <form class="addwishlist" data-id="{{ $product->id }}"> @csrf
                                            <div class="trends_fav {{ current_user()->hasProductOnWishlist($product->id) ? 'active' : ''}}">
                                                <i class="fas fa-heart"></i>
                                            </div>    
                                        </form>  
                                        @endauth

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

