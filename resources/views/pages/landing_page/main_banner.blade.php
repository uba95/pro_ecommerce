@if ($main_banner)

    <div class="banner">
        <div class="banner_background" style="background-image:url({{ asset('frontend/images/banner_background.jpg')}})"></div>
        <div class="container fill_height">
            <div class="row fill_height">
                <div class="banner_product_image"><img src="{{ $main_banner->main_banner_img}}" alt="" height="450"></div>
                <div class="col-lg-5 offset-lg-4 fill_height">
                    <div class="banner_content">
                        <h1 class="banner_text">{{ $main_banner->main_banner_text}}</h1>
                        <div class="banner_price">
                            @if ($main_banner->product->discount_price)
                            <span>
                                {{   '$' . $main_banner->product->selling_price }}
                            </span>
                            ${{$main_banner->product->discount_price}}
                            @else
                            ${{$main_banner->product->selling_price}}
                            @endif
                        </div>
                        <div class="banner_product_name">{{ $main_banner->product->product_name }}</div>
                        <div class="button banner_button">
                            <a href='{{ route('products.show', $main_banner->product->product_slug) }}'>Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@else

<div class="banner">
    <div class="banner_background" style="background-image:url({{ asset('frontend/images/banner_background.jpg')}})"></div>
    <div class="container fill_height">
        <div class="row fill_height">
            <div class="banner_product_image"></div>
            <div class="col-lg-5 offset-lg-4 fill_height">
                <div class="banner_content">
                    <h1 class="banner_text">WELCOME TO OUR STORE <br><br><br><br></h1>
                </div>
            </div>
        </div>
    </div>
</div>

@endif
