<form action ='{{ route('payment.store') }}' method="POST">
  @csrf
  <input type="hidden" name="payment_method"  value="paypal">
  <input type="hidden" name="rate_object_id"  value="{{ $shipment->rates[0]->object_id }}">
  <input type="hidden" name="billing_address"  value="{{ $addresses[0]->id}}">
  <input type="hidden" name="shipping_address"  value="{{ $addresses[0]->id}}">

  <button type="submit" class="btn text-white" style="background-color: #3b7bbf">
    <i class="fas fa-chevron-circle-right"></i>
    Pay With Paypal
  </button>  
</form>
