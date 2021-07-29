@extends('layouts.app')
@section('content')
    {{-- @include('layouts.menubar') --}}
    @push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/product_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/product_responsive.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_styles.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_responsive.css') }}">
    @endpush


    <div class="super_container">
	    
        <!-- Cart -->
    
        <div class="cart_section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="cart_container">
                            <div class="cart_title">Shopping Cart</div>
                            <div class="cart_items">
                                <ul class="cart_list">

                                    @forelse ($cart_products as $cart_product)
                                        
                                    <li class="cart_item clearfix">
                                        <div class="cart_item_image"><img src="{{ $cart_product->options->image }}" alt="{{ $cart_product->name }}"></div>
                                        <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                            <div class="cart_item_name cart_info_col">
                                                <div class="cart_item_title">Name</div>
                                                <div class="cart_item_text text-center"><a href='{{ route('products.show', $cart_product->name) }}'>{{ $cart_product->name }}</a></div>
                                            </div>
                                            <div class="cart_item_color cart_info_col">
                                                <div class="cart_item_title">Color</div>
                                                <div class="cart_item_text text-center"><span style="background-color:{{ $cart_product->options->color }}"></span></div>
                                            </div>
        

                                            <div class="cart_item_quantity cart_info_col">
                                                <div class="cart_item_title">Quantity</div>
                                                <div class="cart_item_text text-center" style="margin-top: 25px;">
                                                    <div class="product_quantity clearfix">
                                                        <input name="product_quantity" class="quantity_input" type="number" min="1" max="{{$products->filter(fn($v) => $v->id === $cart_product->id)->first()->product_quantity }}"
                                                         value="{{ $cart_product->qty }}"data-id="{{ $cart_product->rowId }}"  style="width: 40px;" id="{{ 'quantity_input' . $cart_product->rowId }}">
                                                        <div class="quantity_buttons">
                                                            <div class="quantity_inc quantity_control quantity_inc_button" data-id="{{ $cart_product->rowId }}" style="z-index: 1000;"><i class="fas fa-chevron-up"></i></div>
                                                            <div class="quantity_dec quantity_control quantity_dec_button" data-id="{{ $cart_product->rowId }}" style="z-index: 1000;"><i class="fas fa-chevron-down"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($cart_product->options->size)
                                                <div class="cart_item_quantity cart_info_col">
                                                    <div class="cart_item_title">Size</div>
                                                    <div class="cart_item_text text-center">{{ $cart_product->options->size }}</div>
                                                </div>
                                            @endif
                                            <div class="cart_item_price cart_info_col">
                                                <div class="cart_item_title">Price</div>
                                                <div class="cart_item_text text-center">${{ $cart_product->price }}</div>
                                            </div>
                                            <div class="cart_item_total cart_info_col">
                                                <div class="cart_item_title">Total</div>
                                                <div class="cart_item_text text-center" id="{{'cartItem_price' . $cart_product->rowId }}">
                                                    ${{ $cart_product->price * $cart_product->qty }}
                                                </div>
                                            </div>
                                            <div class="cart_item_total cart_info_col">
                                                <div class="cart_item_title">Action</div>
                                                <div class="cart_item_text text-center">
                                                    <form action ='{{ route('cart.destroy', $cart_product->rowId) }}' class="delete" style="cursor:pointer">
                                                        @csrf @method('DELETE')
                                                        <i class="fa fas fa-times btn btn-danger" ></i>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    @empty
                                        <h4 style="padding: 20px;color:#888">Your Cart Is Empty</h4>
                                    @endforelse
                                </ul>
                            </div>
                            
                            <!-- Order Total -->
                            <div class="order_total">
                                <div class="order_total_content text-md-right">
                                    <div class="order_total_title">Order Subtotal:</div>
                                    <div class="order_total_amount">${{ Cart::priceTotal() }}</div>
                                    <span class="small font-weight-bold text-muted ml-1">Without Taxes Or Shipping Cost</span>
                                </div>
                            </div>

                            <div class="cart_buttons" style="display: {{ !$cart_products->count() ? 'none' : ''}}">
                                <form action ='{{ route('cart.destroyAll') }}' class="destroyAll button cart_button_clear" method="POST">
                                    @csrf @method('DELETE')
                                    Cancel
                                </form>
                                <a href ='{{ route('checkout.index') }}' class="button cart_button_checkout">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    @push('scripts')
        {{-- <script src="{{ asset('frontend/js/product_custom.js')}}"></script> --}}
        <script src="{{ asset('frontend/js/cart_custom.js')}}"></script>
        <script src="https://unpkg.com/underscore@1.12.0/underscore-min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(document).on('change', '.quantity_input', _.debounce(function(e){
                    e.preventDefault();
                    var id = $(this).data('id');
                    var val = $(this).val();
                    if (id && val > 0) {
                        $.ajax({
                            url: `/cart/${id}`,
                            type:"PATCH",
                            datType:"json",
                            data: {"_token": "{{  csrf_token() }}", 'val' : val},
                            success:function(data){

                                    $('.order_total_amount').text('$' + data.cart_price);
                                    $('.cart_count').text(data.cart_count)
                                    $('.cart_price').text('$' + data.cart_price)
                                    $('#cartItem_price'+id).text('$' + data.cartItem_price)
                        },
                    });
            
                    }else{
                        alert('danger');
                    }
                }, 300));
            });
        </script>
        <script>
            $(function () {
                function initQuantity() {
                    // Handle product quantity input
                    if($('.product_quantity').length)
                    {
                        var input = $('.quantity_input');
                        var incButton = $('.quantity_inc_button');
                        var decButton = $('.quantity_dec_button');

                        var originalVal;
                        var endVal;

                        incButton.on('click', function()
                        {
                            var id =  $(this).data('id');
                            var input =  $('#quantity_input'+id).length > 0 ? $('#quantity_input'+id) : $('.quantity_input'); 
                            originalVal = input.val();
                            if (input.val() == input.attr('max')) {return}
                            endVal = parseFloat(originalVal) + 1;
                            input.val(endVal).trigger( "change" )
                            // input.attr('value', endVal);
                        });

                        decButton.on('click', function()
                        {
                            var id =  $(this).data('id');
                            var input =  $('#quantity_input'+id).length > 0 ? $('#quantity_input'+id) : $('.quantity_input'); 

                            originalVal = input.val();
                            if(originalVal > 1)
                            {
                                endVal = parseFloat(originalVal) - 1;
                                input.val(endVal).trigger( "change" );
                            }
                        });
                    }
                }
                initQuantity();
            });
        </script>
    @endpush

@endsection