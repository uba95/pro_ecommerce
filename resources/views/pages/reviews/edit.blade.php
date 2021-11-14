@extends('layouts.home')
@section('section')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/star-rating-svg.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/contact_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/contact_responsive.css') }}">

@endpush

<div class="col-lg-8 card">

    <div id="site-reviews" class="contact_form p-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact_form_container">
    
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li class="mg-t-10">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
    
                        <!-- Modal -->
                        <div class="modal-body text-left">
                            <div class="my-rating my-rating-review"></div>
                            <div class="mt-3 your_rating d-flex align-items-center"
                                style=" @if (!$rate) display:none!important @endif">
                                <strong>Your Rating:
                                    <span>{{ $rate }}</span>/5
                                </strong>
                                <form action="{{ route('rating.destroy', $product->id) }}" class="remove_rating"
                                    method="POST" style="@if (!$rate) display:none @endif">
                                    @csrf @method('DELETE')
                                    <i class="ml-1 text-muted fas fa-times-circle" style="cursor: pointer"></i>
                                </form>
    
                            </div>
    
                        </div>
    
                        <form action='{{ route('reviews.update', $product->id) }}' method="POST" id="contact_form"> @csrf @method('PUT')
                            <div class="mb-4">
                                <input type="text" name="headline" value="{{ old('headline') ?? $review->headline }}"
                                    class="input_field w-100 @error('headline') border border-danger @enderror"
                                    placeholder="Headline" required="required">
                            </div>
                            <div class="contact_form_text mb-2">
                                <textarea id="contact_form_message"
                                    class="text_field contact_form_message @error('body') border border-danger @enderror"
                                    name="body" rows="4" placeholder="Review" required="required"
                                    data-error="Please, write us a review.">{{ old('body') ?? $review->body }}</textarea>
                            </div>
                            <div class="contact_form_button">
                                <button onclick="storeReview(event)" type="submit"
                                    class="px-2 py-1 button contact_submit_button">
                                    Update Review
                                </button>
                            </div>
                        </form>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</div>

@push('scripts')
<script src="{{ asset('frontend/js/jquery.star-rating-svg.js')}}"></script>

<script>
    
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

                    $('.your_rating').fadeOut(() => $('.your_rating strong span').text(`${currentRating}`)).fadeIn()
                    $('.remove_rating').fadeIn()
                },
            });
        }
    });
</script>
@endpush
@endsection