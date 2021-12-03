@extends('layouts.home')
@section('section')
<div class="col-8 card">
   
  <h4 class="card-body-title text-primary p-3">Cancel Order Details</h4>

  <div class="row">
      <div class="col-md-6 p-0">
        @include('pages.orders.cancel.billing_details', ['cancelOrderRequest' => $cancelOrder])
      </div>

      <div class="col-md-6 p-0">
        @include('pages.orders.cancel.shipping_details', ['cancelOrderRequest' => $cancelOrder])
      </div>
  </div>

  <div class="row mt-4">
    @include('pages.orders.cancel.product_details', ['cancelOrderRequest' => $cancelOrder])
  </div>
    
</div>


@endsection
