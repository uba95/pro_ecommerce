<form action ='{{ route('payment.store') }}' method="POST">
  @csrf
  <input type="hidden" name="payment_method"  value="cash">
  <input type="hidden" name="rate_object_id"  value="{{ $shipment->rates[0]->object_id }}">
  <input type="hidden" name="billing_address"  value="{{ $addresses[0]->id}}">
  <input type="hidden" name="shipping_address"  value="{{ $addresses[0]->id}}">

  <button type="submit" class="btn btn-success">
    <i class="fas fa-chevron-circle-right"></i>
    Cash On Delivery
  </button>
</form>
