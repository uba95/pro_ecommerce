<div class="rating_r rating_r_4 product_rating">
    <div class="d-flex">
        <div class="get-rating mr-2"></div>
        <span style="margin-top: 2px;">
            {{ $avgRating }} 
            ( {{ $countRating }} {{ Str::plural('rating', $countRating) }}  )
        </span>
    </div>
    <div class="rate-this text-muted my-2" style="cursor: pointer;font-size: 12px" data-toggle="modal" data-target="#rate-this">
        @auth('web')
            <strong>
                    <span style="@if (!$rate) display:none @endif">
                        Your Rating: <span class="ml-1">{{ $rate }}</span>/5
                    </span>
                    <span style="@if ($rate) display:none @endif">
                        Rate This
                    </span>
            </strong>
            <i class="fa fa-star"></i>
        @endauth
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rate-this" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Rate This</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body text-center">
        <div class="my-rating"></div>
        <div class="mt-3 your_rating" style="@if (!$rate) display:none @endif">
            <strong>Your Rating: 
                <span>{{ $rate }}</span>/5
            </strong>
        </div>
    </div>
    <div class="modal-footer justify-content-start ">
        <form action="{{ route('rating.destroy', $product->id) }}" class="remove_rating" 
            method="POST"  style="@if (!$rate) display:none @endif"> 
            @csrf @method('DELETE')
            <button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-trash"></i></button>
        </form>
    </div>
    </div>
</div>
</div>