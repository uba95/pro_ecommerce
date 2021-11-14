@if ($banner_slider_items->isNotEmpty())
    @push('styles')	
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/star-rating-svg.css') }}">
    @endpush

    <div class="banner_2">
    <div class="banner_2_background" style="background-image:url({{ asset('frontend/images/banner_2_background.jpg')}})"></div>
    <div class="banner_2_container">
        <div class="banner_2_dots"></div>
        <!-- Banner 2 Slider -->

        <div class="owl-carousel owl-theme banner_2_slider">

            <!-- Banner 2 Slider Item -->
            @foreach ($banner_slider_items as $item)
            <div class="owl-item">
                <div class="banner_2_item">
                    <div class="container fill_height">
                        <div class="row fill_height">
                            <div class="col-lg-4 col-md-6 fill_height">
                                <div class="banner_2_content">
                                    <div class="banner_2_category">
                                        @php $category =  $categories->firstWhere('id', $item->product->category_id) @endphp
                                        <a href ='{{ route('shop.index', ['model' => 'category', 'slug' => $category->category_slug]) }}' style="color:#000">
                                            {{ $category->category_name }}
                                        </a>
                                    </div>
                                    <div class="banner_2_title">{{ $item->product->product_name }}</div>
                                    <div class="banner_2_text">{{ $item->banner_slider_text}}</div>
                                    <div class="rating_r rating_r_4 banner_2_rating {{ 'banner_slider_rating' . $item->product_id }}"></div>
                                    <div class="button banner_2_button m-0 mt-3">
                                        <a href='{{ route('products.show', $item->product->product_slug) }}'>Explore</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-lg-8 col-md-6 fill_height">
                                <div class="banner_2_image_container">
                                    <div class="banner_2_image"><img src="{{ $item->banner_slider_img}}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>          
                </div>
            </div>

            @endforeach

        </div>
    </div>
    </div>
    @push('scripts')
        <script src="{{ asset('frontend/js/jquery.star-rating-svg.js')}}"></script>
        <script>

        var banner_slider_items = @json($banner_slider_items);
        Object.values(banner_slider_items).forEach(function (item) { 
            if (avg = item.product.ratings[0]?.avg) {
                $(".banner_slider_rating" + item.product_id).starRating({
                starSize: 22,
                readOnly: true,
                initialRating: avg,
                ratedColor: '#3550bd',
                }) 
            }}
        )
        </script>
    @endpush
@endif
