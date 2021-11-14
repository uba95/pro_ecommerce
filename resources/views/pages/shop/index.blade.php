@extends('layouts.app.index')
@section('content')

    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/shop_styles.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/shop_responsive.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/jquery-ui-1.12.1.custom/jquery-ui.css') }}">
        <style>
            .sidebar_categories li a:hover {color: #0e8ce4 !important;}
        </style>
    @endpush

    <div class="super_container">
	
        <!-- Home -->
    
        <div class="home">
            <div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ asset('frontend/images/shop_background.jpg') }}"></div>
            <div class="home_overlay"></div>
            <div class="home_content d-flex flex-column align-items-center justify-content-center">
                <h2 class="home_title">{{ $homeTitle }}</h2>
            </div>
        </div>
    
        <!-- Shop -->
    
        <div class="shop">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
    
                        <!-- Shop Sidebar -->
                        @include('pages.shop.shop_sidebar')

                    </div>
    
                    <div class="col-lg-9">
                        
                        <!-- Shop Content -->
    
                        <div class="shop_content">
                            <div class="shop_bar clearfix">
                                <div class="shop_product_count"><span>{{ $products->total() }}</span> products found</div>
                                <div class="shop_sorting">
                                    <span>Sort by:</span>
                                    <ul>
                                        <li>
                                            <span class="sorting_text">
                                                @include('pages.shop.sort')
                                            </span>
                                            <ul>
                                                @include('pages.shop.sort_button', ['sort' => 'date'])
                                                @include('pages.shop.sort_button', ['sort' => 'name'])
                                                @include('pages.shop.sort_button', ['sort' => 'price'])
                                                @include('pages.shop.sort_button', ['sort' => 'rating'])
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
    
                            <div class="product_grid">
                                <div class="product_grid_border"></div>
                                {{-- <div class="row"> --}}
                                    {{-- <div class=" "> --}}
                                        <!-- Product Item -->
                                        @include('pages.shop.product')
                                    {{-- </div> --}}
                                {{-- </div> --}}
                            </div>
    
                            <!-- Shop Page Navigation -->
                            <div class="pagination_shop">
                                {{ $products->appends(request()->except('page'))->links('vendor.pagination.shop')}}
                            </div>

                            <div class="spinner spinner-border text-primary position-absolute"
                            style="left: 50%;top:50%;width: 3rem;height: 3rem;display:none" role="status">
                              <span class="sr-only">Loading...</span>
                            </div> 

                        </div>
                    </div>
                </div>
            </div>
        </div> 

        @include('layouts.recently_viewed')
        
    </div>
    

    @push('scripts')

        <script src="{{ asset('frontend/plugins/Isotope/isotope.pkgd.min.js')}}"></script>
        <script src="{{ asset('frontend/plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script> 
        <script src="{{ asset('frontend/plugins/parallax-js-master/parallax.min.js')}}"></script>
        <script src="{{ asset('frontend/js/shop_custom.js')}}"></script> 
        <script>
            $(document).on('click', '.shop_sorting_button a, .sorting_text a, .pagination_shop a', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('href'),
                    type:"GET",
                    dataType:"json",
                    data: {min : $( "#slider-range" ).slider( "values", 0 ), max : $( "#slider-range" ).slider( "values", 1 )},
                    success: function(data) {
                        
                        if (data.error) {
                            return toastr.error(data.error);
                        }

                        var el = $('.product_grid');
                        el.fadeOut(200, function () {
                            el.html(data.products);
                            $('.pagination_shop').html(data.pagination);
                            $('.sorting_text').html(data.sort_html);
                        }).fadeIn(200);
                    },
                    beforeSend: function() {
                        $('.shop_content').css('opacity', '0.5');
                        $('.spinner').css('display', 'block');
                    },
                    complete: function() {
                        $('.shop_content').css('opacity', '1');
                        $('.spinner').css('display', 'none');
                    },
                });
            });
        </script>
    @endpush

@endsection
