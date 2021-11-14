<div class="single_product">
    <div class="container">
        <div class="row">

            <!-- Images -->
            <div class="col-lg-2 order-lg-1 order-2">
                <ul class="image_list scroll_bar">
                    @foreach ($product->images as $img)
                    <li data-image="{{ $img->name }}"><img src="{{ $img->name }}" alt="{{ $product->product_name }}">
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Selected Image -->
            <div class="col-lg-5 order-lg-2 order-1">
                <div class="image_selected"><img src="{{ $product->cover }}" alt="{{ $product->product_name }}"></div>
            </div>

            <!-- Description -->
            <div class="col-lg-5 order-3">
                
                <div class="product_description">
                    <div class="product_name">{{ $product->product_name }}</div>
                    <div>
                        @switch($product->stockStatus)
                        @case('in')
                        <strong class="text-success">In Stock</strong>
                        @break
                        @case('only')
                        <strong class="text-warning">Only {{$product->product_quantity}} Left In Stock, Hurry
                            Up!</strong>
                        @break
                        @case('out')
                        <strong class="text-danger">Out Of Stock</strong>
                        @break

                        @endswitch
                    </div>

                    @include('pages.product.rating')

                    <div class="product_text" style="word-break: break-all">
                        <p>{!! Str::limit(strip_tags($product->product_details), 800) !!}</p>
                    </div>
                    <div class="order_info d-flex flex-row">
                        <form class="addcart" data-id="{{ $product->id }}" method="POST"> @csrf
                            <div class="clearfix" style="z-index: 1000;">

                                <!-- Product Quantity -->
                                <div class="product_quantity clearfix">
                                    <span>Quantity: </span>
                                    <input name="product_quantity" class="quantity_input" type="number" min="1"
                                        max="{{ $product->product_quantity }}" value="1" style="width: 40px;">
                                    <div class="quantity_buttons">
                                        <div class="quantity_inc quantity_control quantity_inc_button"><i
                                                class="fas fa-chevron-up"></i></div>
                                        <div class="quantity_dec quantity_control quantity_dec_button"><i
                                                class="fas fa-chevron-down"></i></div>
                                    </div>
                                </div>

                                <!-- Product Color -->
                                <ul class="product_color">
                                    <li>
                                        <span>Color: </span>
                                        <div class="color_mark_container">
                                            <div id="selected_color" class="color_mark"
                                                style="background: {{ $product->product_color[0] }}"></div>
                                        </div>
                                        <input name="product_color" type="hidden" id="colorInput"
                                            value="{{ $product->product_color[0] }}">
                                        <div class="color_dropdown_button"><i class="fas fa-chevron-down"></i></div>
                                        <ul class="color_list">
                                            @foreach ($product->product_color as $color)
                                            <li>
                                                <div class="color_mark" style="background: {{  $color }}"></div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                                @if ($product->product_size)
                                <ul class="product_color product_size" style="margin-top: 30px">
                                    <li>
                                        <span>Size: </span>
                                        <div class="color_mark_container">
                                            <div id="selected_size"
                                                style="font-size: 20px;font-weight: 300;color: rgba(0,0,0,0.5);">
                                                {{ $product->product_size[0] }}
                                            </div>
                                            <input name="product_size" type="hidden" id="sizeInput"
                                                value=" {{ $product->product_size[0] }}">
                                        </div>
                                        <div class="color_dropdown_button"><i class="fas fa-chevron-down"></i></div>
                                        <ul class="color_list">
                                            @foreach ($product->product_size as $size)
                                            <li>
                                                <div class="size1"
                                                    style="font-size: 16px;font-weight: 300;color: rgba(0,0,0,0.5);">
                                                    {{ $size }}</div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                                @endif

                            </div>

                            @if ($product->discount_price)
                            <div class="product_price discount">
                                ${{$product->discount_price}}
                                <span
                                    style="font-size: 16px;color: #666;margin-left: 10px;text-decoration:line-through">
                                    {{   '$' . $product->selling_price }}
                                </span>
                            </div>
                            @else
                            <div class="product_price">
                                ${{$product->selling_price}}
                            </div>
                            @endif

                            <div class="button_container">
                                <button class="button cart_button">Add to Cart</button>
                                <div class="product_fav"><i class="fas fa-heart"></i></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
