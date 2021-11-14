<div class="deals_featured pt-5">
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
                                        <div class="deals_item_category">
                                            @php $category =  $categories->firstWhere('id', $deal->product->category_id) @endphp
                                            <a href ='{{ route('shop.index', ['model' => 'category', 'slug' => $category->category_slug]) }}' style="color:#000">
                                                {{ $category->category_name }}
                                            </a>
                                        </div>
                                        <div class="deals_item_price_a ml-auto">${{ $deal->product->selling_price }}</div>
                                    </div>
                                    <div class="deals_info_line d-flex flex-row justify-content-start">
                                        <div class="deals_item_name"><a href='{{ route('products.show', $deal->product->product_slug) }}'>{{ $deal->product->product_name}}</a></div>
                                        <div class="deals_item_price ml-auto">${{ $deal->product->discount_price }}</div>
                                    </div>
                                    <div class="available">
                                        <div class="available_line d-flex flex-row justify-content-start">
                                            <div class="available_title">Available: <span>{{ $deal->product->product_quantity }}</span></div>
                                            <div class="sold_title ml-auto">Already sold: <span>{{ $deal->product->sold_quantity }}</span></div>
                                        </div>
                                        <div class="available_bar"><span style="width:{{ $deal->product->availableQuantityPercent }}%"></span></div>
                                    </div>
                                    <div class="deals_timer d-flex flex-row align-items-center justify-content-start">
                                        <div class="deals_timer_title_container" style="width: 100px;">
                                            <div class="deals_timer_title">Hurry Up</div>
                                            <div class="deals_timer_subtitle">Offer ends in:</div>
                                        </div>
                                        <div class="deals_timer_content ml-auto w-75">
                                            <div class="deals_timer_box clearfix w-100" data-target-time="{{ $deal->expired_at }}">
                                                <div class="deals_timer_unit w-25">
                                                    <div id="deals_timer1_day" class="deals_timer_day"></div>
                                                    <span>days</span>
                                                </div>
                                                <div class="deals_timer_unit w-25">
                                                    <div id="deals_timer1_hr" class="deals_timer_hr"></div>
                                                    <span>hours</span>
                                                </div>
                                                <div class="deals_timer_unit w-25">
                                                    <div id="deals_timer1_min" class="deals_timer_min"></div>
                                                    <span>mins</span>
                                                </div>
                                                <div class="deals_timer_unit w-25">
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
                                @foreach ($featured_products as $product)
                                    @include('pages.landing_page.product')
                                @endforeach

                            </div>
                            <div class="featured_slider_dots_cover"></div>
                        </div>

                        <!-- Product Panel -->
                        <div class="product_panel panel">
                            <div class="featured_slider slider">

                                <!-- Slider Item -->
                                @foreach ($trend_products as $product)
                                    @include('pages.landing_page.product')                                
                                @endforeach

                            </div>
                            <div class="featured_slider_dots_cover"></div>
                        </div>

                        <!-- Product Panel -->
                        <div class="product_panel panel">
                            <div class="featured_slider slider">

                                <!-- Slider Item -->
                                @foreach ($best_rated_products as $product)
                                    @include('pages.landing_page.product')                                
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
