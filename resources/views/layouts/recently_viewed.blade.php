@if (Session::get('recently_viewed'))
<div class="viewed">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="viewed_title_container">
                    <h3 class="viewed_title">Recently Viewed</h3>
                    <div class="viewed_nav_container">
                        <div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
                        <div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
                    </div>
                </div>
                <div class="viewed_slider_container">
                    <!-- Recently Viewed Slider -->
                    <div class="owl-carousel owl-theme viewed_slider">

                        @foreach (Session::get('recently_viewed') as $product)
                            <!-- Recently Viewed Item -->
                            <div class="owl-item">
                                <div
                                    class="viewed_item {{ $product->discount_price ? 'discount' :  ($product->isNew() ? 'is_new' : '') }} d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="viewed_image"><img src="{{ $product->cover}}" alt="" height="120" width="100"></div>
                                    <div class="viewed_content text-center">
                                        @if ($product->discount_price)
                                            <div class="viewed_price">
                                                ${{$product->discount_price}}
                                                <span style="text-decoration: line-through #00000060;">
                                                    {{   '$' . $product->selling_price }}
                                                </span>
                                            </div>
                                            @else
                                            <div class="viewed_price">
                                                ${{$product->selling_price}}
                                            </div>
                                        @endif
                                        <div class="viewed_name"><div>
                                            <a href='{{ route('products.show', $product->product_slug) }}'>{{ $product->product_name}}</a>
                                        </div></div>
                                    </div>
                                    <ul class="item_marks">
                                        <li class="item_mark item_discount">-{{ $product->discount_percent  }}%</li>
                                        <li class="item_mark item_new">new</li>
                                    </ul>
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
