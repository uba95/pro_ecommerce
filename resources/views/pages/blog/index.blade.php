@extends('layouts.app.index')

@section('content')
	@push('styles')
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/blog_styles.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/blog_responsive.css') }}">
	@endpush

	<div class="blog">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="blog_posts d-flex flex-row align-items-start justify-content-between">
						@forelse($posts as $post)	
							<!-- Blog post -->
							<div class="blog_post">
								<div class="blog_image" style="background-image:url({{ $post->post_image }})"></div>
								<div class="blog_text">{{ $post->post_title }}</div>
								<div class="blog_button">
									<a href="{{ route('blog.show', $post->post_slug) }}">Continue Reading</a>
								</div>
							</div>
							@empty
							<div class="alert alert-danger m-auto w-100">No Posts Found</div>
						@endforelse
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('scripts') 
		<script src="{{ asset('frontend/plugins/parallax-js-master/parallax.min.js')}}"></script>
		{{-- <script src="{{ asset('frontend/js/blog_custom.js')}}"></script> --}}
	@endpush
@endsection