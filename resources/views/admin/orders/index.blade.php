@extends('admin.admin_layouts')

@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Order Details</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Order List</h6>
           
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Order ID</th>
                  <th class="wd-15p">Customer</th>
                  <th class="wd-15p">Payment Method</th>
                  <th class="wd-15p">Total Price</th>
                  <th class="wd-20p">Date</th>
                  <th class="wd-20p">Status</th>
                  <th class="wd-20p">Action</th>
                </tr>
              </thead>
              <tbody>
    
                @foreach($orders as $key => $order)
                <tr>
                  <td>{{ $order->id }}</td>
                  <td>{{ $order->user->name }}</td>
                  <td>{{ $order->payment_method }}</td>
                  <td><span class="badge badge-success" style="font-size: 85%">{{ $order->total_price }} $</span></td>
                  <td>{{ $order->created_at->diffForHumans() }}  </td>
                  <td>
                    @include('layouts.orders.order_status')
                  </td>
                  <td>
                    <a href='{{ route('admin.orders.show', $order->id) }}' class="btn btn-sm btn-info">View</a>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
    </div><!-- sl-pagebody -->
  </div><!-- sl-mainpanel -->
@endsection