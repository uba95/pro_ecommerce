<div class="product_details py-5">
    <div class="container">

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="font-size: 1rem">
                <a class="nav-link active mx-1" id="nav-details-tab" data-toggle="tab" href="#nav-details" role="tab"
                    aria-controls="nav-details" aria-selected="true">Product Details</a>
                @if ($product->video_embed)
                <a class="vid-tab nav-link mx-1" id="nav-video-tab" data-toggle="tab" href="#nav-video" role="tab"
                    aria-controls="nav-video" aria-selected="false">Video Link</a>
                @endif
                <a class="review-tab nav-link mx-1" id="nav-review-tab" data-toggle="tab" href="#nav-review" role="tab"
                    aria-controls="nav-review" aria-selected="false">Product Review</a>
            </div>
        </nav>

        <div class="tab-content py-4" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab"
                style="word-break: break-all">
                {!! $product->product_details !!}
            </div>

            <div class="tab-pane fade video_embed" id="nav-video" role="tabpanel" aria-labelledby="nav-video-tab">
                <iframe class="iframe-placeholder" src="" width="560" height="315" title="YouTube video player"
                    data-src="false" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>

            {{-- Start Reviews Tabs --}}

            <div class="tab-pane fade ml-3" style="font-size: 13px" id="nav-review" role="tabpanel"
                aria-labelledby="nav-review-tab">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="font-size: .7rem">
                        <a class="nav-link active mx-1" id="nav-site-reviews-tab" data-toggle="tab"
                            href="#nav-site-reviews" role="tab" aria-controls="nav-site-reviews"
                            aria-selected="true">Site Reviews</a>
                        <a class=" nav-link mx-1" id="nav-facebook-reviews-tab" data-toggle="tab"
                            href="#nav-facebook-reviews" role="tab" aria-controls="nav-facebook-reviews"
                            aria-selected="false">Facebook Reviews</a>
                    </div>
                </nav>
                <div class="tab-content py-4" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-site-reviews" role="tabpanel"
                        aria-labelledby="nav-site-reviews-tab" style="word-break: break-all">

                        @include('pages.product.site_reviews')
                    </div>

                    <div class="tab-pane fade" id="nav-facebook-reviews" role="tabpanel"
                        aria-labelledby="nav-facebook-reviews-tab">
                        <div class="iframe-placeholder" style="display: none;height:100px"></div>
                        <div class="fb-comments" data-href="{{ request()->url() }}"  data-numposts="5"></div>
                        {{-- <div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-width="" data-numposts="5"></div> --}}
                    </div>
                </div>
            </div>

            {{-- End Reviews Tabs --}}

        </div>
    </div>
</div>