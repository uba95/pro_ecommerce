<div class="col-md-4 order-md-2 mb-4">
  <h4 class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted">Your cart</span>
    <span class="badge badge-secondary badge-pill">{{ Cart::count() }}</span>
  </h4>
  <ul class="list-group mb-3 cart_products position-relative">
    @foreach ($cart_products as $cart_product)
      <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
          <h6 class="my-0">{{ $cart_product->name }}</h6>
          <small class="text-muted">Quantity: {{ $cart_product->qty }}</small>
        </div>
        <span class="text-muted">${{ $cart_product->price * $cart_product->qty }}</span>
      </li>
    @endforeach

    <div class="display_coupon" style="display: none">
      <li class="list-group-item d-flex justify-content-between bg-light">
          <div class="text-success">
            <h6 class="my-0">Coupon 
              <form id="coupon_delete" class="d-inline" style="cursor:pointer">
                <i class="fa fas fa-times btn btn-danger" style="font-size: 12px;padding: 0px 2px;"></i>
              </form>
            </h6>
            <small class="coupon_code">EXAMPLECODE</small>
  
          </div>
          
          <span class="text-success">-$<span class="discount_price">5</span></span>

      </li>
    </div>

    <li class="list-group-item d-flex justify-content-between lh-condensed">
      <div>
        <h6 class="my-0">Shipping Cost</h6>
        <small class="text-muted rate_provider">
          {{  $shipment->rates[0]->servicelevel->name . ' ' .  $shipment->rates[0]->provider }}}}
        </small> <br>
        <small class="text-muted rate_days"> {{  $shipment->rates[0]->estimated_days  }} days</small>
      </div>
      <span class="text-muted rate_amount">${{ $shipment->rates[0]->amount }}</span>
    </li>

    <li class="list-group-item d-flex justify-content-between">
      <span>Total (USD)</span>
      <strong class="total_pay">${{ Cart::priceTotal() + $shipment->rates[0]->amount }}</strong>
    </li>

    <div class="spinner2 spinner-border text-primary position-absolute"
    style="left: 50%;top:50%;width: 3rem;height: 3rem;display:none" role="status">
      <span class="sr-only">Loading...</span>
    </div>  

  </ul>

  <form action ='{{ route('checkout.coupon') }}' id="coupon_form" class="card p-2">
    @csrf
    <div class="input-group">
      <input type="hidden" name="rate_amount" value="{{ $shipment->rates[0]->amount }}">
      <input type="text" name="coupon_name" class="form-control" placeholder="Apply Coupon">
      <div class="input-group-append">
        <button class="btn btn-secondary">Apply</button>
      </div>
    </div>
    <div class="error"></div>
  </form>
</div>
