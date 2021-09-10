@extends('layouts.admin.index')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40 overflow-hidden">
                <h6 class="card-body-title">Return Order Details </h6>
                <div class="row">

                    <div class="col-md-6">
                        @include('pages.orders.return.billing_details', ['returnOrderRequest' => $returnOrder])
                    </div>

                    <div class="col-md-6">
                        @include('pages.orders.return.shipping_details', ['returnOrderRequest' => $returnOrder])
                    </div>
                </div>

                <div class="row">
                    @include('pages.orders.return.product_details', ['returnOrderRequest' => $returnOrder])
                    @include('layouts.orders.return_reason', ['returnOrderRequest' => $returnOrder])
                </div>

                @can('edit orders')
                    @include('admin.orders.return_order_status_form', ['request' => $returnOrder])
                @endcan
          </div>
      </div>
  </div>
@endsection
