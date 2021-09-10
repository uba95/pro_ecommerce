@extends('layouts.admin.index')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40 overflow-hidden">
                <h6 class="card-body-title">Cancel Order Details </h6>

                <div class="row">
                    <div class="col-8 card">
                        <h4 class="card-body-title text-primary p-3">Cancel Order Items </h4>
                        <div>Created At :  {{ $cancelOrder->created_at }} 
                            <small class="mx-2">
                                {{ $cancelOrder->created_at->diffForHumans() }}
                            </small>
                        </div>
                            <div class="card col-lg-12 p-0">
                            <div class="table-wrapper">
                                <table class="table display responsive nowrap">
                                <thead>
                                    <tr>
                                    <th class="wd-15p">Cancel Order Item #</th>
                                    <th class="wd-15p">Order Item #</th>
                                    <th class="wd-15p">Product Name</th>
                                    <th class="wd-15p">Quantity</th>
                                    <th class="wd-15p">Unit Price</th>
                                    <th class="wd-20p">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cancelOrderItems as $cancelOrderItem)
                                    <tr>
                                    <td>{{ $cancelOrderItem->id }}</td>
                                    <td>{{ $cancelOrderItem->orderItem->id }}</td>
                                    <td>{{ $cancelOrderItem->orderItem->product->product_name }}</td>
                                    <td>{{ $cancelOrderItem->product_quantity }}</td>
                                    <td>{{ $cancelOrderItem->orderItem->product_price }}$</td>
                                    <td>{{ $cancelOrderItem->totalPrice }}$</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div><!-- table-wrapper -->
                        </div><!-- card -->
                    </div>
                
                </div>
                @can('edit orders')
                    @include('admin.orders.cancel_order_status_form', ['request' => $cancelOrder])
                @endcan
          </div>
      </div>
  </div>
@endsection
