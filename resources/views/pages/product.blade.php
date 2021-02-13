@extends('layouts.app')
@section('content')
    {{-- @include('layouts.menubar') --}}
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/product_styles.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/product_responsive.css') }}">
    @endpush

    	<!-- Single Product -->

	<div class="single_product">
		<div class="container">
			<div class="row">

				<!-- Images -->
				<div class="col-lg-2 order-lg-1 order-2">
					<ul class="image_list">
						<li data-image="{{ $product->image_one }}"><img src="{{ $product->image_one }}" alt="{{ $product->product_name }}"></li>
						<li data-image="{{ $product->image_two }}"><img src="{{ $product->image_two }}" alt="{{ $product->product_name }}"></li>
						<li data-image="{{ $product->image_three }}"><img src="{{ $product->image_three }}" alt="{{ $product->product_name }}"></li>
					</ul>
				</div>

				<!-- Selected Image -->
				<div class="col-lg-5 order-lg-2 order-1">
					<div class="image_selected"><img src="{{ $product->image_one }}" alt="{{ $product->product_name }}"></div>
				</div>

				<!-- Description -->
				<div class="col-lg-5 order-3">
					<div class="product_description">
						<div class="product_category">
                            {{$product->category->category_name .'->'. $product->subcategory->subcategory_name .'->'. $product->brand->brand_name}}
                        </div>
						<div class="product_name">{{ $product->product_name }}</div>
						<div class="rating_r rating_r_4 product_rating"><i></i><i></i><i></i><i></i><i></i></div>
						<div class="product_text"><p>{!! Str::limit($product->product_details, 3000)   !!}</p></div>
						<div class="order_info d-flex flex-row">
							<form class="addcart" data-id="{{ $product->id }}" method="POST"> @csrf
								<div class="clearfix" style="z-index: 1000;">

									<!-- Product Quantity -->
									<div class="product_quantity clearfix">
										<span>Quantity: </span>
										<input name="product_quantity" class="quantity_input" type="number" min="1" max="{{ $product->product_quantity }}" value="1" style="width: 40px;">
										<div class="quantity_buttons">
											<div class="quantity_inc quantity_control quantity_inc_button"><i class="fas fa-chevron-up"></i></div>
											<div class="quantity_dec quantity_control quantity_dec_button"><i class="fas fa-chevron-down"></i></div>
										</div>
									</div>

									<!-- Product Color -->
									<ul class="product_color">
										<li>
											<span>Color: </span>
											<div class="color_mark_container"><div id="selected_color" class="color_mark" style="background: {{ $product->product_color[0] }}"></div></div>
											<input name="product_color" type="hidden" id="colorInput" value="{{ $product->product_color[0] }}">
                                            <div class="color_dropdown_button"><i class="fas fa-chevron-down"></i></div>
											<ul class="color_list">
                                                @foreach ($product->product_color as $color)
                                                    <li><div class="color_mark" style="background: {{  $color }}"></div></li>
                                                @endforeach
											</ul>
										</li>
									</ul>
									@if ($product->product_size)
                                    <ul class="product_color product_size" style="margin-top: 30px">
                                        <li>
                                            <span>Size: </span>
                                            <div class="color_mark_container">
                                                <div id="selected_size" style="font-size: 20px;font-weight: 300;color: rgba(0,0,0,0.5);">
                                                    {{ $product->product_size[0] }}
                                                </div>
                                                <input name="product_size" type="hidden" id="sizeInput" value=" {{ $product->product_size[0] }}">
                                            </div>
                                            <div class="color_dropdown_button"><i class="fas fa-chevron-down"></i></div>
                                            <ul class="color_list">
                                                @foreach ($product->product_size as $size)
                                                    <li><div class="size1" style="font-size: 16px;font-weight: 300;color: rgba(0,0,0,0.5);">{{ $size }}</div></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                        
								</div>
								@endif

                                @if ($product->discount_price)
                                <div class="product_price discount">
                                    ${{$product->discount_price}}
                                    <span style="font-size: 16px;color: #666;margin-left: 10px;text-decoration:line-through">
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

	<!-- Recently Viewed -->

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
							
							<!-- Recently Viewed Item -->
							<div class="owl-item">
								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_1.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$225<span>$300</span></div>
										<div class="viewed_name"><a href="#">Beoplay H7</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>
							</div>

							<!-- Recently Viewed Item -->
							<div class="owl-item">
								<div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_2.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$379</div>
										<div class="viewed_name"><a href="#">LUNA Smartphone</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>
							</div>

							<!-- Recently Viewed Item -->
							<div class="owl-item">
								<div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_3.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$225</div>
										<div class="viewed_name"><a href="#">Samsung J730F...</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>
							</div>

							<!-- Recently Viewed Item -->
							<div class="owl-item">
								<div class="viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_4.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$379</div>
										<div class="viewed_name"><a href="#">Huawei MediaPad...</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>
							</div>

							<!-- Recently Viewed Item -->
							<div class="owl-item">
								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_5.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$225<span>$300</span></div>
										<div class="viewed_name"><a href="#">Sony PS4 Slim</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>
							</div>

							<!-- Recently Viewed Item -->
							<div class="owl-item">
								<div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_6.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$375</div>
										<div class="viewed_name"><a href="#">Speedlink...</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

    @push('scripts')
        <script src="{{ asset('frontend/js/product_custom.js')}}"></script>
    @endpush

@endsection