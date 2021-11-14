@extends('layouts.home')
@section('section')
    @push('styles')
        <style>
            * {
                margin: 0;
                padding: 0
            }

            html {
                height: 100%
            }

            #grad1 {
                background-color: #eee;
                border-radius: 10px;
                /* background-image: linear-gradient(120deg, #FF4081, #81D4FA) */
            }

            #payment-form {
                text-align: center;
                position: relative;
                margin-top: 20px
            }

            #payment-form fieldset .form-card {
                background: white;
                border: 0 none;
                border-radius: 0px;
                box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
                padding: 20px 40px 30px 40px;
                box-sizing: border-box;
                width: 94%;
                margin: 0 3% 20px 3%;
                position: relative
            }

            #payment-form fieldset {
                background: white;
                border: 0 none;
                border-radius: 0.5rem;
                box-sizing: border-box;
                width: 100%;
                margin: 0;
                padding-bottom: 20px;
                position: relative
            }

            #payment-form fieldset:not(:first-of-type) {
                display: none
            }

            #payment-form fieldset .form-card {
                text-align: left;
                color: #9E9E9E
            }

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

            #payment-form input:focus,
            #payment-form textarea:focus {
                -moz-box-shadow: none !important;
                -webkit-box-shadow: none !important;
                box-shadow: none !important;
                border: none;
                font-weight: bold;
                border-bottom: 2px solid #0e8ce4;
                outline-width: 0
            }

            #payment-form .action-button {
                width: 100px;
                background: #0e8ce4;
                font-weight: bold;
                color: white;
                border: 0 none;
                border-radius: 10px;
                cursor: pointer;
                padding: 10px 7px;
                margin: 10px 5px
            }

            #payment-form .action-button:hover,
            #payment-form .action-button:focus {
                box-shadow: 0 0 0 2px white, 0 0 0 3px #0e8ce4
            }

            #payment-form .action-button-previous {
                width: 100px;
                background: #616161;
                font-weight: bold;
                color: white;
                border: 0 none;
                border-radius: 10px;
                cursor: pointer;
                padding: 10px;
                margin: 10px 5px
            }

            #payment-form .action-button-previous:hover,
            #payment-form .action-button-previous:focus {
                box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
            }

            select.list-dt {
                border: none;
                outline: 0;
                border-bottom: 1px solid #ccc;
                padding: 2px 5px 3px 5px;
                margin: 2px
            }

            select.list-dt:focus {
                border-bottom: 2px solid #0e8ce4
            }

            .card {
                z-index: 0;
                border: none;
                border-radius: 0.5rem;
                position: relative
            }

            .fs-title {
                font-size: 25px;
                color: #2C3E50;
                margin-bottom: 10px;
                font-weight: bold;
                text-align: left
            }

            #progressbar {
                margin-bottom: 30px;
                overflow: hidden;
                color: lightgrey
            }

            #progressbar .active {
                color: #000000
            }

            #progressbar li {
                list-style-type: none;
                font-size: 12px;
                width: 25%;
                float: left;
                position: relative
            }

            #progressbar #order:before {
                font-family: "Font Awesome 5 Free";
                content: "\f328";
                font-weight: 900;
            }

            #progressbar #reason:before {
                font-family: "Font Awesome 5 Free";
                content: "\f075";
                font-weight: 900;
            }

            #progressbar #address:before {
                font-family: "Font Awesome 5 Free";
                content: "\f3c5";
                font-weight: 900;
            }

            #progressbar #payment:before {
                font-family: "Font Awesome 5 Free";
                content: "\f09d";
                font-weight: 900;
            }

            #progressbar #courier:before {
                font-family: "Font Awesome 5 Free";
                content: "\f0d1";
                font-weight: 900;
            }
            #progressbar #submit:before {
                font-family: "Font Awesome 5 Free";
                content: "\f00c";
                font-weight: 900;
            }

            #progressbar li:before {
                width: 50px;
                height: 50px;
                line-height: 45px;
                display: block;
                font-size: 18px;
                color: #ffffff;
                background: lightgray;
                border-radius: 50%;
                margin: 0 auto 10px auto;
                padding: 2px
            }

            #progressbar li:after {
                content: '';
                width: 100%;
                height: 2px;
                background: lightgray;
                position: absolute;
                left: 0;
                top: 25px;
                z-index: -1
            }

            #progressbar li.active:before,
            #progressbar li.active:after {
                background: #0e8ce4
            }

            input[type=radio] {width: auto !important;}

            .fit-image {
                width: 100%;
                object-fit: cover
            }

        </style>
    @endpush

    <form action="{{ route('cancel_orders.store') }}" class="col-8" id="payment-form" method="POST"> @csrf
        
        <input type="hidden" name="rate_object_id"  value="">
        <input type="hidden" name="billing_address"  value="">
        <input type="hidden" name="shipping_address"  value="">

        <div class="card">
            <!-- MultiStep Form -->
            <div class="container-fluid" id="grad1">
                <div class="row justify-content-center mt-0">
                    <div class="col-11  text-center p-0 mt-3 mb-2">
                        <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                            <h2><strong>Cancel Order Request</strong></h2>
                            <p>Fill all form field to go to next step</p>
                            <div class="row">
                                <div class="col-md-12 mx-0">
                                    @if ($orders->isNotEmpty())
                                        <!-- progressbar -->
                                        <ul id="progressbar">
                                            <li class="active" id="order"><strong>Select Order</strong></li>
                                            <li id="address"><strong>Address</strong></li>
                                            <li id="courier"><strong>Courier</strong></li>
                                            <li id="submit"><strong>Submit</strong></li>
                                        </ul> <!-- fieldsets -->
                                        <fieldset>
                                            <div class="form-card">
                                                
                                                    
                                                <h2 class="fs-title">Select Order</h2> 

                                                <label for="order_select">Order Id</label>
                                                <select name="order_id" class="custom-select d-block w-100" id="order_select" required>
                                                <option value="">Choose Order Id</option>
                                                @foreach ($orders as $order)
                                                <option value="{{ $order->id }}">{{ $order->id }}</option>
                                                @endforeach
                                                </select>

                                                <div style="display: none" id="order_items">
                                                    <label id="order_items_label" for="order_items" class="mt-4">Order Items</label>
                                                    <table class="table">
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
                                                    <button class="btn btn-danger mt-4 cancelWithoutAjax" formaction="{{ route('cancel_orders.store', ['cancelAll' => true]) }}" 
                                                        style="display:none">
                                                            Cancel All
                                                    </button>        
                                                </div>
                                            </div> 
                                            <input type="button"  class="next action-button" value="Next Step" />
                                        </fieldset>


                                        <fieldset>
                                            <div class="form-card">
                                                <h2 class="fs-title">Address</h2> 
                                                
                                                @include('pages.checkout.addresses', ['addresses' => $order->user->addresses])
                                                </div>
                                                <div class="custom-control custom-checkbox mt-3">
                                                    <input type="checkbox" class="custom-control-input" id="same-address">
                                                    <label class="custom-control-label" for="same-address">Shipping address is not same as my billing address</label>
                                                </div>

                                            </div> 

                                            <input type="button"  class="previous action-button-previous" value="Previous" /> 
                                            <input id="courierNext" type="button"  class="next action-button" value="Next Step" />
                                        </fieldset>


                                        <fieldset>
                                            <div class="form-card">
                                                <h2 class="fs-title">Courier</h2> 
                                                <div class="position-relative">
                                                    <h4 class="mb-4"><i class="fa fa-truck"></i> Courier</h4>
                                                    <ul class="list-unstyled row rates_list">
                            
                                                    </ul>
                                                    <div class="spinner1 spinner-border text-primary position-absolute"
                                                    style="left: 50%;top:50%;width: 3rem;height: 3rem;display:none" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                    </div>
                                                    
                                                </div>
                                            </div> 
                                            <input type="button"  class="previous action-button-previous" value="Previous" />
                                            <input type="button"  class="next action-button" value="Next Step" />
                                        </fieldset>

                                        <fieldset>
                                            <div class="form-card">
                                                <h2 class="fs-title">Submit</h2> 
                                                <div class="position-relative itemsAfter">
                                                    
                                                </div>
                                            <button type="submit" class="btn btn-success mt-4" style="display: none">Submit Request</button>
                                            </div> 
                                            <input type="button"  class="previous action-button-previous" value="Previous" /> 
                                        </fieldset>

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
        <script>
            $(document).ready(function() {

                var current_fs, next_fs, previous_fs; //fieldsets
                var opacity;

                $(".next").click(function() {

                    current_fs = $(this).parent();
                    next_fs = $(this).parent().next();

                    //Add Class Active
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now) {
                            // for making fielset appear animation
                            opacity = 1 - now;

                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            next_fs.css({
                                'opacity': opacity
                            });
                        },
                        duration: 600
                    });

                    // function validateForm() {
                    //     var x, y, i, valid = true;
                    //     x = document.getElementsByTagName("fieldset");
                    //     y = x[currentTab].getElementsByTagName("input");
                    //     for (i = 0; i < y.length; i++) {
                    //         if (y[i].value == "") {
                    //             y[i].className += " invalid";
                    //             valid = false;
                    //         }
                    //     }

                    //     if (valid) {
                    //         document.getElementsByClassName("step")[currentTab].className += " finish";
                    //     }
                    //     return valid;
                    // }       

                });

                $(".previous").click(function() {

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //Remove class active
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show();

                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now) {
                            // for making fielset appear animation
                            opacity = 1 - now;

                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            previous_fs.css({
                                'opacity': opacity
                            });
                        },
                        duration: 600
                    });
                });


                $(".submit").click(function() {
                    return false;
                })

            });

        </script>

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

                        var order_items = $('#order_items');
                        var order_item = $('#order_item');
                        
                        if (data.error) {
                            return toastr.error(data.error)
                        }

                        order_items.fadeOut(600, function () {

                            order_item.empty();
                            order_item.append(`<input name="order_id" type="hidden" value="${order_id}">`);
                            
                            data.forEach( (value) => order_item.append(
                                `
                                <tr>
                                    <td scope="row">
                                        <input name="order_items[]" type="checkbox" value="${value.id}">
                                    </td>
                                    <td>${value.product_name}</td>
                                    <td><span style="background-color:${value.product_color}">&nbsp; &nbsp; &nbsp;</span></td>
                                    <td>${value.product_size || ''} </td>
                                    <td>
                                        <input name="quantity[]" type="number" value="1" min="1" max="${value.product_quantity}">
                                    </td>
                                    <td>${value.product_price}$</td>
                                <tr>
                                `
                            ));

                            var quantity = $('input[name="quantity[]"]');
                            // $('input[name="order_items[]"]').first().prop('checked', true)
                            // quantity.not(quantity.first()).attr('disabled', true);
                            quantity.attr('disabled', true);
                            $('button.cancelWithoutAjax').fadeIn()
                        }).fadeIn(600);
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

            var rate_input =  "input[name='rate']";

            function rateInput(rateInputElement) {
                var rate_amount = parseFloat($('.rate_amount').text().replace( /[^\d\.]*/g, ''));
                var total_pay = parseFloat($('.total_pay').text().replace( /[^\d\.]*/g, ''));
            
                $('.rate_provider').text(rateInputElement.data('provider'));
                $('.rate_days').text(rateInputElement.data('days') + ' days');
                $('.rate_amount').text('$' + rateInputElement.data('amount'));
                $('.total_pay').text((total_pay - rate_amount + parseFloat(rateInputElement.data('amount'))).toFixed(2));
                $('input[name="rate_amount"]').val(rateInputElement.data('amount'));
                $('input[name="rate_object_id"]').val(rateInputElement.val());
            }

            $(document).on('change', rate_input, (e) => rateInput($(e.target)));

            function spinner(when, el, spinner) {

                if (when) {
                    $(el).css('opacity', '0.5');
                    $(spinner).css('display', 'block');
                } else {
                    $(el).css('opacity', '1');
                    $(spinner).css('display', 'none');
                }
            }

            $( "#courierNext" ).on( "click", function() {
                $( "#courierNext" ).trigger( "change" );
            });
            
            $(document).on('change', function(e) {
                var order_items = "input[name='order_items[]']";
                var billing_address = "input[name='billing_address']";
                var shipping_address = "input[name='shipping_address']";
                var billingInput = "input[name='billing']";
                var shippingInput = "input[name='shipping']";
                var sameAddress =  $('#same-address');
                var billingChecked = $(billingInput + ":checked");
                var shippingChecked = $(shippingInput + ":checked");
                var shippingTrigger = sameAddress.is(':checked') ? shippingChecked : billingChecked;
                var targetIsSameAddress = $(e.target).is(sameAddress);

                $(billing_address).val(billingChecked.data('id'));
                $(shipping_address).val(shippingTrigger.data('id'));

                if (targetIsSameAddress) {
                    $("#shipping_address").toggle(e.target.checked);
                    e.target.checked ? $(shippingInput).attr('disabled', false) : $(shippingInput).attr('disabled', true);
                }

                if ($(e.target).is($(order_items))) {
                    var quantity =  $(e.target).parent().siblings().find("input[name='quantity[]']");
                    e.target.checked ? $(quantity).attr('disabled', false) : $(quantity).attr('disabled', true);
                }

                if($(e.target).is($('#courierNext'))) {

                var address_id = $(shippingTrigger).data('id');

                $.ajax({
                    url: `/cancel_orders/create?address_id=${address_id}`,
                    type:"GET",
                    dataType:"json",
                    data:  $('form').serializeArray(),
                    beforeSend: function() {
                    spinner(true, '.rates_list', '.spinner1');
                    $('button[type="submit"]').fadeOut()
                    },
                    success: function(data) { 
                    spinner(false, '.rates_list', '.spinner1');
                    if (data.error) {
                            return toastr.error(data.error)
                    }
                    $('.rates_list').html(data.html);
                    $('.itemsAfter').html(data.itemsAfter);
                    $('button[type="submit"]').fadeIn()
                    rateInput($(rate_input));
                    },
                });
                }
            });
        </script>
    @endpush
@endsection
