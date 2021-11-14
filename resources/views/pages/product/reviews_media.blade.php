@if ($reviews->isNotEmpty())

{{-- @foreach (range(1, 5) as $item) --}}
@foreach ($reviews as $review)
<div class="media py-2">
    <img src="{{ $review->user->avatar }}" width="64" height="64" class="mr-3" alt="{{ $review->user->name }}">
    <div class="media-body">
        <h5 class="m-0 mt-0">{{ $review->headline }}</h5>
        <div class="text-muted">
            <span class="mr-1">{{ $review->user->name }}</span>
            <span>{{ $review->created_at->isoFormat('Y-MM-DD') }}</span>
        </div>
        <div class="get-rating{{ $review->user->id }}"></div>

        <p class="mt-3" style="word-break: break-all">
            <span class="body_limit">{{ Str::limit($review->body, 100) }}</span>
            <span id="site-reviews" class="collapse collapse1">{{ $review->body }}</span>
            <button onclick="toggleBody(event)" class="btn btn-link btn-sm d-inline" type="button" style="font-size:11px">
                See More
            </button>
        </p>
</div>
</div>

{{-- @if ((bool)(float) $product->userReviewRating($review->user->id))
@push('rating')
<script>
    $(".get-rating{{ $review->user->id }}").starRating({
        starSize: 14,
        minRating: 0.50,
        readOnly: true,
        initialRating: {{ $product->userReviewRating($review->user->id)  }},
        disableAfterRate: false,
        ratedColor: '#3550bd',
    });
</script>
@endpush
@endif
 --}}

@if (!$loop->last) <hr> @endif

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


