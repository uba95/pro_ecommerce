@extends('admin.admin_layouts')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40">
                <h6 class="card-body-title">Return Order Details </h6>
                <div class="row">

                    <div class="col-md-6">
                        @include('pages.orders.return.billing_details')
                    </div>

                    <div class="col-md-6">
                        @include('pages.orders.return.shipping_details', ['request' => $returnOrderRequest])
                    </div>
                </div>

                <div class="row">
                    @include('pages.orders.return.product_details')
                    @include('layouts.orders.return_reason')
                </div>

                @include('admin.orders.return_order_status_form', ['request' => $returnOrderRequest])
          </div>
      </div>
  </div>
@endsection
