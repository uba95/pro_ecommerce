@extends('layouts.app')
@section('content')
<div class="d-flex flex-wrap">
@foreach (range(1,10) as $item)
@forelse ($wishlist_items as $wishlist_item)
<div class="featured_slider_item col-md-2">
    <div class="border_active"></div>
    <div class="product_item  d-flex flex-column align-items-center justify-content-center text-center {{ $wishlist_item->product->discount_price ? 'discount' :  ($wishlist_item->product->hot_new ? 'is_new' : '') }}">
        <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ $wishlist_item->product->image_one}}" alt="" height="120" width="100"></div>
        <div class="product_content">
                @if ($wishlist_item->product->discount_price)
                <div class="product_price discount">
                    ${{$wishlist_item->product->discount_price}}
                    <span>
                        {{   '$' . $wishlist_item->product->selling_price }}
                    </span>
                </div>
                @else
                <div class="product_price">
                    ${{$wishlist_item->product->selling_price}}
                </div>
            @endif
            <div class="product_name"><div><a href='{{ route('products.show', $wishlist_item->product->product_name) }}'>{{ $wishlist_item->product->product_name}}</a></div></div>
            <div class="product_extras">
                <div class="product_color">
                    <input type="radio" checked name="product_color" style="background:#b19c83">
                    <input type="radio" name="product_color" style="background:#000000">
                    <input type="radio" name="product_color" style="background:#999999">
                </div>
                {{-- <form class="addcart" data-id="{{ $wishlist_item->product->id }}"> @csrf
                    <button class="product_cart_button">Add to Cart</button>
                </form>   --}}
            </div>
        </div>
        
        @auth
        <form class="addwishlist" data-id="{{ $wishlist_item->product->id }}"> @csrf
            <div class="product_fav {{ Auth::user()->hasProductOnWishlist($wishlist_item->product->id) ? 'active' : ''}}">
                <i class="fas fa-heart"></i>
            </div>    
        </form>  
        @endauth

        <ul class="product_marks">
            <li class="product_mark product_discount">
                -{{ $wishlist_item->product->discount_percent  }}%
            </li>
            <li class="product_mark product_new">new</li>
        </ul>
    </div>
</div>
@empty
<div class="alert alert-danger">Your Wishlist Is Empty.</div>
@endforelse

@endforeach
</div>
@endsection