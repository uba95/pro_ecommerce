@foreach (range(1,1) as $item)
@forelse ($products as $product)

<div class="product_item {{ $product->discount_price ? 'discount' :  ($product->hot_new ? 'is_new' : '') }}">
    <div class="product_border"></div>
    <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{$product->cover}}" alt=""></div>
    <div class="product_content">
        <div class="product_price">

            @if ($product->discount_price)
                ${{ $product->discount_price }}
                <span>${{ $product->selling_price }}</span>
            @else
                ${{ $product->selling_price }}
            @endif
        </div>
        <div class="product_name">
            <div><a tabindex="0" href='{{ route('products.show', $product->product_slug) }}'>{{ $product->product_name}}</a></div>
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
@endforeach
