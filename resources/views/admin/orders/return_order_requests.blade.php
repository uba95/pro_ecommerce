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
                  <th class="wd-15p">Requset</th>
                  <th class="wd-15p">Order</th>
                  <th class="wd-15p">Customer</th>
                  <th class="wd-15p">Payment Method</th>
                  <th class="wd-15p">Order Price</th>
                  <th class="wd-20p">Requset Date</th>
                  <th class="wd-20p">Order Date</th>
                  <th class="wd-20p">Requset Status</th>
                  <th class="wd-20p">Order Status</th>
                </tr>
              </thead>
              <tbody>
    
                @foreach($return_order_requests as $key => $request)
                <tr>
                  <td>
                    <a class="" href ='{{ route('admin.return_orders.show', $request->id) }}'>
                      Request#{{ $request->id }}
                    </a>
                  </td>
                  <td>
                    <a class="" href ='{{ route('admin.orders.show', $request->order_id) }}'>
                      Order#{{ $request->order_id }}
                    </a>
                  </td>
                  <td>{{ $request->order->user->name }}</td>
                  <td>{{ $request->order->payment_method }}</td>
                  <td><span class="badge badge-success" style="font-size: 85%">{{  $request->order->total_price }} $</span></td>
                  <td>{{ $request->created_at->diffForHumans() }} </td>
                  <td>{{ $request->order->created_at->diffForHumans() }} </td>
                  <td>
                    @include('layouts.orders.return_order_request_status')  
                  </td>
                  <td>
                    @include('layouts.orders.order_status', ['order' => $request->order])
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