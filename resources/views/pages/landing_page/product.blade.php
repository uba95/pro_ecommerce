<div class="featured_slider_item">
    <div class="border_active"></div>
    <div class="product_item  d-flex flex-column align-items-center justify-content-center text-center {{ $product->discount_price ? 'discount' :  ($product->isNew() ? 'is_new' : '') }}">
        <div class="product_image d-flex flex-column align-items-center justify-content-center">
            <img src="{{ $product->cover}}" alt="" width="140" style="max-height: 140px">
        </div>
        <div class="product_content">
                @if ($product->discount_price)
                <div class="product_price discount">
                    ${{$product->discount_price}}
                    <span style="text-decoration: line-through #00000060;">
                        {{   '$' . $product->selling_price }}
                    </span>
                </div>
                @else
                <div class="product_price">
                    ${{$product->selling_price}}
                </div>
            @endif
            <div class="product_name">
                <div>
                    <a href='{{ route('products.show', $product->product_slug) }}' style="display: inline-block; width: 140px; overflow: hidden !important; text-overflow: ellipsis;">
                        {{ $product->product_name}}
                    </a>
                </div>
            </div>
            <div class="product_extras">
                <div class="product_color">
                    @foreach ($product->product_color as $color)
                        <input type="radio" name="product_color" style="background: {{ $color }}">
                    @endforeach
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
            <li class="product_mark product_discount">
                -{{ $product->discount_percent  }}%
            </li>
            <li class="product_mark product_new">new</li>
        </ul>
    </div>
</div>
