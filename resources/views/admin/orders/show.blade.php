@extends('admin.admin_layouts')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40">
              <h6 class="card-body-title">Order Details </h6>
              <div class="row">

                  <div class="col-md-6">
                      @include('pages.orders.billing_details')
                  </div>

                  <div class="col-md-6">
                      @include('pages.orders.shipping_details')
                  </div>
              </div>

              <div class="row">
                  @include('pages.orders.product_details')
              </div>

              @include('admin.orders.order_status_form')
          </div>
      </div>
  </div>
@endsection
