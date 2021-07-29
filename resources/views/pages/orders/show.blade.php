@extends('layouts.home')
@section('section')
<div class="col-8 card">
    <h4 class="card-body-title text-primary p-3">Order Details </h4>
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