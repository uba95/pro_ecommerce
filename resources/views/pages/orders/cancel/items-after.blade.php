<div class="mb-4">
  @if ($remainingItems->isNotEmpty())

    <h4 class="d-flex justify-content-between align-items-center mb-3">
      <span class="text-muted">New Invoice</span>
    </h4>

    <ul class="list-group mb-3 cart_products position-relative">

      @foreach ($remainingItems as $item)
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">{{ $item->product_name }}</h6>
            <small class="text-muted">Quantity: {{ $item->product_quantity }}</small>
          </div>
          <span class="text-muted">${{ $item->product_price * $item->product_quantity }}</span>
        </li>
      @endforeach

      @if ($order->coupon)
        <div class="display_coupon">
          <li class="list-group-item d-flex justify-content-between bg-light">
              <div class="text-success">
                <h6 class="my-0">Coupon </h6>
                <small class="coupon_code">{{ $order->coupon->coupon_name }} {{ $order->coupon->discount }}%</small>
              </div>        
              <span class="text-success">-$<span class="">{{ $discount }}</span></span>
          </li>
        </div>
      @endif

      @if ($shipment->rates)
      <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
          <h6 class="my-0">Shipping Cost</h6>
          <small class="text-muted rate_provider">
            {{  $shipment->rates[0]->servicelevel->name . ' ' .  $shipment->rates[0]->provider }}
          </small> <br>
          <small class="text-muted rate_days"> {{  $shipment->rates[0]->estimated_days  }} days</small>
        </div>
        <span class="text-muted rate_amount">${{ $shipment->rates[0]->amount }}</span>
      </li>
      @endif
  
      <li class="list-group-item d-flex justify-content-between">
        <span>Total</span>
        <strong>$<span class="total_pay">{{  number_format($subtotal - $discount + $shipment->rates[0]->amount, 2) }}</span></strong>
      </li>
    </ul>

    @else
      <input type="hidden" name="cancelAll" value="true">
      <div><strong>Are You Sure You Want To Cancel The Whole Order ?</strong></div>
    @endif
  </div>
  