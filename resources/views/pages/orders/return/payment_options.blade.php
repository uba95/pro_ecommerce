<div class="custom-control mb-3">
  @include('pages.orders.return.stripe') 
</div>
<div class="custom-control mb-3">
  <button type="submit" class="btn text-white" style="background-color: #3b7bbf" formaction="{{ route('return_orders.store', ['payment_method'=>'paypal']) }}">
    <i class="fas fa-chevron-circle-right"></i>
    Pay With Paypal
  </button>  
</div>
<div class="custom-control mb-3">
  <button type="submit" class="btn btn-success" formaction="{{ route('return_orders.store', ['payment_method'=>'cash']) }}">
    <i class="fas fa-chevron-circle-right"></i>
    Cash On Delivery
  </button>  
</div> 
<input type="hidden" name="rate_object_id"  value="">
<input type="hidden" name="billing_address"  value="">
<input type="hidden" name="shipping_address"  value="">
