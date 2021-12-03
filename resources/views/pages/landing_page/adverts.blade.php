@if ($adverts->isNotEmpty())
    <div class="adverts">
        <div class="container">
            <div class="row">
                @foreach ($adverts as $advert)
                    <div class="col advert_col">
                        <div class="advert d-flex flex-row align-items-center justify-content-start">
                            <div class="advert_content">
                                <div class="advert_title"><a>{{ $advert->advert_headline }}</a></div>
                                <div class="advert_text">{{ $advert->advert_text }}</div>
                            </div>
                            <div class="ml-auto"><div class="advert_image" style="height: 180px;width: auto;">
                                <img src="{{ $advert->advert_img }}" alt="" style="max-height: 100%;max-width: none;">
                            </div></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
