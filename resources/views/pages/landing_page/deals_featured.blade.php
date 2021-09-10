<div class="deals_featured">
    <div class="container">
        <div class="row">
            <div class="col d-flex flex-lg-row flex-column align-items-center justify-content-start">
                
                <!-- Deals -->

                <div class="deals">
                    <div class="deals_title">Deals of the Week</div>
                    <div class="deals_slider_container">
                        
                        <!-- Deals Slider -->
                        <div class="owl-carousel owl-theme deals_slider">
                            
                            <!-- Deals Item -->
                            @foreach ($hot_deal_products as $deal)
                            <div class="owl-item deals_item">
                                <div class="deals_image"><img src="{{ $deal->product->cover }}" alt=""></div>
                                <div class="deals_content">
                                    <div class="deals_info_line d-flex flex-row justify-content-start">
                                        <div class="deals_item_category"><a href="#">{{ optional($deal->product->brand)->brand_name }}</a></div>
                                        <div class="deals_item_price_a ml-auto">${{ $deal->product->selling_price }}</div>
                                    </div>
                                    <div class="deals_info_line d-flex flex-row justify-content-start">
                                        <div class="deals_item_name"><a href='{{ route('products.show', $deal->product->product_slug) }}'>{{ $deal->product->product_name}}</a></div>
                                        <div class="deals_item_price ml-auto">${{ $deal->product->discount_price }}</div>
                                    </div>
                                    <div class="available">
                                        <div class="available_line d-flex flex-row justify-content-start">
                                            <div class="available_title">Available: <span>{{ $deal->product->product_quantity }}</span></div>
                                            <div class="sold_title ml-auto">Already sold: <span>28</span></div>
                                        </div>
                                        <div class="available_bar"><span style="width:17%"></span></div>
                                    </div>
                                    <div class="deals_timer d-flex flex-row align-items-center justify-content-start">
                                        <div class="deals_timer_title_container">
                                            <div class="deals_timer_title">Hurry Up</div>
                                            <div class="deals_timer_subtitle">Offer ends in:</div>
                                        </div>
                                        <div class="deals_timer_content ml-auto">
                                            <div class="deals_timer_box clearfix" data-target-time="{{ $deal->expired_at }}">
                                                <div class="deals_timer_unit">
                                                    <div id="deals_timer1_hr" class="deals_timer_hr"></div>
                                                    <span>hours</span>
                                                </div>
                                                <div class="deals_timer_unit">
                                                    <div id="deals_timer1_min" class="deals_timer_min"></div>
                                                    <span>mins</span>
                                                </div>
                                                <div class="deals_timer_unit">
                                                    <div id="deals_timer1_sec" class="deals_timer_sec"></div>
                                                    <span>secs</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="deals_slider_nav_container">
                        <div class="deals_slider_prev deals_slider_nav"><i class="fas fa-chevron-left ml-auto"></i></div>
                        <div class="deals_slider_next deals_slider_nav"><i class="fas fa-chevron-right ml-auto"></i></div>
                    </div>
                </div>
                
                <!-- Featured -->
                <div class="featured">
                    <div class="tabbed_container">
                        <div class="tabs">
                            <ul class="clearfix">
                                <li class="active">Featured</li>
                                <li>Trend</li>
                                <li>Best Rated</li>
                            </ul>
                            <div class="tabs_line"><span></span></div>
                        </div>

                        <!-- Product Panel -->
                        <div class="product_panel panel active">
                            <div class="featured_slider slider">

                                <!-- Slider Item -->
                                @foreach (range(1,1) as $item)
                                @foreach ($featured_products as $product)
                                <div class="featured_slider_item">
                                    <div class="border_active"></div>
                                    <div class="product_item  d-flex flex-column align-items-center justify-content-center text-center {{ $product->discount_price ? 'discount' :  ($product->hot_new ? 'is_new' : '') }}">
                                        <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ $product->cover}}" alt="" height="120" width="100"></div>
                                        <div class="product_content">
                                                @if ($product->discount_price)
                                                <div class="product_price discount">
                                                    ${{$product->discount_price}}
                                                    <span style="text-decoration: line-through #00000060;">
                                                        {{   '$' . $product->selling_price }}
                                                    </span>
                                                </div>
                                                @else
                                                <div class="product_price">
                                                    ${{$product->selling_price}}
                                                </div>
                                            @endif
                                            <div class="product_name"><div><a href='{{ route('products.show', $product->product_slug) }}'>{{ $product->product_name}}</a></div></div>
                                            <div class="product_extras">
                                                <div class="product_color">
                                                    <input type="radio" checked name="product_color" style="background:#b19c83">
                                                    <input type="radio" name="product_color" style="background:#000000">
                                                    <input type="radio" name="product_color" style="background:#999999">
                                                </div>
                                                {{-- <form class="addcart" data-id="{{ $product->id }}"> @csrf
                                                    <button class="product_cart_button">Add to Cart</button>
                                                </form>   --}}
                                            </div>
                                        </div>
                                        
                                        @auth('web')
                                        <form class="addwishlist" data-id="{{ $product->id }}"> @csrf
                                            <div class="product_fav {{ current_user()->hasProductOnWishlist($product->id) ? 'active' : ''}}">
                                                <i class="fas fa-heart"></i>
                                            </div>    
                                        </form>  
                                        @endauth

                                        <ul class="product_marks">
                                            <li class="product_mark product_discount">
                                                -{{ $product->discount_percent  }}%
                                            </li>
                                            <li class="product_mark product_new">new</li>
                                        </ul>
                                    </div>
                                </div>
                                @endforeach

                                @endforeach
                            </div>
                            <div class="featured_slider_dots_cover"></div>
                        </div>
                        <!-- Product Panel -->
                        <div class="product_panel panel">
                            <div class="featured_slider slider">

                                <!-- Slider Item -->
                                @foreach ($trend_products as $product)
                                <div class="featured_slider_item">
                                    <div class="border_active"></div>
                                    <div class="product_item  d-flex flex-column align-items-center justify-content-center text-center {{ $product->discount_price ? 'discount' :  ($product->hot_new ? 'is_new' : '') }}">
                                        <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ $product->cover}}" alt="" height="120" width="100"></div>
                                        <div class="product_content">
                                                @if ($product->discount_price)
                                                <div class="product_price discount">
                                                    ${{$product->discount_price}}
                                                    <span style="text-decoration: line-through #00000060;">
                                                        {{   '$' . $product->selling_price }}
                                                    </span>
                                                </div>
                                                @else
                                                <div class="product_price">
                                                    ${{$product->selling_price}}
                                                </div>
                                            @endif
                                            <div class="product_name"><div><a href="product.html">{{ $product->product_name}}</a></div></div>
                                            <div class="product_extras">
                                                <div class="product_color">
                                                    <input type="radio" checked name="product_color" style="background:#b19c83">
                                                    <input type="radio" name="product_color" style="background:#000000">
                                                    <input type="radio" name="product_color" style="background:#999999">
                                                </div>
                                                <button class="product_cart_button">Add to Cart</button>
                                            </div>
                                        </div>

                                        <div class="product_fav addwishlist" data-id="{{ $product->id }}">
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <ul class="product_marks">
                                            <li class="product_mark product_discount">
                                                -{{ intval((($product->selling_price - $product->discount_price) / $product->selling_price) * 100)  }}%
                                            </li>
                                            <li class="product_mark product_new">new</li>
                                        </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="featured_slider_dots_cover"></div>
                        </div>
                        <!-- Product Panel -->
                        <div class="product_panel panel">
                            <div class="featured_slider slider">

                                <!-- Slider Item -->
                                @foreach ($best_rated_products as $product)
                                <div class="featured_slider_item">
                                    <div class="border_active"></div>
                                    <div class="product_item  d-flex flex-column align-items-center justify-content-center text-center {{ $product->discount_price ? 'discount' :  ($product->hot_new ? 'is_new' : '') }}">
                                        <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ $product->cover}}" alt="" height="120" width="100"></div>
                                        <div class="product_content">
                                                @if ($product->discount_price)
                                                <div class="product_price discount">
                                                    ${{$product->discount_price}}
                                                    <span style="text-decoration: line-through #00000060;">
                                                        {{   '$' . $product->selling_price }}
                                                    </span>
                                                </div>
                                                @else
                                                <div class="product_price">
                                                    ${{$product->selling_price}}
                                                </div>
                                            @endif
                                            <div class="product_name"><div><a href="product.html">{{ $product->product_name}}</a></div></div>
                                            <div class="product_extras">
                                                <div class="product_color">
                                                    <input type="radio" checked name="product_color" style="background:#b19c83">
                                                    <input type="radio" name="product_color" style="background:#000000">
                                                    <input type="radio" name="product_color" style="background:#999999">
                                                </div>
                                                <button class="product_cart_button">Add to Cart</button>
                                            </div>
                                        </div>

                                        <div class="product_fav addwishlist" data-id="{{ $product->id }}">
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <ul class="product_marks">
                                            <li class="product_mark product_discount">
                                                -{{ intval((($product->selling_price - $product->discount_price) / $product->selling_price) * 100)  }}%
                                            </li>
                                            <li class="product_mark product_new">new</li>
                                        </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="featured_slider_dots_cover"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
