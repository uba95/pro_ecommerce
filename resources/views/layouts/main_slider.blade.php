    <!-- Banner -->

    <div class="banner">
        <div class="banner_background" style="background-image:url({{ asset('frontend/images/banner_background.jpg')}})"></div>
        <div class="container fill_height">
            <div class="row fill_height">
                <div class="banner_product_image"><img src="{{ $main_slider_product->image_one}}" alt="" height="450"></div>
                <div class="col-lg-5 offset-lg-4 fill_height">
                    <div class="banner_content">
                        <h1 class="banner_text">{{ $main_slider_product->product_name}}</h1>
                        <div class="banner_price">
                            @if ($main_slider_product->discount_price)
                            <span>
                                {{   '$' . $main_slider_product->selling_price }}
                            </span>
                            ${{$main_slider_product->discount_price}}
                            @else
                            ${{$main_slider_product->selling_price}}
                            @endif
                        </div>
                        <div class="banner_product_name">{{ $main_slider_product->brand->brand_name}}</div>
                        <div class="button banner_button"><a href="#">Shop Now</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
