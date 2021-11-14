@extends('layouts.home')
@section('section')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/star-rating-svg.css') }}">
@endpush

<div class="col-lg-8 card">


    <div class="media_reviews p-2 mt-4">


        @if ($reviews->isNotEmpty())

        {{-- @foreach (range(1, 5) as $item) --}}
        @foreach ($reviews as $review)
        <div class="media py-2">
            <img src="{{ $review->product->cover }}" width="64" height="64" class="mr-3"
                alt="{{ $review->product->product_name }}">
            <div class="media-body">
                <div class="d-flex align-items-center">
                    <h5 class="m-0 mt-0">{{ $review->headline }}</h5>
                    <a class="btn btn-sm btn-link" href='{{ route('reviews.edit', $review->product->product_slug) }}'
                        style="font-size:12px">
                        Edit
                    </a>
                    <form method="POST" action='{{ route('reviews.destroy', $review->product_id) }}'
                        style="font-size:12px;cursor:pointer" class="btn btn-sm btn-link deleteWithoutAjax">
                        @csrf @method('DELETE') Delete
                    </form>
                </div>
                <div class="text-muted small">
                    <span class="mr-1">{{ $review->product->product_name  }}</span>
                    <span>{{ $review->created_at->isoFormat('Y-MM-DD') }}</span>
                </div>
                <div class="get-rating{{ $review->product_id }}"></div>

                <p class="mt-3" style="word-break: break-all">
                    <span class="body_limit">{{ Str::limit($review->body, 150) }}</span>
                    <span id="site-reviews" class="collapse">{{ $review->body }}</span>
                    <button onclick="toggleBody(event)" class="btn btn-link btn-sm d-inline" type="button" style="font-size:11px">
                        See More
                    </button>
                </p>
            </div>
        </div>

        @if ($review->product->userReviewRating(current_user()->id))
        @push('scripts')
        <script src="{{ asset('frontend/js/jquery.star-rating-svg.js')}}"></script>

        <script>
            $(".get-rating{{ $review->product_id }}").starRating({
                starSize: 14,
                minRating: 0.50,
                readOnly: true,
                initialRating: {{ $review->product->userReviewRating(current_user()->id) }},
                disableAfterRate: false,
                ratedColor: '#3550bd',
            });
        </script>
        @endpush
        @endif

        @if (!$loop->last)
        <hr> @endif

        @endforeach

        {{-- @endforeach --}}

        @else
        <p>No Customer Reviews Yet</p>
        @endif

        <div class="pagination_shop">
            {{ $reviews->appends(request()->except('page'))->links('vendor.pagination.shop')}}
        </div>

        <div class="spinner spinner-border text-primary position-absolute"
            style="left: 50%;top:50%;width: 3rem;height: 3rem;display:none" role="status">
            <span class="sr-only">Loading...</span>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function toggleBody(e) {
        var el = $(e.target);
        el.siblings('.body_limit').toggle()
        el.siblings('.collapse').toggle()
        el.text(el.siblings('.collapse').css('display') == 'none' ? 'See More' : 'See Less')
    }
</script>
@endpush
@endsection