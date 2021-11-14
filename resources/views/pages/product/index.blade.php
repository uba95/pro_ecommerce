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
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/contact_styles.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/contact_responsive.css') }}">

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
			}
			
			.nav-tabs .nav-link {
				color: #888 !important;
				background-color: #eee !important;
			}

			#nav-review .nav-tabs .nav-link {
				padding: 10px;
			}

			.nav-link.active {
				color: #fff !important;
				background-color: #0e8ce4 !important;
				border-color: #0e8ce4 !important;
			}
			#nav-review * { font-size: 1em !important}
			#nav-review .nav-link.active {
				color: #fff !important;
				background-color: #555 !important;
				border-color: #555 !important;
			}	
            #nav-review .media-body .text-muted {font-size: 80% !important}
            #site-reviews .fas {font-size: 85% !important}

			.iframe-placeholder {
			background: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100% 100%"><text fill="%23888888" x="50%" y="50%" font-family="\'Lucida Grande\', sans-serif" font-size="18" text-anchor="middle">Loading</text></svg>') 0px 0px no-repeat;
			}

			.shop_page_nav {margin-top: 10px !important;}

		</style>

		@if ($rate)
			<style>
				.my-rating polygon[class*="svg-active-"] {fill: #3550bd!important;}
			</style>
		@endif

	@endpush

	<div id="show_product">
		@include('pages.product.breadcrumb')
		@include('pages.product.main')
		@include('pages.product.details')
		@include('layouts.recently_viewed')		
		<div class="get_facebook" data-facebook="false">
			<div id="fb-root"></div>
		</div>	
	</div>

	@push('scripts')
		<script src="{{ asset('frontend/js/product_custom.js')}}"></script>
		<script src="{{ asset('frontend/js/jquery.star-rating-svg.js')}}"></script>
		{{-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6112a029d72c3999"></script> --}}
		<script>
			$(".get-rating").starRating({
				starSize: 18,
				minRating: 0.50,
				readOnly: true,
				initialRating: {{ $avgRating }},
				disableAfterRate: false,
				ratedColor: '#3550bd',
			});
			
			$(".my-rating").starRating({
				starSize: 30,
				minRating: 0.50,
				initialRating: {{ $rate }},
				disableAfterRate: false,
				ratedColor: '#3550bd',
				callback: function(currentRating, $el){

					var product_id = {{ $product->id }}
					$.ajax({
						url: `/products/ratings/${product_id}`,
						type:"POST",
						data:{_token: "{{ csrf_token() }}", rating: currentRating},
						dataType:"json",
						success:function(data) { 

							$('.my-rating').starRating('setRating', currentRating);
							$('.my-rating-review').starRating('setRating', currentRating);

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

			$(document).on("click", '.remove_rating .fa-times-circle, .remove_rating button', function(e){
				e.preventDefault();
					$.ajax({
						url: $(this).parent().attr('action'),
						type:"DELETE",
						data:{_token: "{{ csrf_token() }}"},
						dataType:"json",
						success:function(data) { 
							$('.my-rating').starRating('setRating', 0);
							$('.my-rating-review').starRating('setRating', 0);
							$('.your_rating').fadeOut().attr("style", "display: none !important")
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

				var el = $('#nav-site-reviews');
				if ($(e.target).is($('.review-tab'))) {
					newReviews(window.location.href, '.spinner1')				
				}
			})
		</script>

		<script>
			$(document).on('click', '.pagination_shop a', function(e) {
				e.preventDefault();
				newReviews($(this).attr('href'))
			});

			function newReviews(href, spinner = '.spinner') {
				$.ajax({
					url: href,
					type:"GET",
					dataType:"json",
					success: function(data) {
						
						var el = $('.media_reviews');
						el.fadeOut(200, function () {

							el.html(data.reviews);
							data.newReviews.data.forEach(function (v) {
								if (!!parseFloat(`${v.rating}`)) {
									$(`.get-rating${v.user.id}`).starRating({
										starSize: 14,
										minRating: 0.50,
										readOnly: true,
										initialRating: `${v.rating}`,
										disableAfterRate: false,
										ratedColor: '#3550bd',
									});
								}
							})
							$('.pagination_shop').html(data.pagination);
							$('.media_reviews').css('opacity', '1');

						}).fadeIn(200);
					},
					beforeSend: function() {
						$('.media_reviews').css('opacity', '0.5');
						$(spinner).css('display', 'block');
					},
					complete: function() {
						$(spinner).css('display', 'none');
					},
				});
			}
		</script>

		<script>
			function storeReview(e) {
				e.preventDefault();
				var form = $(e.target).parent().parent();
				var headlineInput = form.find('input[name="headline"]');
				var bodyInput = form.find('textarea[name="body"]');
				var headline = headlineInput.val();
				var body = bodyInput.val();
				if (headline && body) {   
					$.ajax({
						url: form.attr('action'),
						type:'POST',
						dataType:"json",
						data: {"_token": "{{  csrf_token() }}", 'headline': headline, 'body': body},
						success:function(data) { 
							if (data.error) {
								toastr.error(data.error)
							}
							if (data.success) {
								headlineInput.val('')
								bodyInput.val('')
								toastr.success(data.success)
							}
						},
						error:function(data) { 
							
							if (headline = data.responseJSON.errors.headline[0]) {
								toastr.error(headline)
							}
							
							if (body = data.responseJSON.errors.body[0]) {
								toastr.error(body)
							}
						},
					});
				}
			}
		</script>
		
        @stack('rating')
	@endpush
@endsection
