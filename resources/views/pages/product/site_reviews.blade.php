@auth('web')
<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#site-reviews" aria-expanded="false"
    aria-controls="collapseExample">
    Add Review
</button>

<div id="site-reviews" class="contact_form p-0 collapse">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="contact_form_container">
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

                    <form action='{{ route('reviews.store', $product->id) }}' method="POST" id="contact_form"> @csrf
                        <div class="mb-4">
                            <input type="text" name="headline" value="{{ old('headline') }}"
                                class="input_field w-100"
                                placeholder="Headline" required="required">
                        </div>
                        <div class="contact_form_text mb-2">
                            <textarea id="contact_form_message"
                                class="text_field contact_form_message"
                                name="body" rows="4" placeholder="Review" required="required"
                                data-error="Please, write us a review.">{{ old('body') }}</textarea>
                        </div>
                        <div class="contact_form_button">
                            <button onclick="storeReview(event)" type="submit"
                                class="px-2 py-1 button contact_submit_button">Publish
                                Review
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endauth

<div class="col-lg-6 media_reviews p-2 mt-4 bg-light shadow rounded" data-load="false">
    {{-- @include('pages.product.reviews_media') --}}
</div>

<div class="spinner1 spinner-border text-primary position-absolute"
style="left: 50%;top:50%;width: 3rem;height: 3rem;display:none" role="status">
<span class="sr-only">Loading...</span>
</div>

@push('scripts')
<script>
    function toggleBody(e) {
        var el = $(e.target);
        el.siblings('.body_limit').toggle()
        el.siblings('.collapse1').toggle()
        el.text(el.siblings('.collapse1').css('display') == 'none' ? 'See More' : 'See Less')
    }
</script>
@endpush