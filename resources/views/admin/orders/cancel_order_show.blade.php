@extends('layouts.admin.index')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40 overflow-hidden">
                <h6 class="card-body-title">Cancel Order Details </h6>
                <div class="row">

                    <div class="col-md-6">
                        @include('pages.orders.cancel.billing_details', ['cancelOrderRequest' => $cancelOrder])
                    </div>

                    <div class="col-md-6">
                        @include('pages.orders.cancel.shipping_details', ['cancelOrderRequest' => $cancelOrder])
                    </div>
                </div>

                <div class="row">
                    @include('pages.orders.cancel.product_details', ['cancelOrderRequest' => $cancelOrder])
                </div>

                @can('edit orders')
                @include('admin.orders.cancel_order_status_form', ['request' => $cancelOrder])
                @endcan
          </div>
      </div>
  </div>
@endsection
