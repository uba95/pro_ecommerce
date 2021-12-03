{{-- <div class="row justify-content-center"> --}}
@forelse ($products as $product)

<div class="product_item  {{ $product->discount_price ? 'discount' :  ($product->isNew() ? 'is_new' : '') }}">
    <div class="product_border"></div>
    <div class="product_image d-flex flex-column align-items-center justify-content-center">
        <img src="{{$product->cover}}" alt="" width="120" style="max-height: 120px">
    </div>
    <div class="product_content py-4">
        <div class="product_price">

            @if ($product->discount_price)
                ${{ $product->discount_price }}
                <span>${{ $product->selling_price }}</span>
            @else
                ${{ $product->selling_price }}
            @endif
        </div>
        <div class="product_name">
            <div>
                <a tabindex="0" href='{{ route('products.show', $product->product_slug) }}' style="display: inline-block; width: 120px; overflow: hidden !important; text-overflow: ellipsis;">
                    {{ $product->product_name }}
                </a>
            </div>
        </div>
    </div>
    @auth('web')
    <form class="addwishlist" data-id="{{ $product->id }}"> @csrf
        <div class="product_fav {{ current_user()->hasProductOnWishlist($product->id) ? 'active' : ''}}">
            <i class="fas fa-heart"></i>
        </div>    
    </form>  
    @endauth
    <ul class="product_marks">
        <li class="product_mark product_discount"> -{{ $product->discount_percent  }}%</li>
        <li class="product_mark product_new">new</li>
    </ul>
</div>
@empty
<div class="alert alert-danger my-4" style="position: absolute; left: 0; right: 0;">Sorry Nothing Found</div>
@endforelse
{{-- </div> --}}
