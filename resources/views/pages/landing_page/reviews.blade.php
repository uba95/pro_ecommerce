@if ($reviews->isNotEmpty())
<div class="reviews">
    <div class="container">
        <div class="row">
            <div class="col">
                
                <div class="reviews_title_container">
                    <h3 class="reviews_title">Latest Reviews</h3>
                    {{-- <div class="reviews_all ml-auto"><a href="#">view all <span>reviews</span></a></div> --}}
                </div>

                <div class="reviews_slider_container">
                    
                    <!-- Reviews Slider -->
                    <div class="owl-carousel owl-theme reviews_slider">
                        
                        <!-- Reviews Slider Item -->
                        @foreach ($reviews as $review)
                            <div class="owl-item">
                                <div class="review d-flex flex-row align-items-start justify-content-start">
                                    <div><div class="review_image"><img src="{{ $review->product->cover }}" alt=""></div></div>
                                    <div class="review_content">
                                        <div class="review_name">
                                            <a href ='{{ route('products.show', $review->product->product_slug) }}' class="text-dark">
                                                {{ $review->product->product_name }}
                                            </a>
                                        </div>
                                        <div class="review_rating_container">
                                            <div class="rating_r rating_r_4 review_rating {{ 'review_rating' . $review->product_id .  $review->user_id}}"></div>
                                            <div class="review_time"> {{ $review->user->name }}</div>
                                        </div>
                                        <div class="review_text"><p>{{ Str::limit($review->body, 80) }}</p></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="reviews_dots"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        var reviews = @json($reviews);
        Object.values(reviews).forEach(function (review) { 
            if (rating = review.product.ratings[0]?.value /10) {
                $(".review_rating" + review.product_id +  review.user_id).starRating({
                starSize: 12,
                readOnly: true,
                initialRating: rating,
                ratedColor: '#3550bd',
                }) 
            }}
        )
    </script>
@endpush
@endif
