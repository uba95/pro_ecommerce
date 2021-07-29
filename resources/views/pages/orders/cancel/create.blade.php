@extends('layouts.home')
@section('section')
    @push('styles')
        <style>
            #payment-form input,
            #payment-form textarea {
                padding: 0px 8px 4px 8px;
                border: none;
                border-bottom: 1px solid #ccc;
                border-radius: 0px;
                margin-bottom: 25px;
                margin-top: 2px;
                width: 100%;
                box-sizing: border-box;
                font-family: montserrat;
                color: #2C3E50;
                font-size: 16px;
                background-color: #f9f9f9;
                letter-spacing: 1px
            }
        </style>
    @endpush

        <div class="card col-8">
            <!-- MultiStep Form -->
            <div class="container-fluid" id="grad1">
                <div class="row justify-content-center mt-0">
                    <div class="col-11  text-center p-0 mt-3 mb-2">
                        <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                            <h2><strong>Cancel Order Request</strong></h2>
                            <div class="row">
                                <div class="col-md-12 mx-0">
                                    @if ($orders->isNotEmpty())
                                    <div class="form-card">
                                                
                                        <h5 class="fs-title">Select Order</h5> 
                                        <form action="{{ route('cancel_orders.store') }}" id="payment-form" method="POST">
                                            @csrf
                                            <select name="order_id" class="custom-select d-block w-100 m-0" id="order_select" required>
                                            <option value="">Choose Order</option>
                                            @foreach ($orders as $order)
                                            <option value="{{ $order->id }}">{{ $order->id }}</option>
                                            @endforeach
                                            </select>

                                            <label id="order_items_label" style="display: none" for="order_items" class="mt-4">Order Items</label>
                                            <table class="table" style="display: none" id="order_items">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Select</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Color</th>
                                                        <th scope="col">Size</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Unit Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="order_item">
                                                </tbody>
                                            </table>
                                            <button type="submit" class="btn btn-success btn-block mb-1" style="display: none">Submit</button>
                                        </form>
                                        @if ($errors->any())
                                            <div class="alert alert-danger mt-5">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li class="mg-t-10"><strong>{{ $error }}</strong></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                
                                    </div> 
                                @else
                                    <div class="alert alert-danger">There're No Any Orders Can Be Canceled.</div>
                                @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')

        <script type="text/javascript">
            $(document).ready(function(){
                $(document).on('change', 'select[name="order_id"]',function(){
                    var order_id = $(this).val();
                    if (order_id) {
                    
                    $.ajax({
                        url: `/orders/${order_id}?cancel=1`,
                        type:"GET",
                        dataType:"json",
                        success:function(data) { 
                        var order_item = $('#order_item');
                        $('#order_items_label').fadeIn();
                        order_item.empty();
                        $('#order_items').fadeOut(600, function () {
                            if (data.error) {
                                return toastr.error(data.error)
                            }
                            data.forEach( (value) => order_item.append(
                                `
                                <tr>
                                    <td scope="row">
                                        <input name="order_items[]" type="checkbox" value="${value.id}">
                                    </td>
                                    <td>${value.product_name}</td>
                                    <td>${value.product_color}</td>
                                    <td>${value.product_size}</td>
                                    <td style="width: 60px">
                                        <input name="quantity[]" type="number" value="1" min="1" max="${value.product_quantity}">
                                    </td>
                                    <td>${value.product_price}$</td>
                                <tr>
                                `
                            ));
                            var quantity = $('input[name="quantity[]"]');
                            $('input[name="order_items[]"]').first().prop('checked', true)
                            quantity.not(quantity.first()).attr('disabled', true);
                        }).fadeIn(600);
                        $('button').fadeIn();
                        },
                        error: function (data) {
                            return toastr.error(data.responseJSON.message)
                        }
                    });
                    }
                });
            });
        </script>

        <script>
            $(document).on('change', function(e) {
                    if ($(e.target).is($("input[name='order_items[]']"))) {
                        var quantity =  $(e.target).parent().siblings().find("input[name='quantity[]']");
                        e.target.checked ? $(quantity).attr('disabled', false) : $(quantity).attr('disabled', true);
                    }
                });
        </script>
    @endpush
@endsection
