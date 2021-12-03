@extends('layouts.admin.index')
@section('admin_content')

<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
            <div class="d-flex align-items-center mb-2">
                <h6 class="card-body-title m-0 mr-2">Order Details </h6>
                @if ($order->status != 'canceled')
                    <a href='{{ route('admin.orders.invoice', $order->id) }}'>download invoice</a>
                @endif
            </div>
            <div class="row">
                <div class="col-md-6">
                    @include('pages.orders.billing_details')
                </div>

                <div class="col-md-6">
                    @include('pages.orders.shipping_details')
                </div>
            </div>

            @if ($order->status != 'canceled')
            <div class="row">
                @include('pages.orders.product_details')
            </div>
            @endif

            @include('admin.orders.order_status_form')
        </div>
    </div>
</div>
@endsection