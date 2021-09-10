@extends('layouts.app.index')
@section('content')

        <div class="container py-5">
          <h2 class="text-center mb-3">Checkout</h2>
          @if (count($addresses))
            @if (count($cart_products))
            <div class="row mt-5 py-2">
              <div class="col-md-8 order-md-1">
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
              @include('pages.checkout.cart')

              @include('pages.checkout.addresses')

                  <hr class="my-4">
                  @if(optional($shipment)->rates)
                    <div class="position-relative">
                        <h4 class="mb-4"><i class="fa fa-truck"></i> Courier</h4>
                        <ul class="list-unstyled row rates_list">

                          @include('pages.checkout.rates')

                        </ul>
                        <div class="spinner1 spinner-border text-primary position-absolute"
                        style="left:calc(50% - 1.5rem);top:calc(50% - 1.5rem);width: 3rem;height: 3rem;display:none" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                        
                    </div>
                  @endif

                  <div class="custom-control custom-checkbox mt-3">
                    <input type="checkbox" class="custom-control-input" id="same-address">
                    <label class="custom-control-label" for="same-address">Shipping address is not same as my billing address</label>
                  </div>
                  <hr class="mb-4">
                  
                  @include('pages.payment.payment_options')

                </form>
              </div>
            </div>
            @else
              <div class="alert alert-danger"> 
                Your Cart Is Empty, Start  <a href ='{{ route('pages.landing_page.index') }}'>Shopping Now!</a>
              </div> 
            @endif
          @else
           <div class="alert alert-danger"> 
             No Address Found, Please Add New <a href ='{{ route('addresses.create') }}'>Address</a>
            </div>
          @endif
        </div>

    @push('scripts') 
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
  
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
  
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>

    <script>
      var rate_input =  "input[name='rate']";

      function rateInput(rateInputElement) {
        // $('.display_coupon').attr('style', 'display: none !important');
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

      $(document).on('change', function(e) {
        var billing_address = "input[name='billing_address']";
        var shipping_address = "input[name='shipping_address']";
        var billingInput = "input[name='billing']";
        var shippingInput = "input[name='shipping']";
        var sameAddress =  $('#same-address');
        var billingChecked = $(billingInput + ":checked");
        var shippingChecked = $(shippingInput + ":checked");
        var shippingTrigger = sameAddress.is(':checked') ? shippingChecked : billingChecked;
        var targetIsSameAddress = $(e.target).is(sameAddress);
        var targetIsShippingTrigger = $(e.target).is(shippingTrigger);

        $(billing_address).val(billingChecked.data('id'));
        $(shipping_address).val(shippingTrigger.data('id'));

        if (targetIsSameAddress) {
          $("#shipping_address").toggle(e.target.checked);
          if (e.target.checked) {
            $(shippingInput).attr('disabled', false);
          } else {
            $(shippingInput).attr('disabled', true);
          }
        }

        if(targetIsShippingTrigger || (targetIsSameAddress && billingChecked.data('id') != shippingChecked.data('id'))) {

          var address_id = $(e.target).data('id');
          if (targetIsSameAddress) {
            address_id = $(shippingTrigger).data('id')
          }
          $.ajax({
            url: `/checkout`,
            type:"GET",
            dataType:"json",
            data:{"address_id": address_id},
            beforeSend: function() {
              spinner(true, '.rates_list', '.spinner1');
            },
            success: function(data) { 
              spinner(false, '.rates_list', '.spinner1');

              $('.rates_list').html(data.html);
              rateInput($(rate_input));
            },
          });
        }
      });

      $(document).on('submit', '#coupon_form', function(e) {
        e.preventDefault();

        $.ajax({
              url: $(this).attr('action'),
              type:"POST",
              dataType:"json",
              data:  $(this).serializeArray(),
              success: function(data) { 
                $('#coupon_form .error').empty();
                $('.display_coupon').attr('style', 'display: none !important');
                $('input[name="coupon_name"]').val('');
                if (data.error) {
                  data.total ? $('.total_pay').text((data.total).toFixed(2)) : '';
                  return $('#coupon_form .error').append(`<div class="alert alert-danger mt-3">${data.error}</div>`);
                }
                $('.display_coupon').attr('style', 'display: block !important');
                $('.coupon_code').text(`${data.coupon.coupon_name}  ${data.coupon.discount}%`);
                $('.discount_price').text(data.discount);
                $('.total_pay').text((data.total).toFixed(2));
                $('#coupon_delete').attr('action', data.route);
              },
              beforeSend: function() {
                spinner(true, '.cart_products', '.spinner2');
              },
              complete: function() {
                spinner(false, '.cart_products', '.spinner2');
              },
            });
      });

      $(document).on('click', '#coupon_delete', function(e) {
        e.preventDefault();
        $.ajax({
              url: $(this).attr('action'),
              type:"DELETE",
              dataType:"json",
              data: {'_token': '{{ csrf_token() }}', 'rate_amount':  $('input[name="rate_amount"]').val()},
              success: function(data) { 
                $('.display_coupon').attr('style', 'display: none !important');
                $('.total_pay').text((data.total).toFixed(2));

                if (data.error) {
                  return $('#coupon_form .error').append(`<div class="alert alert-danger mt-3">${data.error}</div>`);
                }
               
              },
              beforeSend: function() {
                spinner(true, '.cart_products', '.spinner2');
              },
              complete: function() {
                spinner(false, '.cart_products', '.spinner2');
              },
            });
      });
    </script>
    @endpush

@endsection

