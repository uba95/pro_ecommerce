@extends('layouts.home')
@section('section')
<div class="col-8 card">
   
    <div class="d-flex align-items-center mb-2 p-3">
        <h4 class="card-body-title text-primary m-0 mr-2">Order Details</h4>
        @if ($order->status != 'canceled')
            <a href='{{ route('orders.invoice', $order->id) }}' class="text-dark">download invoice</a>
        @endif
    </div>

    <div class="row">
        <div class="col-md-6 p-0">
            @include('pages.orders.billing_details')
        </div>

        <div class="col-md-6 p-0">
            @include('pages.orders.shipping_details')
        </div>
    </div>

    @if ($order->status != 'canceled')
        <div class="row mt-4">
            @include('pages.orders.product_details')
        </div>
    @endif

</div>
@endsection