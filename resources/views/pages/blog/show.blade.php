@extends('layouts.app.index')

@section('content')
	@push('styles')
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/blog_single_styles.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/blog_single_responsive.css') }}">
	@endpush

	<div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ $blog_post->post_image }}" data-speed="0.8"></div>
	</div>

	<div class="single_post">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="single_post_title">
						{{ $blog_post->post_title }}
						<div class="text-muted small" style="font-size: 35%">
							<a href ='{{ route('blog.category', $blog_post->category->blog_category_slug) }}'>
								{{ $blog_post->category->blog_category_name }}
							</a> <br>
							published at: {{ $blog_post->created_at->isoFormat('Y-MM-DD') }}
						</div>
					</div>
					<div class="single_post_text" style="word-break: break-all">
						<p> 
							{!! $blog_post->details !!}
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Blog Posts -->
	<div class="blog">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="blog_posts d-flex flex-row align-items-start justify-content-between">
						@foreach($posts as $post)	
							<!-- Blog post -->
							<div class="blog_post">
								<div class="blog_image" style="background-image:url({{ $post->post_image }})"></div>
								<div class="blog_text">{{ $post->post_title }}</div>
								<div class="blog_button">
									<a href="{{ route('blog.show', $post->post_slug) }}">Continue Reading</a>
								</div>
							</div>
						@endforeach
					</div>
				</div>	
			</div>
		</div>
	</div>
	
	@push('scripts') 
		<script src="{{ asset('frontend/plugins/parallax-js-master/parallax.min.js')}}"></script>
		{{-- <script src="{{ asset('frontend/js/blog_single_custom.js')}}"></script> --}}
	@endpush
@endsection