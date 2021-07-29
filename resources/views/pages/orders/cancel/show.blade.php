@extends('layouts.home')
@section('section')

    <div class="col-8 card">
        <h4 class="card-body-title text-primary p-3">Cancel Order Details </h4>
        <div class="row">
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
                        <td>{{ $cancelOrderItem->orderItem->product_name }}</td>
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
@endsection
