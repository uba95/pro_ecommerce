@extends('layouts.app.index')
@if ($product->meta)
	@if ($product->meta->meta_title)
		@section('title')
			<title>{{ $product->meta->meta_title }}</title>
		@endsection
	@endif
	@if ($product->meta->meta_descrition)
		@section('meta_description')
			<meta name="description" content="{{ $product->meta->meta_descrition }}">
		@endsection
	@endif
	@if ($product->meta->meta_keywords)
		@section('meta_keywords')
			<meta name="keywords" content="{{ $product->meta->meta_keywords }}">
		@endsection
	@endif
@endif
@section('content')
	@push('styles')
		
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/product_styles.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/product_responsive.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/star-rating-svg.css') }}">
		<style>
			@media only screen and (min-width: 992px) {
				.image_list {
					height: 525px;
					overflow-y: auto;
				}

				.image_list::-webkit-scrollbar {
					width: 3px;
				}
			}

			@media only screen and (max-width: 991px) {
				.image_list {
					overflow-x: auto;
					display: -webkit-box;
				}

				.image_list::-webkit-scrollbar {
					height: 3px;
				}
			}

			.image_list::-webkit-scrollbar-track {
				box-shadow: inset 0 0 5px grey;
				border-radius: 20px;
			}

			.image_list::-webkit-scrollbar-thumb {
				background: #0e8ce4;
				border-radius: 20px;
			}

			.image_list::-webkit-scrollbar-thumb:hover {
				background: #005aff;
			}

			.nav-tabs .nav-link {
				color: #888 !important;
				background-color: #eee !important;
			}

			.nav-link.active {
				color: #fff !important;
				background-color: #0e8ce4 !important;
				border-color: #0e8ce4 !important;
			}	
			.iframe-placeholder {
			background: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100% 100%"><text fill="%23888888" x="50%" y="50%" font-family="\'Lucida Grande\', sans-serif" font-size="18" text-anchor="middle">Loading</text></svg>') 0px 0px no-repeat;
			}
		</style>

		@if ($rate)
			<style>
				.my-rating polygon[class*="svg-active-"] {fill: #3550bd!important;}
			</style>
		@endif

	@endpush
	<!-- Single Product -->
	<div class="container my-4">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href ='{{ route('shop.index', ['model' => 'category', 'slug' => $product->category->category_slug]) }}'>
					{{ $product->category->category_name }}
				</a>
			</li>
			<li class="breadcrumb-item">
				<a href ='{{ route('shop.index', ['model' => 'subcategory', 'slug' =>  optional($product->subcategory)->subcategory_slug]) }}'>
					{{  optional($product->subcategory)->subcategory_name }}
				</a>
			</li>
			<li class="breadcrumb-item">
				<a href ='{{ route('shop.index', ['model' => 'brand', 'slug' => optional($product->brand)->brand_slug]) }}'>
					{{ optional($product->brand)->brand_name }}
				</a>
			</li>
			</ol>
		</nav>
	</div>

	<div class="single_product">
		<div class="container">
			<div class="row">

				<!-- Images -->
				<div class="col-lg-2 order-lg-1 order-2">
					<ul class="image_list">
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
						<div class="rating_r rating_r_4 product_rating">
							<div>
								<div class="d-flex">
									<div class="get-rating mr-2"></div>
									<span style="margin-top: 2px;">
										{{ $productRatingAvg }} 
										( {{ $count = $product->ratings()->count() }} {{ Str::plural('rating', $count) }}  )
									</span>
								</div>
								<div class="rate-this text-muted my-2" style="cursor: pointer;font-size: 12px" data-toggle="modal" data-target="#rate-this">
									@auth('web')
										<strong>
												<span style="@if (!$rate) display:none @endif">
													Your Rating: <span class="ml-1">{{ $userRating }} </span>
												</span>
												<span style="@if ($rate) display:none @endif">
													Rate This
												</span>
										</strong>
										<i class="fa fa-star"></i>
									@endauth
								</div>
							</div>
							
						</div>
						<div class="product_text" style="word-break: break-all">
							<p>{!! Str::limit($product->product_details, 3000) !!}</p>
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

	<div class="product_details py-5">
		<div class="container">
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist" style="font-size: 1rem">
					<a class="nav-link active mx-1" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
					aria-controls="nav-home" aria-selected="true">Product Details</a>
					@if ($product->video_embed)
						<a class="vid-tab nav-link mx-1" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
						aria-controls="nav-profile" aria-selected="false">Video Link</a>
					@endif					
					<a class="review-tab nav-link mx-1" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
					aria-controls="nav-contact" aria-selected="false">Product Review</a>
				</div>
			</nav>
			<div class="tab-content py-4" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
					style="word-break: break-all">
					{!! $product->product_details !!}
				</div>
				<div class="tab-pane fade video_embed" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					<iframe class="iframe-placeholder" src="" width="560" height="315" title="YouTube video player" data-src="false"
						frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
						allowfullscreen>
					</iframe>
				</div>
				<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
					<div class="iframe-placeholder" style="display: none;height:100px"></div>
					<div class="fb-comments" data-href="{{ request()->url() }}"
						data-width="" data-numposts="5">
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('layouts.recently_viewed')
	
	<!-- Modal -->
	<div class="modal fade" id="rate-this" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle">Rate This</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body text-center">
			<div class="my-rating"></div>
			<div class="mt-3 your_rating" style="@if (!$rate) display:none @endif">
				<strong>Your Rating: 
					<span>{{ $userRating }}</span>
				</strong>
			</div>
		</div>
		<div class="modal-footer justify-content-start ">
			<form action="{{ route('rating.destroy', $product->id) }}" class="remove_rating" 
				method="POST"  style="@if (!$rate) display:none @endif"> 
				@csrf @method('DELETE')
				<button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-trash"></i></button>
			</form>
		</div>
		</div>
	</div>
	</div>

	<div class="get_facebook" data-facebook="false">
		<div id="fb-root"></div>
		
	</div>

	@push('scripts')
		<script src="{{ asset('frontend/js/product_custom.js')}}"></script>
		<script src="{{ asset('frontend/js/jquery.star-rating-svg.js')}}"></script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6112a029d72c3999"></script>
		<script>
			$(".get-rating").starRating({
				starSize: 18,
				minRating: 0.50,
				readOnly: true,
				initialRating: {{ $productRatingAvg }},
				disableAfterRate: false,
				ratedColor: '#3550bd',
			});
			
			$(".my-rating").starRating({
				starSize: 30,
				minRating: 0.50,
				initialRating: {{ $userRating }},
				disableAfterRate: false,
				ratedColor: '#3550bd',
				callback: function(currentRating, $el){

					var product_id = {{ $product->id }}
					$.ajax({
						url: `/product/ratings/${product_id}`,
						type:"POST",
						data:{_token: "{{ csrf_token() }}", rating: currentRating},
						dataType:"json",
						success:function(data) { 

							$('.rate-this').fadeOut(700, function () {
								$('.rate-this strong span span').text(`${currentRating}`)
								$('.rate-this strong span:nth-child(1)').show()
								$('.rate-this strong span:nth-child(2)').hide()
							}).fadeIn(700);

							$('.your_rating').fadeOut(() => $('.your_rating strong span').text(`${currentRating}`)).fadeIn()
							$('.remove_rating').fadeIn()
						},
					});
				}
			});

			$(document).on("click", '.remove_rating button', function(e){
				e.preventDefault();
					$.ajax({
						url: $(this).parent().attr('action'),
						type:"DELETE",
						data:{_token: "{{ csrf_token() }}"},
						dataType:"json",
						success:function(data) { 
							$('.my-rating').starRating('setRating', 0);
							$('.your_rating').fadeOut()
							$('.remove_rating').fadeOut()

							$('.rate-this').fadeOut(700, function () {
								$('.rate-this strong span:nth-child(1)').hide()
								$('.rate-this strong span:nth-child(2)').show()
							}).fadeIn(700);
							
							$('#rate-this').modal('hide')
						},
					});
			});
			
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

				var el = $('.video_embed iframe');
				if ($(e.target).is($('.vid-tab')) && el.data('src') == false ) {
					el.data('src', true);
					$('.video_embed iframe').attr('src', "{{ $product->video_embed }}");
				}

				var el = $('.get_facebook');
				if ($(e.target).is($('.review-tab')) && el.data('facebook') == false ) {
					$('div.iframe-placeholder').fadeIn(1000).fadeOut(3000)
					el.data('facebook', true);
					el.append('<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0&appId=2670363766511113&autoLogAppEvents=1" nonce="VsxWyHGJ"><\/script>');
				}
			})
		</script>
	@endpush
@endsection
